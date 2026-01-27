<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


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
            $query->active()->oldest('order');
        }])->active()->oldest('order')->get();
    });

    $systemSetting = Cache::rememberForever('systemSetting.' . $user->id, function () use ($user) {
        return $user->systemSetting()->first();
    });

    $sociais = $user->categories()
        ->where('status', 1)
        ->with(['services' => function ($query) {
            $query->active()->oldest('order');
        }])
        ->oldest('order')
        ->get()
        ->groupBy('social_network');

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

    // Usa session_id para garantir carrinho único por navegador
    $sessionId = $request->session()->getId();
    $hash = md5($sessionId . $user->domain);

    $cartProductsCount = CartProduct::where('hash', $hash)->count();

    // ===============================
    // Montar servicesData dinamicamente
    // ===============================
    $servicesData = [];

    foreach ($sociais as $network => $cats) {
        $servicesData[$network] = ['categories' => []];

        foreach ($cats as $category) {
            $servicesData[$network]['categories'][Str::slug($category->name . '-' . $category->id)] = [
                'name' => $category->name,
                'slug' => Str::slug($category->name . '-' . $category->id),
                'description' => 'Comprar Serviço - ' . $category->name,
                'packages' => $category->services->sortBy('order')->map(function($service) {
                    return [
                        'id' => $service->id,
                        'amount' => $service->quantity,
                        'quantity' => $service->quantity,
                        'price' => 'R$' . number_format($service->price, 2, ',', '.'),
                        'highlighted' => $service->highlighted ?? false,
                        'discount' => $service->discount ?? null,
                    ];
                })->toArray(),
            ];
        }
    }

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
        'sociais' => $sociais,
        'servicesData' => $servicesData // <-- Passando pro Blade
    ]);
}

}
