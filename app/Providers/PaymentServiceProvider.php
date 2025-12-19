<?php

namespace App\Providers;

use App\Services\Payment\Gateways\MercadoPagoGateway;

use App\Services\Payment\Gateways\StripeGateway;
use App\Services\Payment\PaymentGatewayFactory;
use App\Services\Payment\PaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Registra os serviços
     */
    public function register(): void
    {
        $this->app->singleton(PaymentGatewayFactory::class);
        $this->app->singleton(PaymentService::class);
    }

    /**
     * Bootstrap dos serviços
     */
    public function boot(): void
    {
        $factory = $this->app->make(PaymentGatewayFactory::class);

        // ========================================
        // GATEWAYS DE PAGAMENTO DISPONÍVEIS
        // ========================================
        // Para adicionar um novo gateway:
        // 1. Crie uma classe em app/Services/Payment/Gateways/
        // 2. Estenda AbstractPaymentGateway
        // 3. Implemente todos os métodos da interface PaymentGatewayInterface
        // 4. Registre o gateway abaixo usando $factory->register()
        // ========================================

        // Gateway: Mercado Pago
        // Suporta: PIX, Cartão de Crédito, Cartão de Débito, Boleto
        $factory->register('mercadopago', MercadoPagoGateway::class);

        // Gateway: Stripe
        // Suporta: Cartão de Crédito Internacional
        $factory->register('stripe', StripeGateway::class);



        // ========================================
        // ADICIONE NOVOS GATEWAYS ABAIXO
        // ========================================
        // Exemplos:
        // $factory->register('paypal', PayPalGateway::class);
        // $factory->register('pagseguro', PagSeguroGateway::class);
        // $factory->register('asaas', AsaasGateway::class);
        // $factory->register('paghiper', PagHiperGateway::class);
        // ========================================
    }
}
