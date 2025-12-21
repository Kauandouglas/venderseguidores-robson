<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case USER = 2;

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrador',
            self::USER => 'Usuário',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function isUser(): bool
    {
        return $this === self::USER;
    }
}
