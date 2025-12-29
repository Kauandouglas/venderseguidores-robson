<?php

namespace App\Support;

use App\Models\Purchase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushinPay
{
    private $token;
    private $webhookUrl;
    private $apiUrl = 'https://api.pushinpay.com.br/api';
    private $callback;

    public function __construct(string $token, string $webhookUrl)
    {
        $this->token = $token;
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * Gera um PIX CashIn na PushinPay
     *
     * @param int $paymentId ID do pagamento no sistema (para external_reference)
     * @param float $price Valor da transação
     * @param string $ids Referência externa (ex: ID do pedido)
     * @param string $description Descrição do pagamento
     * @return PushinPay
     */
    public function pix(int $paymentId, float $price, string $ids, string $description): PushinPay
    {
        $payload = [
            'value' => $price * 100,
            'webhook_url' => $this->webhookUrl,
            'split_rules' => [],
            // Usar o ID do pagamento do sistema como referência externa
            'external_reference' => $ids, 
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/pix/cashIn', $payload);

            if (!$response->successful()) {
                Log::error('PushinPay API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload,
                ]);
                $this->callback = (object)['error' => true, 'message' => 'Erro na API PushinPay: ' . $response->body()];
                return $this;
            }

            $this->callback = $response->object();

        } catch (\Exception $e) {
            Log::error('PushinPay Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->callback = (object)['error' => true, 'message' => 'Exceção ao conectar com PushinPay: ' . $e->getMessage()];
        }

        return $this;
    }

    /**
     * Processa o webhook de notificação da PushinPay
     *
     * @param array $data Dados recebidos do webhook
     * @return bool
     */
    public function handleWebhook(array $data): bool
    {
        Log::info('PushinPay Webhook Received', ['data' => $data]);

        if (!isset($data['id']) || !isset($data['external_reference']) || !isset($data['status'])) {
            Log::warning('PushinPay: Webhook com dados incompletos', ['data' => $data]);
            return false;
        }

        $transactionId = $data['id'];
        $externalReference = $data['external_reference'];
        $status = strtolower($data['status']);

        // Mapeamento de status
        $systemStatus = match($status) {
            'paid', 'approved' => 'approved',
            'cancelled', 'canceled' => 'cancelled',
            'expired', 'rejected' => 'rejected',
            'refunded' => 'refunded',
            default => 'pending',
        };

        // Buscar o pedido (Purchase) pela referência externa
        $purchase = Purchase::find($externalReference);

        if (!$purchase) {
            Log::warning('PushinPay: Pedido (Purchase) não encontrado', ['external_reference' => $externalReference]);
            return false;
        }

        // Atualizar o status do pedido
        if ($purchase->status !== $systemStatus) {
            $purchase->status = $systemStatus;
            $purchase->transaction_id = $transactionId;
            
            // Adicionar informações do pagador se disponíveis
            if (isset($data['payer_name'])) {
                $purchase->payer_name = $data['payer_name'];
            }

            if (isset($data['end_to_end_id'])) {
                $purchase->end_to_end_id = $data['end_to_end_id'];
            }

            $purchase->save();
            Log::info('PushinPay: Pedido atualizado via webhook', [
                'purchase_id' => $purchase->id,
                'new_status' => $systemStatus,
            ]);
        }

        return true;
    }

    public function callback()
    {
        return $this->callback;
    }
}
