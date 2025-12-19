<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UserRequest;
use App\Models\ApiProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());

        $apiProvider = new ApiProvider();
        $apiProvider->user_id = $user->id;
        $apiProvider->url = 'https://revendadireta.com/api/v2';
        $apiProvider->balance = 0;
        $apiProvider->save();

        Auth::login($user, true);

        $route = route('panel.index');

        return response()->json([
            'success' => true,
            'redirect' => $route
        ], 201);
    }

    public function edit()
    {
        return view('panel.users.edit');
    }

    public function update(UserRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->setImage($request->file('image'));
        $user->update();

        return redirect()->back()->withSuccess('Perfil atualizado com sucesso!');

    }

    public function verifyDomain(Request $request)
    {
        $user = User::where('domain', $request->domain)->count();

        return response()->json([
            'count' => $user
        ]);
    }

    public function disablePopup()
    {
        $user = Auth::user();
        $user->popup_show = false;
        $user->update();

        return response()->json('success');
    }
}
