<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ApiProviderRequest;
use App\Support\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiProviderController extends Controller
{
    public function index()
    {
        $apiProviders = Auth::user()->apiProviders()->latest('id')->paginate(15);

        return view('panel.apiProviders.index', [
            'apiProviders' => $apiProviders,
        ]);
    }

    public function create()
    {
        if (Auth::user()->userPlan()->where('active', 1)->where('plan_id', 2)->count() == 1) {
            return view('panel.apiProviders.create');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->userPlan()->where('active', 1)->where('plan_id', 2)->count() == 0) {
            return response()->json([
                'status' => 'Error'
            ], 403);
        }

        $smm = new Smm($request->url, $request->key);
        $smm->balance();
        $smmCallback = $smm->callback();

        if (!isset($smmCallback->balance)) {
            return response()->json([
                'errors' => [
                    'key' => 'Parece haver um problema de conexão com o provedor de API. Verifique a chave API e a URL novamente!'
                ]
            ], 422);
        }

        $apiProvider = Auth::user()->apiProviders()->create($request->all());
        $apiProvider->url = $request->url;
        $apiProvider->balance = $smmCallback->balance;
        $apiProvider->status = true;
        $apiProvider->update();

        return response()->json('Editado com sucesso!');
    }

    public function edit(Request $request)
    {
        $apiProvider = Auth::user()->apiProviders()->findOrFail($request->apiProvider);
        return view('panel.apiProviders.edit', [
            'apiProvider' => $apiProvider
        ]);
    }

    public function update(ApiProviderRequest $request)
    {
        $apiProvider = Auth::user()->apiProviders()->findOrFail($request->apiProvider);

        $smm = new Smm($apiProvider->url, $request->key);
        $smm->balance();
        $smmCallback = $smm->callback();

        if (!isset($smmCallback->balance)) {
            return response()->json([
                'errors' => [
                    'key' => 'Parece haver um problema de conexão com o provedor de API. Verifique a chave API e a URL novamente!'
                ]
            ], 422);
        }

        $apiProvider->fill($request->all());
        $apiProvider->balance = $smmCallback->balance;
        $apiProvider->status = true;
        $apiProvider->update();

        return response()->json('Editado com sucesso!');
    }
}
