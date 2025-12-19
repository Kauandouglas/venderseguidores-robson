<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ServiceRequest;
use App\Support\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->with(['services' => function ($query) {
            $query->with('apiProvider')->latest('id');
        }])->oldest('order')->get();

        return view('panel.services.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Auth::user()->categories()->latest('id')->get();
        $apiProviders = Auth::user()->apiProviders()->latest('id')->get();

        return view('panel.services.create', [
            'categories' => $categories,
            'apiProviders' => $apiProviders
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $serviceCount = Auth::user()->services()->where('category_id', $request->category_id)->count();
        $planPurchase = Auth::user()->planPurchase()->active()->count();

        if ($planPurchase == 0) {
            if ($serviceCount >= 4) {
                return response()->json([
                    'errors' => [
                        'category' => 'Você só pode ter no máximo 4 serviço, para cadastrar mais serviço adquira o um plano'
                    ]
                ], 422);
            }
        }

        if($request->dynamic_pricing == 1){
            $request['quantity'] = 0;
        }

        $service = Auth::user()->services()->create($request->all());
        return response()->json('Serviço cadastrado com sucesso!', 201);
    }
    public function edit(Request $request)
    {
        $service = Auth::user()->services()->findOrFail($request->service);
        $categories = Auth::user()->categories()->latest('id')->get();
        $apiProviders = Auth::user()->apiProviders()->latest('id')->get();

        return view('panel.services.edit', [
            'service' => $service,
            'categories' => $categories,
            'apiProviders' => $apiProviders
        ]);
    }

    public function update(ServiceRequest $request)
    {
        $service = Auth::user()->services()->findOrFail($request->service);

        if($request->dynamic_pricing == 1){
            $request['quantity'] = 0;
        }

        $service->fill($request->all());
        $service->dynamic_pricing = boolval($request->dynamic_pricing);
        $service->update();
        
        $service->api_rate = floatval((preg_replace('/R\$\s*\+?/', '', $request->api_rate) / $request->quantity) * 1000);
        $service->update();
        
        return response()->json('Serviço editado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $apiProvider = Auth::user()->services()->findOrFail($request->service);
        $apiProvider->delete();

        return redirect()->back()->withSuccess('Removido com sucesso!');
    }

    public function providerService(Request $request)
    {
        $apiProvider = Auth::user()->apiProviders()->findOrFail($request->provider);

        $smm = new Smm($apiProvider->url, $apiProvider->key);
        $smm->serviceList();
        $smmCallback = $smm->callback();

        return response()->json($smmCallback);
    }

    public function status(Request $request)
    {
        $apiProvider = Auth::user()->services()->findOrFail($request->service);

        if ($apiProvider->status == 0) {
            $apiProvider->status = 1;
        } else {
            $apiProvider->status = 0;
        }
        $apiProvider->update();

        return response()->json('success');
    }
}
