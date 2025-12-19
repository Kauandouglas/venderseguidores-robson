<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Mail\Panel\ConfigSuccessStoreMail;
use App\Models\Category;
use App\Models\ConfigPreviewStore;
use App\Models\Service;
use App\Support\PainelDoInsta;
use App\Support\Smm;
use App\Support\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ConfigPreviewStoreController extends Controller
{
    public function create()
    {
        $systemSetting = Auth::user()->systemSetting()->first();
        $apiProvider = Auth::user()->apiProviders()->first();
        $payment = Auth::user()->payment()->first();

        return view('panel.configPreviewStores.create', [
            'systemSetting' => $systemSetting,
            'apiProvider' => $apiProvider,
            'payment' => $payment
        ]);
    }

    public function store(Request $request)
    {
        $configPreviewStore = Auth::user()->configPreviewStore()->first();
        $planPurchase = Auth::user()->planPurchase()->active()->count();

//        if ($planPurchase == 0) {
//            return redirect()->route('panel.configPreviews.create', ['step' => 'layout']);
//        }

        $json = json_decode($configPreviewStore->json ?? '[]', true);

        switch ($request->step) {
            case 'info':
                $this->handleInfoStep($request, $json);
                return redirect()->route('panel.configPreviews.create', ['step' => 'layout']);

            case 'layout':
                $this->handleLayoutStep($request, $json, $configPreviewStore);
                return redirect()->route('panel.configPreviews.create', ['step' => 'api']);

            case 'api':
                $api = $this->handleApiStep($request, $json, $configPreviewStore);
                if ($api !== true) {
                    return redirect()->back();
                }

                return redirect()->route('panel.configPreviews.create', ['step' => 'categories']);
            case 'categories':
                $this->handleCategoriesStep($request, $json, $configPreviewStore);
                return redirect()->route('panel.configPreviews.create', ['step' => 'payment']);

            case 'payment':
                $handlePaymentStep = $this->handlePaymentStep($request, $json, $configPreviewStore);
                if ($handlePaymentStep !== true) {
                    return redirect()->back();
                }
                return redirect()->route('panel.configPreviews.create', ['step' => 'finish']);

            default:
                // Handle unexpected step
                abort(404);
        }
    }

    private function handleInfoStep(Request $request, &$json)
    {
        $request->validate([
            'title' => 'required|max:191',
            'logo' => 'image',
        ]);

        $json['info']['title'] = $request->title;
        if (!empty($request->file('logo'))) {
            $json['info']['logo'] = $request->file('logo')->store('configPreviewStores');
        } else {
            $json['info']['logo'] = null;
        }

        ConfigPreviewStore::updateOrCreate([
            'user_id' => Auth::id(),
        ], [
            'json' => json_encode($json),
        ]);
    }

    private function handleLayoutStep(Request $request, &$json, $configPreviewStore)
    {
        $request->validate([
            'primary_color' => 'required|max:191',
            'secondary_color' => 'required|max:191',
        ]);

        $json['layout']['primary_color'] = $request->primary_color;
        $json['layout']['secondary_color'] = $request->secondary_color;
        $json['layout']['color_default'] = $request->color_default;

        $configPreviewStore->update([
            'json' => json_encode($json),
        ]);
    }

    private function handleApiStep(Request $request, &$json, $configPreviewStore)
    {
        if (empty(trim($request->key))) {
            $request->validate([
                'login' => 'required|max:191',
                'password' => 'required|max:191'
            ]);
        } else {
            $request->validate([
                'key' => 'required|max:191',
            ]);
        }

        $newKey = $request->key;

        if (empty(trim($request->key))) {
            $painelDoInsta = new PainelDoInsta();
            $csrf = $painelDoInsta->csrf_token();

            $login = new PainelDoInsta();
            $login = $login->login($csrf, $request->login, $request->password);

            if ($login === false) {
                return redirect()->back()->withErrors([
                    'key' => 'Login ou senha do painel do insta inválidos',
                ]);
            }

            $newKey = new PainelDoInsta();
            $newKey = $newKey->newkey();
        }

        $smm = new Smm('https://paineldoinstabrasil.com/api/v2', $newKey);
        try {
            $smm->balance();
            $smmCallback = $smm->callback();

            if (!isset($smmCallback->balance)) {
                throw new \Exception('Connection issue');
            }

            $json['api']['key'] = $newKey;

            $configPreviewStore->update([
                'json' => json_encode($json),
            ]);

            return true;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'key' => 'Parece haver um problema de conexão com o provedor de API. Verifique a chave API e a URL novamente!',
            ]);
        }
    }

    private function handleCategoriesStep(Request $request, &$json, $configPreviewStore)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'in:1,2,3,4,5,6,7,8,9',
        ]);

        $json['categories'] = $request->categories;
        $configPreviewStore->update([
            'json' => json_encode($json),
        ]);
    }

    private function handlePaymentStep(Request $request, &$json, $configPreviewStore)
    {
        $request->validate([
            'access_token' => 'required',
        ]);

        $categoriesCount = Auth::user()->categories()->count();

        if ($categoriesCount > 0) {
            return true;
        }

        $json['payment']['access_token'] = $request->access_token;
        $configPreviewStore->update([
            'json' => json_encode($json),
        ]);

        $this->finalizeSettings($json);

        return true;
    }

    private function finalizeSettings($json)
    {
        $user = Auth::user();

        $systemSettings = $user->systemSettings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'template_id' => 1,
                'title' => $json['info']['title'],
                'primary_color' => $json['layout']['primary_color'],
                'secondary_color' => $json['layout']['secondary_color'],
            ]
        );

        $systemSettings->color_default = (bool)$json['layout']['color_default'];
        if (!empty($json['info']['logo'])) {
            $systemSettings->logo = $json['info']['logo'];
            $systemSettings->favicon = $json['info']['logo'];
        }
        $systemSettings->update();

        $this->updateApiProvider($json['api']);
        $this->insertCategories($json['categories']);
        $this->insertPayment($json['payment']);

        # Send Message Create Success
        Mail::queue(new ConfigSuccessStoreMail(Auth::user()));
        $whatsapp = new Whatsapp();
        $whatsapp->sendMessage(Auth::user()->phone, 'Sua loja foi configurada com sucesso, agora você pode começar a cadastrar seus serviços e gerenciar suas vendas. 🥳🥳

Que tal aumentar suas vendas? Conheça nossos planos e tenha acesso a mais recursos para sua loja virtual. 🚀🚀
Acesse: https://lojadoinsta.com.br/painel/planos

Salve nosso número para receber dicas e novidades sobre vendas online. 📲📲

Caso precise de atendimento o nosso número do Whatsapp é esse: +55 17 98145-2466');
    }

    private function updateApiProvider($apiData)
    {
        $apiProvider = Auth::user()->apiProviders()->first();

        $smm = new Smm($apiProvider->url, $apiData['key']);
        try {
            $smm->balance();
            $smmCallback = $smm->callback();

            if (!isset($smmCallback->balance)) {
                throw new \Exception('Connection issue');
            }

            $apiProvider->key = $apiData['key'];
            $apiProvider->balance = $smmCallback->balance;
            $apiProvider->status = true;
            $apiProvider->update();
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'key' => 'Parece haver um problema de conexão com o provedor de API. Verifique a chave API e a URL novamente!',
                ]
            ], 422);
        }
    }

    private function insertCategories($categories)
    {
        $apiProvider = Auth::user()->apiProviders()->first();
        $categoriesList = Category::where('user_id', '359')->where('status', '1')->oldest('order')->get();

        foreach ($categoriesList as $categoryList) {
            $categoryNew = new Category();
            $categoryNew->user_id = Auth::id();
            $categoryNew->name = $categoryList->name;
            $categoryNew->order = $categoryList->order;
            $categoryNew->save();

            $services = $categoryList->services()->where('status', '1')->get();
            foreach ($services as $service) {
                $serviceNew = new Service();
                $serviceNew->user_id = Auth::id();
                $serviceNew->category_id = $categoryNew->id;
                $serviceNew->api_provider_id = $apiProvider->id;
                $serviceNew->api_service = $service->api_service;
                $serviceNew->name = $service->name;
                $serviceNew->type = $service->type;
                $serviceNew->quantity = $service->quantity;
                $serviceNew->price = $service->convert_price;
                $serviceNew->status = $service->status;
                $serviceNew->description = $service->description;
                $serviceNew->save();
            }
        }
    }

    private function insertPayment($payment)
    {
        $data = [
            'option' => ['pix'],
            'public_key' => '',
            'access_token' => $payment['access_token'],
        ];

        Auth::user()->payment()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'payment_method_id' => 1,
                'data' => json_encode($data)
            ]
        );
    }
}
