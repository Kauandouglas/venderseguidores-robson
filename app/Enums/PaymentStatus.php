<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case IN_PROCESS = 'in_process';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case CHARGED_BACK = 'charged_back';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendente',
            self::APPROVED => 'Aprovado',
            self::IN_PROCESS => 'Em Processamento',
            self::REJECTED => 'Rejeitado',
            self::CANCELLED => 'Cancelado',
            self::REFUNDED => 'Reembolsado',
            self::CHARGED_BACK => 'Chargeback',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::APPROVED => 'green',
            self::IN_PROCESS => 'blue',
            self::REJECTED => 'red',
            self::CANCELLED => 'gray',
            self::REFUNDED => 'purple',
            self::CHARGED_BACK => 'red',
        };
    }

    public function isApproved(): bool
    {
        return $this === self::APPROVED;
    }

    public function isFailed(): bool
    {
        return in_array($this, [self::REJECTED, self::CANCELLED]);
    }
}
