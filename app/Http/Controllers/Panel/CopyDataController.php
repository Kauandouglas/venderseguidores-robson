<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CopyDataController extends Controller
{
    /**
     * Copia todas as categorias e serviços do usuário ID 18 para o usuário autenticado.
     */
    public function copyFromTemplate(Request $request)
    {
        $sourceUserId = 18; // Hardcoded conforme solicitado
        $targetUserId = Auth::id();

        // Verifica se o usuário de origem existe
        $sourceUser = User::findOrFail($sourceUserId);

        try {
            DB::beginTransaction();

            // Busca todas as categorias do usuário de origem
            $sourceCategories = $sourceUser->categories()->with('services')->get();

            foreach ($sourceCategories as $sourceCategory) {
                // Cria nova categoria para o usuário alvo
                $newCategory = $sourceCategory->replicate();
                $newCategory->user_id = $targetUserId;
                $newCategory->save();

                // Copia todos os serviços da categoria
                foreach ($sourceCategory->services as $sourceService) {
                    $newService = $sourceService->replicate();
                    $newService->user_id = $targetUserId;
                    $newService->category_id = $newCategory->id;
                    $newService->save();
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Categorias e serviços copiados com sucesso! ' . $sourceCategories->count() . ' categorias importadas.',
                'categories_count' => $sourceCategories->count()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao copiar dados: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Copia uma categoria específica (e seus serviços) do usuário template para o usuário autenticado.
     */
    public function copyCategoryFromTemplate(Request $request)
    {
        $sourceUserId = 18; // Usuário template
        $targetUserId = Auth::id();
        $categoryId = $request->input('category_id');

        if (!$categoryId) {
            return response()->json(['message' => 'Categoria não informada.'], 400);
        }

        $sourceUser = User::findOrFail($sourceUserId);
        $sourceCategory = $sourceUser->categories()->with('services')->find($categoryId);
        if (!$sourceCategory) {
            return response()->json(['message' => 'Categoria não encontrada no template.'], 404);
        }

        try {
            DB::beginTransaction();

            // Clona a categoria
            $newCategory = $sourceCategory->replicate();
            $newCategory->user_id = $targetUserId;
            $newCategory->save();

            // Clona todos os serviços da categoria
            foreach ($sourceCategory->services as $sourceService) {
                $newService = $sourceService->replicate();
                $newService->user_id = $targetUserId;
                $newService->category_id = $newCategory->id;
                $newService->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Categoria e serviços clonados com sucesso!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao clonar categoria: ' . $e->getMessage()
            ], 500);
        }
    }
}
