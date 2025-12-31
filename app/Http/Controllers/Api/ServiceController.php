<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    private $rapidApiHost;
    private $rapidApiKey;
    private $baseUrl;

    public function __construct()
    {
        // As chaves devem ser configuradas no seu arquivo .env
        $this->rapidApiHost = 'instagram-social-api.p.rapidapi.com';
        $this->rapidApiKey = 'fac0745917msh600060d572c5142p1d4d30jsna362d64f9a44';
        $this->baseUrl = "https://{$this->rapidApiHost}/v1";
    }

    public function show(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $service = $user->services()->findOrFail($request->service);
        $categories = Cache::rememberForever('systemSettingCategories.' . $user->id, function () use ($user) {
            return $user->categories()->with(['services' => function ($query) {
                $query->oldest('quantity')->active();
            }])->active()->oldest('order')->get();
        });

        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        return view('templates.zinc-clear.services.show', [
            'service' => $service,
            'categories' => $categories,
            'user' => $user,
            'userAgentFixed' => $userAgentFixed,
            'ipFixed' => $ipFixed
        ]);
    }

    private function makeRapidApiRequest(string $endpoint, array $params = [])
    {
        return Http::withHeaders([
            'x-rapidapi-host' => $this->rapidApiHost,
            'x-rapidapi-key' => $this->rapidApiKey,
        ])->get("{$this->baseUrl}{$endpoint}", $params);
    }

    public function validateUser(Request $request)
    {
        $username = $request->input('username');

        if (empty($username)) {
            return response()->json([
                'success' => false,
                'message' => 'O nome de usuário é obrigatório.'
            ], 400);
        }

        // Endpoint assumido para obter informações do usuário
        $response = $this->makeRapidApiRequest('/info', ['username_or_id_or_url' => $username]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                // 404 indica que o usuário não existe
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário do Instagram não encontrado.'
                ]);
            }
            // Outros erros de API
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar informações do usuário. Código HTTP: ' . $response->status()
            ], 500);
        }

        $data = $response->json('data');
        $isPrivate = $data['is_private'] ?? true;

        if ($isPrivate) {
            return response()->json([
                'success' => false,
                'message' => 'O perfil do Instagram é privado.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuário válido e perfil público.',
            'username' => $data['username'] ?? $username,
            'full_name' => $data['full_name'] ?? '',
            'display_url' => $data['profile_pic_url'],
        ]);
    }

        public function validatePost(Request $request)
    {
        $postIdentifier = $request->input('post_identifier');

        if (empty($postIdentifier)) {
            return response()->json([
                'success' => false,
                'message' => 'O código ou URL do post é obrigatório.'
            ], 400);
        }

        $response = $this->makeRapidApiRequest('/post_info', ['code_or_id_or_url' => $postIdentifier]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                // 404 indica que o post não existe
                return response()->json([
                    'success' => false,
                    'message' => 'Post do Instagram não encontrado ou inválido.'
                ]);
            }
            // Outros erros de API
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar informações do post. Código HTTP: ' . $response->status()
            ], 500);
        }

        $data = $response->json('data');

        return response()->json([
            'success' => true,
            'message' => 'Post válido encontrado.',
            'post_data' => [
                'code' => $data['code'] ?? $postIdentifier,
                'owner_username' => $data['owner']['username'] ?? 'N/A',
                'media_type' => $data['media_type'] ?? 'N/A'
            ]
        ]);
    }

    public function listPosts(Request $request)
    {
        $username = $request->input('username');

        if (empty($username)) {
            return response()->json([
                'success' => false,
                'message' => 'O nome de usuário é obrigatório.'
            ], 400);
        }

        $response = $this->makeRapidApiRequest('/posts', ['username_or_id_or_url' => $username]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                // 404 indica que o usuário não existe ou não tem posts
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado ou sem posts públicos recentes.'
                ]);
            }
            // Outros erros de API
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar posts. Código HTTP: ' . $response->status()
            ], 500);
        }

        $items = $response->json('data.items', []);
        $postList = [];

        // Filtra e formata os dados dos posts
        foreach ($items as $post) {
            $postList[] = [
                'post_code' => $post['code'] ?? null,
                'caption' => $post['caption']['text'] ?? 'Sem legenda',
                'media_type' => $post['media_type'] ?? null, // 1: Foto, 2: Vídeo, 8: Carrossel
                'like_count' => $post['like_count'] ?? 0,
                'display_url' => $post['image_versions']['items'][0]['url'] ?? null,
                'post_url' => "https://www.instagram.com/p/" . ($post['code'] ?? '')
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Posts listados com sucesso.',
            'post_count' => count($postList),
            'posts' => $postList
        ]);
    }
}
