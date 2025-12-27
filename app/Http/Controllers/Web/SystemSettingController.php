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

        $servicesData = [];

        foreach ($categories as $category) {
            foreach ($category->services as $service) {
                // Normaliza a chave da rede social para bater com o data-platform do HTML
                $networkKey = strtolower(trim($service->network));

                if (empty($networkKey)) {
                    continue;
                }

                if (!isset($servicesData[$networkKey])) {
                    $servicesData[$networkKey] = [
                        'name' => ucfirst($networkKey),
                        'categories' => []
                    ];
                }

                // Usamos um slug consistente para a categoria
                $categoryKey = Str::slug($category->name . '-' . $category->id);

                if (!isset($servicesData[$networkKey]['categories'][$categoryKey])) {
                    $servicesData[$networkKey]['categories'][$categoryKey] = [
                        'name' => $category->name,
                        'description' => $category->description ?? '',
                        'slug' => $categoryKey,
                        'packages' => []
                    ];
                }

                // Adicionamos os campos necessários para o JavaScript
                $servicesData[$networkKey]['categories'][$categoryKey]['packages'][] = [
                    'id'          => $service->id,
                    'url'         => $service->id,
                    'quantity'    => $service->quantity, // Adicionado para bater com data-amount="${pkg.quantity}"
                    'amount'      => number_format($service->quantity, 0, '', '.'), // Formatado para exibição
                    'price'       => 'R$ ' . number_format($service->price, 2, ',', '.'),
                    'discount'    => $service->discount ?? null, // Garantindo que a chave exista
                    'highlighted' => (bool) $service->highlighted,
                ];
            }
        }
        // -----------------------------

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
            'servicesData' => $servicesData,
        ]);
    }
}
