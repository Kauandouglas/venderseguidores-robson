<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CartProductController extends Controller
{
    public function index(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();

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

        $categories = Cache::rememberForever('systemSettingCategories.' . $user->id, function () use ($user) {
            return $user->categories()->with(['services' => function ($query) {
                $query->oldest('quantity')->active();
            }])->active()->oldest('order')->get();
        });

        $payment = $user->payment()->first();

        $conversionTag = $user->conversionTag()->first();

        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProducts = CartProduct::with('service.category')->where('hash', $hash)->latest('id')->get();

        $sumProducts = [];
        foreach ($cartProducts as $cartProduct) {
            $sumProducts[] = $cartProduct->service->price;
        }

        $serviceDescount = $user->serviceDescounts()->where('price_min', '<=', array_sum($sumProducts))
            ->latest('price_min')->first();

        if (isset($serviceDescount->percent)) {
            $pricePercent = array_sum($sumProducts) - (array_sum($sumProducts) / 100 * $serviceDescount->percent);
        } else {
            $pricePercent = 0;
        }

        return view('templates.' . $template->path . '.cartProducts.index', [
            'categories' => $categories,
            'user' => $user,
            'systemSetting' => $systemSetting,
            'payment' => $payment ? json_decode($payment->data) : null,
            'sumProducts' => array_sum($sumProducts),
            'pricePercent' => $pricePercent,
            'userAgentFixed' => $userAgentFixed,
            'ipFixed' => $ipFixed,
            'conversionTag' => $conversionTag,
            'serviceDescount' => $serviceDescount
        ]);
    }

    public function fragmentIndex(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProducts = CartProduct::with('service.category')->where('hash', $hash)->latest('id')->get();

        $sumProducts = [];
        foreach ($cartProducts as $cartProduct) {
            $sumProducts[] = $cartProduct->service->price;
        }

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

        return view('templates.' . $template->path . '.fragments.cart', [
            'user' => $user,
            'cartProducts' => $cartProducts,
            'sumProducts' => array_sum($sumProducts),
            'userAgentFixed' => $userAgentFixed,
            'ipFixed' => $ipFixed
        ]);
    }

    public function addLink(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProduct = CartProduct::where('hash', $hash)->findOrFail($request->cartProduct);

        $cartProduct->link = $request->profile;
        $cartProduct->update();

        return response()->json([
            'sucess' => true
        ]);
    }

    public function addComment(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProduct = CartProduct::where('hash', $hash)->findOrFail($request->cartProduct);

        $cartProduct->comment = $request->comments;
        $cartProduct->update();

        return response()->json([
            'sucess' => true
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProduct = CartProduct::where('hash', $hash)->findOrFail($request->cartProduct);

        $cartProduct->delete();

        return response()->json([
            'sucess' => true
        ]);
    }

    public function addCoupon(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $discountCoupon = $user->discountCoupons()->where('cupom', $request->coupon)->first();

        if (!$discountCoupon) {
            return response()->json([
                'errors' => [
                    'Cupom inválido!'
                ]
            ], 422);
        }

        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        // Usa session_id para garantir carrinho único por navegador
        $sessionId = $request->session()->getId();
        $hash = md5($sessionId . $user->domain);
        $cartProducts = CartProduct::with('service.category')->where('hash', $hash)->latest('id')->get();

        $sumProducts = [];
        foreach ($cartProducts as $cartProduct) {
            $sumProducts[] = $cartProduct->service->price;
        }

        if ($discountCoupon->discount_type == 'percent') {
            $total = number_format(array_sum($sumProducts) - (array_sum($sumProducts) / 100 * $discountCoupon->percent), 2, ',', '');
        } else {
            $total = number_format(array_sum($sumProducts) - $discountCoupon->fixed_value, 2, ',', '');
        }

        Cache::put('coupon.' . $hash, $request->coupon, now()->addMinutes(30));

        return response()->json([
            'discount' => $discountCoupon->discount_type == 'percent' ? $discountCoupon->percent : $discountCoupon->fixed_value,
            'total' => $total
        ]);
    }
}
