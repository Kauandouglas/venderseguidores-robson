<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index()
    {
        $gateways = $this->paymentService->getAvailableGateways();

        return view('admin.payment-gateways.index', compact('gateways'));
    }

    public function show(string $identifier)
    {
        $gateway = $this->paymentService->getGateway($identifier);
        $configFields = $gateway->getConfigFields();
        $supportedMethods = $gateway->getSupportedMethods();

        return view('admin.payment-gateways.show', compact(
            'gateway',
            'configFields',
            'supportedMethods'
        ));
    }

    public function configure(Request $request, string $identifier)
    {
        $gateway = $this->paymentService->getGateway($identifier);
        $configFields = $gateway->getConfigFields();

        return view('admin.payment-gateways.configure', compact(
            'gateway',
            'configFields',
            'identifier'
        ));
    }

    public function saveConfiguration(Request $request, string $identifier)
    {
        $gateway = $this->paymentService->getGateway($identifier);
        
        // Validar os campos de configuração
        $rules = [];
        foreach ($gateway->getConfigFields() as $field => $config) {
            if ($config['required']) {
                $rules[$field] = 'required';
            }
        }

        $validated = $request->validate($rules);

        // Salvar configurações globais
        config(["payment.gateways.{$identifier}" => $validated]);

        return redirect()
            ->route('admin.payment-gateways.show', $identifier)
            ->with('success', 'Configurações salvas com sucesso!');
    }

    public function testConnection(Request $request, string $identifier)
    {
        $gateway = $this->paymentService->getGateway($identifier);
        
        $isValid = $gateway->validateCredentials($request->all());

        return response()->json([
            'success' => $isValid,
            'message' => $isValid 
                ? 'Conexão estabelecida com sucesso!' 
                : 'Falha ao conectar. Verifique as credenciais.',
        ]);
    }
}
