<?php

namespace App\Contracts;

use App\DTOs\Payment\PaymentRequestDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * Retorna o nome do gateway
     */
    public function getName(): string;

    /**
     * Retorna o identificador único do gateway
     */
    public function getIdentifier(): string;

    /**
     * Retorna a descrição do gateway
     */
    public function getDescription(): string;

    /**
     * Retorna os métodos de pagamento suportados
     */
    public function getSupportedMethods(): array;

    /**
     * Retorna os campos de configuração necessários
     */
    public function getConfigFields(): array;

    /**
     * Valida as credenciais do gateway
     */
    public function validateCredentials(array $credentials): bool;

    /**
     * Processa um pagamento
     */
    public function charge(PaymentRequestDTO $request): PaymentResponseDTO;

    /**
     * Processa um reembolso
     */
    public function refund(string $transactionId, float $amount): bool;

    /**
     * Retorna o status de uma transação
     */
    public function getTransactionStatus(string $transactionId): string;

    /**
     * Processa webhook do gateway
     */
    public function handleWebhook(Request $request): void;

    /**
     * Verifica se o gateway está ativo
     */
    public function isActive(): bool;

    /**
     * Retorna a URL do logo do gateway
     */
    public function getLogoUrl(): string;
}
