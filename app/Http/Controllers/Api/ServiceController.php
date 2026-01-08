<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ServiceController extends Controller
{
    private $rapidApiHostInsta;
    private $rapidApiHostTiktok;
    private $rapidApiKey;
    private $baseUrlInsta;
    private $baseUrlTiktok;

    public function __construct()
    {
        // 🔒 Configure as chaves no .env — aqui apenas como fallback
        $this->rapidApiHostInsta = 'instagram-social-api.p.rapidapi.com';
        $this->rapidApiHostTiktok = 'tiktok-scraper7.p.rapidapi.com';
        $this->rapidApiKey = 'fac0745917msh600060d572c5142p1d4d30jsna362d64f9a44';

        $this->baseUrlInsta = "https://{$this->rapidApiHostInsta}/v1";
        $this->baseUrlTiktok = "https://{$this->rapidApiHostTiktok}";
    }

    // 🔹 Função utilitária
    private function makeRapidApiRequest(string $host, string $endpoint, array $params = [])
    {
        return Http::withHeaders([
            'x-rapidapi-host' => $host,
            'x-rapidapi-key' => $this->rapidApiKey,
        ])->get("https://{$host}{$endpoint}", $params);
    }

    // ======================================================
    // 📸 INSTAGRAM
    // ======================================================

    public function validateUser(Request $request)
    {
        $username = $request->input('username');
        if (empty($username)) {
            return response()->json(['success' => false, 'message' => 'O nome de usuário é obrigatório.'], 400);
        }

        $response = $this->makeRapidApiRequest($this->rapidApiHostInsta, '/v1/info', ['username_or_id_or_url' => $username]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                return response()->json(['success' => false, 'message' => 'Usuário do Instagram não encontrado.']);
            }
            return response()->json(['success' => false, 'message' => 'Erro ao buscar informações do usuário. Código HTTP: ' . $response->status()], 500);
        }

        $data = $response->json('data');
        $isPrivate = $data['is_private'] ?? true;

        if ($isPrivate) {
            return response()->json(['success' => false, 'message' => 'O perfil do Instagram é privado.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuário válido e perfil público.',
            'username' => $data['username'] ?? $username,
            'full_name' => $data['full_name'] ?? '',
            'display_url' => $data['profile_pic_url'] ?? null,
        ]);
    }

    public function validatePost(Request $request)
    {
        $postIdentifier = $request->input('post_identifier');
        if (empty($postIdentifier)) {
            return response()->json(['success' => false, 'message' => 'O código ou URL do post é obrigatório.'], 400);
        }

        $response = $this->makeRapidApiRequest($this->rapidApiHostInsta, '/v1/post_info', ['code_or_id_or_url' => $postIdentifier]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                return response()->json(['success' => false, 'message' => 'Post do Instagram não encontrado ou inválido.']);
            }
            return response()->json(['success' => false, 'message' => 'Erro ao buscar informações do post. Código HTTP: ' . $response->status()], 500);
        }

        $data = $response->json('data');
        return response()->json([
            'success' => true,
            'message' => 'Post válido encontrado.',
            'post_data' => [
                'code' => $data['code'] ?? $postIdentifier,
                'owner_username' => $data['owner']['username'] ?? 'N/A',
                'media_type' => $data['media_type'] ?? 'N/A',
            ]
        ]);
    }

    public function listPosts(Request $request)
    {
        $username = $request->input('username');
        if (empty($username)) {
            return response()->json(['success' => false, 'message' => 'O nome de usuário é obrigatório.'], 400);
        }

        $response = $this->makeRapidApiRequest($this->rapidApiHostInsta, '/v1/posts', ['username_or_id_or_url' => $username]);

        if ($response->failed()) {
            if ($response->status() === 404) {
                return response()->json(['success' => false, 'message' => 'Usuário não encontrado ou sem posts públicos recentes.']);
            }
            return response()->json(['success' => false, 'message' => 'Erro ao buscar posts. Código HTTP: ' . $response->status()], 500);
        }

        $items = $response->json('data.items', []);
        $postList = [];
        foreach ($items as $post) {
            $postList[] = [
                'post_code' => $post['code'] ?? null,
                'caption' => $post['caption']['text'] ?? 'Sem legenda',
                'media_type' => $post['media_type'] ?? null,
                'like_count' => $post['like_count'] ?? 0,
                'display_url' => $post['image_versions']['items'][0]['url'] ?? null,
                'post_url' => "https://www.instagram.com/p/" . ($post['code'] ?? ''),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Posts listados com sucesso.',
            'post_count' => count($postList),
            'posts' => $postList,
        ]);
    }

    // ======================================================
    // 🎵 TIKTOK
    // ======================================================

    public function validateTiktokUser(Request $request)
    {
        $username = $request->input('username');
        if (empty($username)) {
            return response()->json(['success' => false, 'message' => 'O nome de usuário do TikTok é obrigatório.'], 400);
        }

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
            'x-rapidapi-key' => '69d89efd37msh4065cea386c7d43p166fe8jsncfc50d662cdb',
        ])->get('https://tiktok-scraper7.p.rapidapi.com/user/info', [
            'unique_id' => $username,
        ]);

        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Erro ao buscar informações do usuário. Código HTTP: ' . $response->status()], 500);
        }

        $data = $response->json('data.user') ?? null;
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Usuário do TikTok não encontrado.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuário válido do TikTok.',
            'username' => $data['uniqueId'] ?? $username,
            'nickname' => $data['nickname'] ?? '',
            'avatar' => $data['avatarThumb'] ?? '',
            'verified' => $data['verified'] ?? false,
            'privateAccount' => $data['privateAccount'] ?? false,
        ]);
    }

    public function validateTiktokPost(Request $request)
    {
        $url = $request->input('url');
        if (empty($url)) {
            return response()->json(['success' => false, 'message' => 'A URL do vídeo é obrigatória.'], 400);
        }

        $encodedUrl = urlencode($url);

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
            'x-rapidapi-key' => '69d89efd37msh4065cea386c7d43p166fe8jsncfc50d662cdb',
        ])->get("https://tiktok-scraper7.p.rapidapi.com/comment/list?url={$encodedUrl}&count=1&cursor=0");

        if ($response->failed()) {
            return response()->json(['success' => false, 'message' => 'Erro ao buscar vídeo no TikTok. Código HTTP: ' . $response->status()], 500);
        }

        $data = $response->json();
        if (($data['code'] ?? 1) !== 0) {
            return response()->json(['success' => false, 'message' => 'Vídeo do TikTok não encontrado ou inválido.']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vídeo válido encontrado no TikTok.',
            'comment_count' => count($data['data']['comments'] ?? []),
        ]);
    }

    public function listTiktokPosts(Request $request)
    {
        $username = $request->input('username');

        if (empty($username)) {
            return response()->json([
                'success' => false,
                'message' => 'O nome de usuário é obrigatório.'
            ], 400);
        }

        // Faz a requisição real
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'tiktok-scraper7.p.rapidapi.com',
            'x-rapidapi-key' => '69d89efd37msh4065cea386c7d43p166fe8jsncfc50d662cdb',
        ])->get('https://tiktok-scraper7.p.rapidapi.com/user/posts', [
            'unique_id' => $username,
            'count' => 10,
            'cursor' => 0
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar vídeos. Código HTTP: ' . $response->status()
            ], 500);
        }

        $data = $response->json();
        if (($data['code'] ?? 1) !== 0 || empty($data['data']['videos'])) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum vídeo público encontrado.'
            ]);
        }

        $videos = [];
        foreach ($data['data']['videos'] as $video) {
            $videos[] = [
                'id' => $video['video_id'] ?? null,
                'title' => $video['title'] ?? '',
                'cover' => $video['cover'] ?? '',
                'views' => $video['play_count'] ?? 0,
                'likes' => $video['digg_count'] ?? 0,
                'comments' => $video['comment_count'] ?? 0,
                'shares' => $video['share_count'] ?? 0,
                'author' => $video['author']['nickname'] ?? '',
                'video_url' => "https://www.tiktok.com/@{$video['author']['unique_id']}/video/{$video['video_id']}",
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Vídeos listados com sucesso.',
            'count' => count($videos),
            'videos' => $videos
        ]);
    }
}
