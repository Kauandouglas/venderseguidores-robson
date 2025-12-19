<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver qualquer pedido
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode ver o pedido
     */
    public function view(User $user, Purchase $order): bool
    {
        return $user->id === $order->user_id || $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode criar pedidos
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode reprocessar o pedido
     */
    public function reprocess(User $user, Purchase $order): bool
    {
        return $user->id === $order->user_id || $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode cancelar o pedido
     */
    public function cancel(User $user, Purchase $order): bool
    {
        return $user->id === $order->user_id || $user->role === UserRole::ADMIN->value;
    }
}
