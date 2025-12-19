<?php

namespace App\Services\Payment\Gateways;

use App\DTOs\Payment\PaymentRequestDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Enums\PaymentStatus;
use App\Services\Payment\AbstractPaymentGateway;
use Illuminate\Http\Request;
use MercadoPago\Payment;
use MercadoPago\SDK;

class MercadoPagoGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'Mercado Pago';
    }

    public function getIdentifier(): string
    {
        return 'mercadopago';
    }

    public function getDescription(): string
    {
        return 'Gateway de pagamento Mercado Pago - Aceita PIX, Cartão de Crédito e muito mais';
    }

    public function getSupportedMethods(): array
    {
        return [
            'pix' => 'PIX',
            'credit_card' => 'Cartão de Crédito',
            'debit_card' => 'Cartão de Débito',
            'boleto' => 'Boleto Bancário',
        ];
    }

    public function getConfigFields(): array
    {
        return [
            'access_token' => [
                'label' => 'Access Token',
                'type' => 'text',
                'required' => true,
                'description' => 'Token de acesso da API do Mercado Pago',
            ],
            'public_key' => [
                'label' => 'Public Key',
                'type' => 'text',
                'required' => true,
                'description' => 'Chave pública do Mercado Pago',
            ],
        ];
    }

    protected function initialize(): void
    {
        if (isset($this->config['access_token'])) {
            SDK::setAccessToken($this->config['access_token']);
        }
    }

    public function validateCredentials(array $credentials): bool
    {
        return !empty($credentials['access_token']) && !empty($credentials['public_key']);
    }

    public function charge(PaymentRequestDTO $request): PaymentResponseDTO
    {
        try {
            $payment = new Payment();
            $payment->transaction_amount = $request->amount;
            $payment->description = $request->description;
            $payment->payment_method_id = $request->paymentMethod;
            $payment->external_reference = $request->externalReference;

            // Configurar payer
            $payment->payer = [
                'email' => $request->payer['email'],
                'first_name' => $request->payer['first_name'] ?? '',
                'last_name' => $request->payer['last_name'] ?? '',
            ];

            // Se for cartão de crédito
            if ($request->paymentMethod === 'credit_card' && $request->token) {
                $payment->token = $request->token;
                $payment->installments = $request->installments;
                
                if (isset($request->payer['identification'])) {
                    $payment->payer['identification'] = $request->payer['identification'];
                }
            }

            // Se for PIX
            if ($request->paymentMethod === 'pix') {
                $payment->payment_method_id = 'pix';
                
                if (isset($request->payer['identification'])) {
                    $payment->payer['identification'] = $request->payer['identification'];
                }
            }

            $payment->save();

            $status = $this->mapStatus($payment->status);
            
            $data = [
                'payment_id' => $payment->id,
                'status_detail' => $payment->status_detail,
            ];

            // Se for PIX, adicionar QR Code
            if ($request->paymentMethod === 'pix' && isset($payment->point_of_interaction)) {
                $data['qr_code'] = $payment->point_of_interaction->transaction_data->qr_code ?? null;
                $data['qr_code_base64'] = $payment->point_of_interaction->transaction_data->qr_code_base64 ?? null;
            }

            return PaymentResponseDTO::success(
                status: $status,
                transactionId: (string) $payment->id,
                message: 'Pagamento processado com sucesso',
                data: $data
            );

        } catch (\Exception $e) {
            return PaymentResponseDTO::failed(
                status: PaymentStatus::REJECTED,
                message: $e->getMessage(),
                errorCode: $e->getCode()
            );
        }
    }

    public function refund(string $transactionId, float $amount): bool
    {
        try {
            $payment = Payment::find_by_id($transactionId);
            $payment->refund();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTransactionStatus(string $transactionId): string
    {
        try {
            $payment = Payment::find_by_id($transactionId);
            return $this->mapStatus($payment->status)->value;
        } catch (\Exception $e) {
            return PaymentStatus::REJECTED->value;
        }
    }

    public function handleWebhook(Request $request): void
    {
        $data = $request->all();
        
        if (isset($data['type']) && $data['type'] === 'payment') {
            $paymentId = $data['data']['id'] ?? null;
            
            if ($paymentId) {
                $payment = Payment::find_by_id($paymentId);
                $externalReference = $payment->external_reference;
                
                // Atualizar o pedido no sistema
                $order = \App\Models\Purchase::find($externalReference);
                if ($order) {
                    $order->status = $this->mapStatus($payment->status)->value;
                    $order->save();
                }
            }
        }
    }

    /**
     * Mapeia o status do Mercado Pago para o enum do sistema
     */
    protected function mapStatus(string $mpStatus): PaymentStatus
    {
        return match($mpStatus) {
            'approved' => PaymentStatus::APPROVED,
            'pending' => PaymentStatus::PENDING,
            'in_process' => PaymentStatus::IN_PROCESS,
            'rejected' => PaymentStatus::REJECTED,
            'cancelled' => PaymentStatus::CANCELLED,
            'refunded' => PaymentStatus::REFUNDED,
            'charged_back' => PaymentStatus::CHARGED_BACK,
            default => PaymentStatus::PENDING,
        };
    }
}
