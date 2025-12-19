<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver qualquer usuário
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode ver outro usuário
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode criar usuários
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode atualizar outro usuário
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode deletar outro usuário
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN->value && $user->id !== $model->id;
    }

    /**
     * Determina se o usuário pode alterar o status de outro usuário
     */
    public function changeStatus(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN->value && $user->id !== $model->id;
    }

    /**
     * Determina se o usuário pode alterar a role de outro usuário
     */
    public function changeRole(User $user, User $model): bool
    {
        return $user->role === UserRole::ADMIN->value && $user->id !== $model->id;
    }
}
