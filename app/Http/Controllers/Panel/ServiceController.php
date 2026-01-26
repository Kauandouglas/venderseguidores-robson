<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ServiceRequest;
use App\Support\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->with(['services' => function ($query) {
            $query->with('apiProvider')->oldest('order');
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

        // Processa o checkbox de comentários personalizados
        if ($request->filled('is_custom_comment') && $request->is_custom_comment == 1) {
            $request['type'] = 4;
        } else {
            $request['type'] = 1;
        }

        $service = Auth::user()->services()->create($request->all());

        if ($request->filled('api_rate')) {
            // Persiste o custo do provedor para evitar exibir zero logo após o cadastro
            $service->api_rate = floatval(preg_replace('/[^0-9\.]/', '', str_replace(',', '.', $request->api_rate)));
            $service->save();
            $service->recalcPriceFromProvider();
        }

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

        // Processa o checkbox de comentários personalizados
        if ($request->filled('is_custom_comment') && $request->is_custom_comment == 1) {
            $request['type'] = 4;
        } else {
            $request['type'] = 1;
        }

        $service->fill($request->all());
        $service->dynamic_pricing = boolval($request->dynamic_pricing);
        $service->update();

        if ($request->filled('api_rate')) {
            // Usa a tarifa enviada (por 1000 unidades) ao invés de dividir pelo quantity
            $service->api_rate = floatval(preg_replace('/[^0-9\.]/', '', str_replace(',', '.', $request->api_rate)));
            $service->save();
            $service->recalcPriceFromProvider();
        }

        return response()->json('Serviço editado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $apiProvider = Auth::user()->services()->findOrFail($request->service);
        $apiProvider->delete();

        return redirect()->back()->withSuccess('Removido com sucesso!');
    }

    public function clone(Request $request)
    {
        $request->validate([
            'target_category_id' => 'required|integer'
        ]);

        $service = Auth::user()->services()->findOrFail($request->service);
        $targetCategory = Auth::user()->categories()->findOrFail($request->target_category_id);

        $nextOrder = Auth::user()->services()->where('category_id', $targetCategory->id)->max('order') + 1;

        $clone = $service->replicate();
        $clone->user_id = Auth::id();
        $clone->category_id = $targetCategory->id;
        $clone->order = $nextOrder ?: 1;
        $clone->save();

        Cache::forget('systemSettingCategories.' . Auth::id());

        return response()->json(['message' => 'Serviço duplicado com sucesso!']);
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

    public function order(Request $request)
    {
        Cache::forget('systemSettingCategories.' . Auth::id());

        $order = 1;
        foreach ($request->services as $serviceId) {
            Auth::user()->services()->where('id', $serviceId)->update(['order' => $order]);
            $order++;
        }

        return response()->json('success');
    }
}

