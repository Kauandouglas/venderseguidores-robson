# Como Adicionar um Novo Gateway de Pagamento

Este guia mostra como adicionar um novo gateway de pagamento ao sistema de forma simples e rápida.

## Passo 1: Instalar o SDK do Gateway (se necessário)

Se o gateway tiver um SDK oficial, instale via Composer:

```bash
composer require nome-do-pacote/sdk
```

## Passo 2: Criar a Classe do Gateway

Crie uma nova classe em `app/Services/Payment/Gateways/SeuGateway.php`:

```php
<?php

namespace App\Services\Payment\Gateways;

use App\DTOs\Payment\PaymentRequestDTO;
use App\DTOs\Payment\PaymentResponseDTO;
use App\Enums\PaymentStatus;
use App\Services\Payment\AbstractPaymentGateway;
use Illuminate\Http\Request;

class SeuGateway extends AbstractPaymentGateway
{
    public function getName(): string
    {
        return 'Seu Gateway';
    }

    public function getIdentifier(): string
    {
        return 'seugateway'; // identificador único (slug)
    }

    public function getDescription(): string
    {
        return 'Descrição do seu gateway de pagamento';
    }

    public function getSupportedMethods(): array
    {
        return [
            'credit_card' => 'Cartão de Crédito',
            'pix' => 'PIX',
            'boleto' => 'Boleto Bancário',
        ];
    }

    public function getConfigFields(): array
    {
        return [
            'api_key' => [
                'label' => 'API Key',
                'type' => 'text',
                'required' => true,
                'description' => 'Chave da API',
            ],
            'api_secret' => [
                'label' => 'API Secret',
                'type' => 'password',
                'required' => true,
                'description' => 'Segredo da API',
            ],
            'sandbox_mode' => [
                'label' => 'Modo Sandbox',
                'type' => 'checkbox',
                'required' => false,
                'description' => 'Ativar modo de testes',
            ],
        ];
    }

    protected function initialize(): void
    {
        // Inicializar o SDK do gateway
        if (isset($this->config['api_key'])) {
            // Exemplo: SDK::setApiKey($this->config['api_key']);
        }
    }

    public function validateCredentials(array $credentials): bool
    {
        // Validar se as credenciais são válidas
        return !empty($credentials['api_key']) && 
               !empty($credentials['api_secret']);
    }

    public function charge(PaymentRequestDTO $request): PaymentResponseDTO
    {
        try {
            // Implementar a lógica de cobrança
            
            // Exemplo de chamada à API do gateway
            // $response = $this->api->charge([
            //     'amount' => $request->amount,
            //     'currency' => $request->currency,
            //     'payment_method' => $request->paymentMethod,
            //     'description' => $request->description,
            //     'payer' => $request->payer,
            // ]);

            // Retornar sucesso
            return PaymentResponseDTO::success(
                status: PaymentStatus::APPROVED,
                transactionId: 'txn_123456',
                message: 'Pagamento processado com sucesso',
                data: [
                    // Dados adicionais do pagamento
                ]
            );

        } catch (\Exception $e) {
            // Retornar erro
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
            // Implementar lógica de reembolso
            // $this->api->refund($transactionId, $amount);
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getTransactionStatus(string $transactionId): string
    {
        try {
            // Consultar status da transação
            // $transaction = $this->api->getTransaction($transactionId);
            // return $this->mapStatus($transaction->status);
            
            return PaymentStatus::PENDING->value;
        } catch (\Exception $e) {
            return PaymentStatus::REJECTED->value;
        }
    }

    public function handleWebhook(Request $request): void
    {
        // Processar webhook do gateway
        $data = $request->all();
        
        // Validar assinatura do webhook (se aplicável)
        // if (!$this->validateWebhookSignature($request)) {
        //     abort(403, 'Invalid signature');
        // }

        // Processar evento
        if (isset($data['event_type']) && $data['event_type'] === 'payment.approved') {
            $transactionId = $data['transaction_id'];
            $externalReference = $data['external_reference'];
            
            // Atualizar pedido no sistema
            $order = \App\Models\Purchase::find($externalReference);
            if ($order) {
                $order->status = PaymentStatus::APPROVED->value;
                $order->save();
            }
        }
    }

    /**
     * Mapeia o status do gateway para o enum do sistema
     */
    protected function mapStatus(string $gatewayStatus): PaymentStatus
    {
        return match($gatewayStatus) {
            'approved', 'paid' => PaymentStatus::APPROVED,
            'pending', 'waiting' => PaymentStatus::PENDING,
            'processing' => PaymentStatus::IN_PROCESS,
            'rejected', 'failed' => PaymentStatus::REJECTED,
            'cancelled' => PaymentStatus::CANCELLED,
            'refunded' => PaymentStatus::REFUNDED,
            default => PaymentStatus::PENDING,
        };
    }

    /**
     * Valida a assinatura do webhook (opcional)
     */
    protected function validateWebhookSignature(Request $request): bool
    {
        // Implementar validação de assinatura
        // $signature = $request->header('X-Signature');
        // $payload = $request->getContent();
        // $expectedSignature = hash_hmac('sha256', $payload, $this->config['webhook_secret']);
        // return hash_equals($expectedSignature, $signature);
        
        return true;
    }
}
```

