<?php

namespace App\Services\Payment\Gateways;

use App\DTOs\Payment\PaymentRequestDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Enums\PaymentStatus;
use App\Services\Payment\AbstractPaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushinPayGateway extends AbstractPaymentGateway
{
    protected string $apiUrl = 'https://api.pushinpay.com.br/api';

    public function getName(): string
    {
        return 'PushinPay';
    }

    public function getIdentifier(): string
    {
        return 'pushinpay';
    }

    public function getDescription(): string
    {
        return 'Gateway de pagamento PushinPay - Aceita PIX com geração de QR Code';
    }

    public function getSupportedMethods(): array
    {
        return [
            'pix' => 'PIX',
        ];
    }

    public function getConfigFields(): array
    {
        return [
            'bearer_token' => [
                'label' => 'Bearer Token',
                'type' => 'text',
                'required' => true,
                'description' => 'Token de autenticação da API PushinPay',
            ],
            'webhook_url' => [
                'label' => 'Webhook URL',
                'type' => 'text',
                'required' => false,
                'description' => 'URL para receber notificações de pagamento',
            ],
        ];
    }

    protected function initialize(): void
    {
        // Validar configurações básicas
        if (empty($this->config['bearer_token'])) {
            Log::warning('PushinPay: Bearer token não configurado');
        }
    }

    public function validateCredentials(array $credentials): bool
    {
        return !empty($credentials['bearer_token']);
    }

    public function charge(PaymentRequestDTO $request): PaymentResponseDTO
    {
        try {
            // Validar se o método de pagamento é PIX
            if ($request->paymentMethod !== 'pix') {
                return PaymentResponseDTO::failed(
                    status: PaymentStatus::REJECTED,
                    message: 'PushinPay suporta apenas pagamentos via PIX',
                    errorCode: 'INVALID_PAYMENT_METHOD'
                );
            }

            // Preparar dados para a API
            $payload = [
                'value' => $request->amount,
                'webhook_url' => $this->config['webhook_url'] ?? url('/api/webhooks/pushinpay'),
                'split_rules' => [],
            ];

            // Fazer requisição para a API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->config['bearer_token'],
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/pix/cashIn', $payload);

            // Verificar se a requisição foi bem-sucedida
            if (!$response->successful()) {
                Log::error('PushinPay API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return PaymentResponseDTO::failed(
                    status: PaymentStatus::REJECTED,
                    message: 'Erro ao processar pagamento: ' . $response->body(),
                    errorCode: 'API_ERROR'
                );
            }

            $data = $response->json();

            // Validar resposta da API
            if (!isset($data['id']) || !isset($data['qr_code'])) {
                return PaymentResponseDTO::failed(
                    status: PaymentStatus::REJECTED,
                    message: 'Resposta inválida da API PushinPay',
                    errorCode: 'INVALID_RESPONSE'
                );
            }

            // Mapear status
            $status = $this->mapStatus($data['status']);

            // Preparar dados de retorno
            $responseData = [
                'payment_id' => $data['id'],
                'qr_code' => $data['qr_code'],
                'qr_code_base64' => $data['qr_code_base64'] ?? null,
                'status' => $data['status'],
                'value' => $data['value'],
                'webhook_url' => $data['webhook_url'],
                'end_to_end_id' => $data['end_to_end_id'] ?? null,
                'payer_name' => $data['payer_name'] ?? null,
                'payer_national_registration' => $data['payer_national_registration'] ?? null,
            ];

            return PaymentResponseDTO::success(
                status: $status,
                transactionId: $data['id'],
                message: 'QR Code PIX gerado com sucesso',
                data: $responseData
            );

        } catch (\Exception $e) {
            Log::error('PushinPay Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return PaymentResponseDTO::failed(
                status: PaymentStatus::REJECTED,
                message: 'Erro ao processar pagamento: ' . $e->getMessage(),
                errorCode: 'EXCEPTION'
            );
        }
    }

    public function refund(string $transactionId, float $amount): bool
    {
        // PushinPay pode não suportar reembolso automático
        // Implementar se a API fornecer endpoint para isso
        Log::warning('PushinPay: Reembolso não implementado', [
            'transaction_id' => $transactionId,
            'amount' => $amount,
        ]);

        return false;
    }

    public function getTransactionStatus(string $transactionId): string
    {
        try {
            // Implementar consulta de status se a API fornecer endpoint
            // Por enquanto, retornar status pendente
            return PaymentStatus::PENDING->value;

        } catch (\Exception $e) {
            Log::error('PushinPay: Erro ao consultar status', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage(),
            ]);

            return PaymentStatus::REJECTED->value;
        }
    }

    public function handleWebhook(Request $request): void
    {
        try {
            $data = $request->all();

            Log::info('PushinPay Webhook Received', ['data' => $data]);

            // Validar estrutura do webhook
            if (!isset($data['id'])) {
                Log::warning('PushinPay: Webhook sem ID de transação');
                return;
            }

            $transactionId = $data['id'];
            $status = $data['status'] ?? 'unknown';

            // Mapear status
            $paymentStatus = $this->mapStatus($status);

            // Buscar pedido relacionado
            // Assumindo que o external_reference foi usado ao criar o pagamento
            if (isset($data['external_reference'])) {
                $order = \App\Models\Purchase::find($data['external_reference']);

                if ($order) {
                    $order->status = $paymentStatus->value;
                    $order->transaction_id = $transactionId;

                    // Adicionar informações do pagador se disponíveis
                    if (isset($data['payer_name'])) {
                        $order->payer_name = $data['payer_name'];
                    }

                    if (isset($data['payer_national_registration'])) {
                        $order->payer_document = $data['payer_national_registration'];
                    }

                    if (isset($data['end_to_end_id'])) {
                        $order->end_to_end_id = $data['end_to_end_id'];
                    }

                    $order->save();

                    Log::info('PushinPay: Pedido atualizado', [
                        'order_id' => $order->id,
                        'status' => $paymentStatus->value,
                    ]);
                } else {
                    Log::warning('PushinPay: Pedido não encontrado', [
                        'external_reference' => $data['external_reference'],
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('PushinPay: Erro ao processar webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Mapeia o status do PushinPay para o enum do sistema
     */
    protected function mapStatus(string $pushinPayStatus): PaymentStatus
    {
        return match(strtolower($pushinPayStatus)) {
            'created' => PaymentStatus::PENDING,
            'pending' => PaymentStatus::PENDING,
            'paid', 'approved' => PaymentStatus::APPROVED,
            'cancelled', 'canceled' => PaymentStatus::CANCELLED,
            'expired' => PaymentStatus::REJECTED,
            'refunded' => PaymentStatus::REFUNDED,
            default => PaymentStatus::PENDING,
        };
    }
}
