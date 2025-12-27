<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SystemSettingController extends Controller
{
    public function template(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $planPurchase = $user->planPurchase()->active()->where('plan_id', 3)->count();

        if ($planPurchase == 0 && $request->userAgent() == 'domain') {
            abort(403);
        }

        $payment = $user->payment()->first();

        // Buscamos as categorias e serviços com cache
        $categories = Cache::rememberForever('systemSettingCategories.' . $user->id, function () use ($user) {
            return $user->categories()->with(['services' => function ($query) {
                $query->oldest('quantity')->active();
            }])->active()->oldest('order')->get();
        });

        $systemSetting = Cache::rememberForever('systemSetting.' . $user->id, function () use ($user) {
            return $user->systemSetting()->first();
        });

        if ($systemSetting) {
            $template = Cache::rememberForever('systemSettingTemplate.' . $systemSetting->template_id, function () use ($systemSetting) {
                return $systemSetting->template()->first();
            });
        } else {
            $template = Template::first();
        }

        $configTemplate = Cache::rememberForever('configTemplate.' . $user->id, function () use ($user) {
            return $user->configTemplate()->first();
        });

        $conversionTag = $user->conversionTag()->first();

        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();
        $hash = md5($ipFixed . $user->domain);

        $cartProductsCount = CartProduct::where('hash', $hash)->count();

        // ---------------------------------------------------------
        // GERAÇÃO DO JSON PARA O FRONT-END (servicesData)
        // ---------------------------------------------------------
        $servicesData = [];

        foreach ($categories as $category) {
            foreach ($category->services as $service) {
                // Normalização da rede social
                $networkRaw = strtolower(trim($service->network));

                // Mapeamento simples para garantir compatibilidade com os IDs do front-end
                $networkKey = match(true) {
                    str_contains($networkRaw, 'insta') => 'instagram',
                    str_contains($networkRaw, 'tik')   => 'tiktok',
                    str_contains($networkRaw, 'you')   => 'youtube',
                    str_contains($networkRaw, 'kwai')  => 'kwai',
                    str_contains($networkRaw, 'face')  => 'facebook',
                    str_contains($networkRaw, 'twit')  => 'twitter',
                    str_contains($networkRaw, 'threa') => 'threads',
                    default => $networkRaw,
                };

                if (empty($networkKey)) {
                    continue;
                }

                // Inicializa a rede se não existir
                if (!isset($servicesData[$networkKey])) {
                    $servicesData[$networkKey] = [
                        'name' => ucfirst($networkKey),
                        'categories' => []
                    ];
                }

                // Slug único para a categoria (Nome + ID para evitar conflitos)
                $categoryKey = Str::slug($category->name . '-' . $category->id);

                // Inicializa a categoria dentro da rede se não existir
                if (!isset($servicesData[$networkKey]['categories'][$categoryKey])) {
                    $servicesData[$networkKey]['categories'][$categoryKey] = [
                        'name'        => $category->name,
                        'description' => $category->description ?? 'Selecione o melhor pacote para você.',
                        'slug'        => $categoryKey,
                        'packages'    => []
                    ];
                }

                // Adiciona o pacote (serviço)
                $servicesData[$networkKey]['categories'][$categoryKey]['packages'][] = [
                    'id'          => $service->id,
                    'quantity'    => $service->quantity,
                    'amount'      => number_format($service->quantity, 0, '', '.'),
                    'price'       => 'R$ ' . number_format($service->price, 2, ',', '.'),
                    'discount'    => $service->discount > 0 ? $service->discount . '% OFF' : null,
                    'highlighted' => (bool) $service->highlighted,
                ];
            }
        }

        return view('templates.' . $template->path . '.index', [
            'categories'        => $categories,
            'systemSetting'     => $systemSetting,
            'user'              => $user,
            'configTemplate'    => $configTemplate,
            'payment'           => $payment,
            'cartProductsCount' => $cartProductsCount,
            'userAgentFixed'    => $userAgentFixed,
            'ipFixed'           => $ipFixed,
            'conversionTag'     => $conversionTag,
            'template'          => $configTemplate->content ?? [],
            'servicesData'      => $servicesData,
        ]);
    }
}
