<?php

namespace App\Enums;

enum PlanType: string
{
    case FREE = 'free';
    case BASIC = 'basic';
    case PRO = 'pro';
    case ENTERPRISE = 'enterprise';

    public function label(): string
    {
        return match($this) {
            self::FREE => 'Gratuito',
            self::BASIC => 'Básico',
            self::PRO => 'Profissional',
            self::ENTERPRISE => 'Empresarial',
        };
    }

    public function maxServices(): int
    {
        return match($this) {
            self::FREE => 4,
            self::BASIC => 20,
            self::PRO => 100,
            self::ENTERPRISE => PHP_INT_MAX,
        };
    }

    public function maxCategories(): int
    {
        return match($this) {
            self::FREE => 3,
            self::BASIC => 10,
            self::PRO => 50,
            self::ENTERPRISE => PHP_INT_MAX,
        };
    }

    public function features(): array
    {
        return match($this) {
            self::FREE => [
                'Até 4 serviços',
                'Até 3 categorias',
                'Suporte por email',
            ],
            self::BASIC => [
                'Até 20 serviços',
                'Até 10 categorias',
                'Domínio personalizado',
                'Suporte prioritário',
            ],
            self::PRO => [
                'Até 100 serviços',
                'Até 50 categorias',
                'Domínio personalizado',
                'Múltiplos temas',
                'Suporte 24/7',
                'Relatórios avançados',
            ],
            self::ENTERPRISE => [
                'Serviços ilimitados',
                'Categorias ilimitadas',
                'Domínio personalizado',
                'Todos os temas',
                'Suporte dedicado',
                'API personalizada',
                'White label',
            ],
        };
    }
}
