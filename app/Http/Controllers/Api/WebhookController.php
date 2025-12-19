<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        protected PaymentGatewayFactory $gatewayFactory
    ) {}

    /**
     * Processa webhook do PushinPay
     */
    public function pushinpay(Request $request)
    {
        try {
            Log::info('Webhook PushinPay recebido', [
                'headers' => $request->headers->all(),
                'body' => $request->all(),
            ]);

            // Obter configurações do gateway
            $config = $this->getGatewayConfig('pushinpay');

            // Criar instância do gateway
            $gateway = $this->gatewayFactory->make('pushinpay', $config);

            // Processar webhook
            $gateway->handleWebhook($request);

            return response()->json([
                'success' => true,
                'message' => 'Webhook processado com sucesso',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erro ao processar webhook PushinPay', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar webhook',
            ], 500);
        }
    }

    /**
     * Obtém configurações do gateway do banco de dados
     */
    protected function getGatewayConfig(string $identifier): array
    {
        // Buscar configurações do gateway no banco de dados
        // Ajuste conforme a estrutura do seu banco de dados
        $paymentMethod = \App\Models\PaymentMethod::where('identifier', $identifier)
            ->where('active', true)
            ->first();

        if (!$paymentMethod) {
            Log::warning("Gateway {$identifier} não encontrado ou inativo");
            return [];
        }

        return $paymentMethod->config ?? [];
    }
}
