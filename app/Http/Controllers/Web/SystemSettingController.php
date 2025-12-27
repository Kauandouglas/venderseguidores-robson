<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $servicesData = Cache::rememberForever('systemSettingCategories.' . $user->id, function () use ($user) {
            $allCategories = $user->categories()
                ->with(['services' => function ($query) {
                    $query->oldest('quantity')->active();
                }])
                ->active()
                ->oldest('order')
                ->get();

            $result = [];

            foreach ($allCategories as $category) {
                $social = $category->social_network; // ex: instagram, tiktok, etc.

                // Inicializa a rede social se não existir
                if (!isset($result[$social])) {
                    $result[$social] = [
                        'name' => ucfirst($social),
                        'categories' => []
                    ];
                }

                // Adiciona a categoria
                $result[$social]['categories'][$category->slug] = [
                    'name' => $category->name,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'packages' => $category->services->map(function($service) {
                        return [
                            'id' => $service->id,
                            'url' => $service->url ?? null,
                            'amount' => $service->quantity,
                            'price' => $service->price_formatted ?? null,
                            'discount' => $service->discount ?? null,
                            'highlighted' => $service->highlighted ?? false,
                        ];
                    })->toArray()
                ];
            }

            return $result;
        });

        return view('templates.' . $template->path . '.index', [
            'categories' => $categories,
            'systemSetting' => $systemSetting,
            'user' => $user,
            'configTemplate' => $configTemplate,
            'payment' => $payment,
            'cartProductsCount' => $cartProductsCount,
            'userAgentFixed' => $userAgentFixed,
            'ipFixed' => $ipFixed,
            'conversionTag' => $conversionTag,
            'template' => $configTemplate->content ?? [],
            'servicesData' => $servicesData
        ]);
    }
}
