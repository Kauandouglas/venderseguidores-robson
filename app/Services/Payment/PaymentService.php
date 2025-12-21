<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\Payment\PaymentRequestDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Models\User;

class PaymentService
{
    public function __construct(
        protected PaymentGatewayFactory $factory
    ) {}

    /**
     * Processa um pagamento usando o gateway especificado
     */
    public function processPayment(
        string $gatewayIdentifier,
        PaymentRequestDTO $request,
        ?User $user = null
    ): PaymentResponseDTO {
        $config = $this->getGatewayConfig($gatewayIdentifier, $user);
        $gateway = $this->factory->make($gatewayIdentifier, $config);

        if (!$gateway->isActive()) {
            return PaymentResponseDTO::failed(
                status: \App\Enums\PaymentStatus::REJECTED,
                message: 'Gateway de pagamento não está ativo ou configurado corretamente'
            );
        }

        return $gateway->charge($request);
    }

    /**
     * Processa um reembolso
     */
    public function processRefund(
        string $gatewayIdentifier,
        string $transactionId,
        float $amount,
        ?User $user = null
    ): bool {
        $config = $this->getGatewayConfig($gatewayIdentifier, $user);
        $gateway = $this->factory->make($gatewayIdentifier, $config);

        return $gateway->refund($transactionId, $amount);
    }

    /**
     * Consulta o status de uma transação
     */
    public function getTransactionStatus(
        string $gatewayIdentifier,
        string $transactionId,
        ?User $user = null
    ): string {
        $config = $this->getGatewayConfig($gatewayIdentifier, $user);
        $gateway = $this->factory->make($gatewayIdentifier, $config);

        return $gateway->getTransactionStatus($transactionId);
    }

    /**
     * Retorna todos os gateways disponíveis
     */
    public function getAvailableGateways(): array
    {
        return $this->factory->all();
    }

    /**
     * Retorna um gateway específico
     */
    public function getGateway(string $identifier, ?User $user = null): PaymentGatewayInterface
    {
        $config = $this->getGatewayConfig($identifier, $user);
        return $this->factory->make($identifier, $config);
    }

    /**
     * Retorna as configurações do gateway para um usuário
     */
    protected function getGatewayConfig(string $identifier, ?User $user = null): array
    {
        if (!$user) {
            // Retorna configurações globais do sistema
            return config("payment.gateways.{$identifier}", []);
        }

        // Retorna configurações do usuário
        $payment = $user->payment;
        
        if (!$payment || $payment->payment_method_id !== $identifier) {
            return [];
        }

        return json_decode($payment->data, true) ?? [];
    }

    /**
     * Salva as configurações do gateway para um usuário
     */
    public function saveGatewayConfig(User $user, string $identifier, array $config): bool
    {
        $gateway = $this->factory->make($identifier, $config);

        if (!$gateway->validateCredentials($config)) {
            return false;
        }

        $user->payment()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'payment_method_id' => $identifier,
                'data' => json_encode($config),
            ]
        );

        return true;
    }

    /**
     * Verifica se um usuário tem um gateway configurado
     */
    public function hasConfiguredGateway(User $user): bool
    {
        return $user->payment()->exists();
    }
}
