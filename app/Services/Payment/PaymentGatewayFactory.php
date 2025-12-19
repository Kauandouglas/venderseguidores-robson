<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Exceptions\Payment\PaymentGatewayNotFoundException;

class PaymentGatewayFactory
{
    /**
     * @var array<string, string>
     */
    protected array $gateways = [];

    /**
     * Registra um gateway
     */
    public function register(string $identifier, string $class): void
    {
        $this->gateways[$identifier] = $class;
    }

    /**
     * Cria uma instância do gateway
     */
    public function make(string $identifier, array $config = []): PaymentGatewayInterface
    {
        if (!isset($this->gateways[$identifier])) {
            throw new PaymentGatewayNotFoundException("Payment gateway '{$identifier}' not found.");
        }

        $class = $this->gateways[$identifier];
        return new $class($config);
    }

    /**
     * Verifica se um gateway existe
     */
    public function has(string $identifier): bool
    {
        return isset($this->gateways[$identifier]);
    }

    /**
     * Retorna todos os gateways disponíveis
     */
    public function available(): array
    {
        return array_keys($this->gateways);
    }

    /**
     * Retorna informações de todos os gateways
     */
    public function all(): array
    {
        $gateways = [];

        foreach ($this->gateways as $identifier => $class) {
            $instance = new $class();
            $gateways[$identifier] = [
                'identifier' => $instance->getIdentifier(),
                'name' => $instance->getName(),
                'description' => $instance->getDescription(),
                'supported_methods' => $instance->getSupportedMethods(),
                'config_fields' => $instance->getConfigFields(),
                'logo_url' => $instance->getLogoUrl(),
            ];
        }

        return $gateways;
    }
}
