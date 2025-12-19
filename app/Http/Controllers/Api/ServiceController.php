<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function show(Request  $request)
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
}
