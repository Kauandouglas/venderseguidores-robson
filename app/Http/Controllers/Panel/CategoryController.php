<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->oldest('order')->get();
        return view('panel.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('panel.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $categoriesCount = Auth::user()->categories()->count();

        $planPurchase = Auth::user()->planPurchase()->active()->count();

        if($planPurchase == 0){
            if ($categoriesCount >= 4) {
                return response()->json([
                    'errors' => [
                        'category' => 'Você só pode ter no máximo 4 categorias, para cadastrar mais categoria adquira o um plano'
                    ]
                ], 422);
            }
        }

        $category = Auth::user()->categories()->create($request->all());
        return response()->json('Cadastrado com sucesso!', 201);
    }

    public function edit(Request $request)
    {
        $category = Auth::user()->categories()->findOrFail($request->category);
        return view('panel.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request)
    {
        $category = Auth::user()->categories()->findOrFail($request->category);
        $category->fill($request->all());
        $category->update();

        return response()->json('Editado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $apiProvider = Auth::user()->categories()->findOrFail($request->category);
        $apiProvider->delete();

        return redirect()->back()->withSuccess('Removido com sucesso!');
    }

    public function order(Request $request)
    {
        $order = 1;
        foreach ($request->categories as $category) {
            Cache::forget('systemSettingCategories.' . Auth::id());
            $category = Auth::user()->categories()->where('id', $category)->update(['order' => $order]);
            $order++;
        }
    }
}
