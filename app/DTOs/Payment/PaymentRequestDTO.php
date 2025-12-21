<?php

namespace App\DTOs\Payment;

class PaymentRequestDTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly string $paymentMethod,
        public readonly string $description,
        public readonly array $payer,
        public readonly ?string $token = null,
        public readonly ?int $installments = 1,
        public readonly ?string $externalReference = null,
        public readonly ?array $metadata = [],
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            currency: $data['currency'] ?? 'BRL',
            paymentMethod: $data['payment_method'],
            description: $data['description'],
            payer: $data['payer'],
            token: $data['token'] ?? null,
            installments: $data['installments'] ?? 1,
            externalReference: $data['external_reference'] ?? null,
            metadata: $data['metadata'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_method' => $this->paymentMethod,
            'description' => $this->description,
            'payer' => $this->payer,
            'token' => $this->token,
            'installments' => $this->installments,
            'external_reference' => $this->externalReference,
            'metadata' => $this->metadata,
        ];
    }
}
