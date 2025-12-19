<?php

namespace App\DTOs\Payment;

use App\Enums\PaymentStatus;

class PaymentResponseDTO
{
    public function __construct(
        public readonly bool $success,
        public readonly PaymentStatus $status,
        public readonly ?string $transactionId = null,
        public readonly ?string $message = null,
        public readonly ?array $data = [],
        public readonly ?string $errorCode = null,
    ) {}

    public static function success(
        PaymentStatus $status,
        string $transactionId,
        ?string $message = null,
        ?array $data = []
    ): self {
        return new self(
            success: true,
            status: $status,
            transactionId: $transactionId,
            message: $message,
            data: $data,
        );
    }

    public static function failed(
        PaymentStatus $status,
        string $message,
        ?string $errorCode = null,
        ?array $data = []
    ): self {
        return new self(
            success: false,
            status: $status,
            message: $message,
            errorCode: $errorCode,
            data: $data,
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'status' => $this->status->value,
            'transaction_id' => $this->transactionId,
            'message' => $this->message,
            'data' => $this->data,
            'error_code' => $this->errorCode,
        ];
    }
}
