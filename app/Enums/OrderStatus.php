<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case PARTIAL = 'partial';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendente',
            self::PROCESSING => 'Processando',
            self::COMPLETED => 'Concluído',
            self::PARTIAL => 'Parcial',
            self::CANCELED => 'Cancelado',
            self::REFUNDED => 'Reembolsado',
            self::FAILED => 'Falhou',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'yellow',
            self::PROCESSING => 'blue',
            self::COMPLETED => 'green',
            self::PARTIAL => 'orange',
            self::CANCELED => 'gray',
            self::REFUNDED => 'purple',
            self::FAILED => 'red',
        };
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function canBeProcessed(): bool
    {
        return in_array($this, [self::PENDING, self::FAILED]);
    }
}