## Passo 3: Registrar o Gateway

Abra `app/Providers/PaymentServiceProvider.php` e adicione seu gateway:

```php
public function boot(): void
{
    $factory = $this->app->make(PaymentGatewayFactory::class);

    // Registrar gateways disponíveis
    $factory->register('mercadopago', MercadoPagoGateway::class);
    $factory->register('stripe', StripeGateway::class);
    $factory->register('seugateway', SeuGateway::class); // ← Adicione aqui
}
```

Não esqueça de adicionar o `use` no topo do arquivo:

```php
use App\Services\Payment\Gateways\SeuGateway;
```

## Passo 4: Adicionar Logo do Gateway

Adicione o logo do gateway em `public/images/payment-gateways/seugateway.png`

## Passo 5: Configurar Webhook (Opcional)

Se o gateway usar webhooks, adicione a rota em `routes/api.php`:

```php
Route::post('/webhook/seugateway', [WebhookController::class, 'handle'])
    ->name('webhook.seugateway');
```

E no `WebhookController`:

```php
public function handle(Request $request, string $gateway)
{
    $paymentService = app(PaymentService::class);
    $gatewayInstance = $paymentService->getGateway($gateway);
    $gatewayInstance->handleWebhook($request);
    
    return response()->json(['success' => true]);
}
```

## Passo 6: Testar o Gateway

1. Acesse o painel admin em `/admin/payment-gateways`
2. Você verá seu novo gateway listado
3. Configure as credenciais do gateway
4. Teste a conexão usando o botão "Testar Conexão"
5. Faça um pagamento de teste

## Métodos Obrigatórios

Todos os gateways devem implementar:

### getName()
Retorna o nome do gateway (ex: "PayPal", "Stripe")

### getIdentifier()
Retorna o identificador único (slug) do gateway (ex: "paypal", "stripe")

### getDescription()
Retorna uma descrição do gateway

### getSupportedMethods()
Retorna array com os métodos de pagamento suportados

### getConfigFields()
Retorna array com os campos de configuração necessários

### validateCredentials()
Valida se as credenciais fornecidas são válidas

### charge()
Processa um pagamento e retorna PaymentResponseDTO

### refund()
Processa um reembolso

### getTransactionStatus()
Consulta o status de uma transação

### handleWebhook()
Processa webhooks do gateway

## DTOs Disponíveis

### PaymentRequestDTO
```php
new PaymentRequestDTO(
    amount: 100.00,              // Valor
    currency: 'BRL',             // Moeda
    paymentMethod: 'pix',        // Método de pagamento
    description: 'Compra #123',  // Descrição
    payer: [                     // Dados do pagador
        'email' => 'user@email.com',
        'name' => 'João Silva',
        'document' => '12345678900',
    ],
    token: 'card_token',         // Token do cartão (opcional)
    installments: 1,             // Parcelas (opcional)
    externalReference: '123',    // Referência externa (opcional)
    metadata: [],                // Metadados (opcional)
);
```

### PaymentResponseDTO
```php
// Sucesso
PaymentResponseDTO::success(
    status: PaymentStatus::APPROVED,
    transactionId: 'txn_123',
    message: 'Pagamento aprovado',
    data: ['key' => 'value']
);

// Erro
PaymentResponseDTO::failed(
    status: PaymentStatus::REJECTED,
    message: 'Pagamento rejeitado',
    errorCode: 'insufficient_funds'
);
```

## Enum PaymentStatus

Status disponíveis:
- `PENDING`: Pendente
- `APPROVED`: Aprovado
- `IN_PROCESS`: Em processamento
- `REJECTED`: Rejeitado
- `CANCELLED`: Cancelado
- `REFUNDED`: Reembolsado
- `CHARGED_BACK`: Chargeback

## Dicas de Implementação

1. **Trate Erros**: Sempre use try-catch e retorne erros adequados
2. **Valide Webhooks**: Sempre valide a assinatura dos webhooks
3. **Use Logs**: Registre todas as transações e erros
4. **Modo Sandbox**: Implemente modo de testes
5. **Documente**: Documente as particularidades do gateway
6. **Teste Bem**: Teste todos os cenários (sucesso, erro, webhook)

## Exemplo de Uso

```php
use App\Services\Payment\PaymentService;
use App\DTOs\Payment\PaymentRequestDTO;

$paymentService = app(PaymentService::class);

$request = PaymentRequestDTO::fromArray([
    'amount' => 100.00,
    'currency' => 'BRL',
    'payment_method' => 'pix',
    'description' => 'Compra de serviço',
    'payer' => [
        'email' => 'cliente@email.com',
        'name' => 'João Silva',
    ],
    'external_reference' => $order->id,
]);

$response = $paymentService->processPayment('seugateway', $request, $user);

if ($response->success) {
    // Pagamento aprovado
    $transactionId = $response->transactionId;
} else {
    // Pagamento falhou
    $error = $response->message;
}
```

## Suporte

Se tiver dúvidas, consulte os gateways existentes (MercadoPago, Stripe) como referência.
