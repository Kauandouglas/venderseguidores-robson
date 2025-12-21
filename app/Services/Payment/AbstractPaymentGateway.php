<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;

abstract class AbstractPaymentGateway implements PaymentGatewayInterface
{
    protected array $config = [];
    protected bool $active = true;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->initialize();
    }

    /**
     * Inicializa o gateway com as configurações
     */
    abstract protected function initialize(): void;

    /**
     * Retorna a configuração
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Define uma configuração
     */
    public function setConfig(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

    public function isActive(): bool
    {
        return $this->active && $this->validateCredentials($this->config);
    }

    /**
     * Ativa o gateway
     */
    public function activate(): void
    {
        $this->active = true;
    }

    /**
     * Desativa o gateway
     */
    public function deactivate(): void
    {
        $this->active = false;
    }

    /**
     * Retorna a URL do logo do gateway
     */
    public function getLogoUrl(): string
    {
        return asset('images/payment-gateways/' . $this->getIdentifier() . '.png');
    }
}
