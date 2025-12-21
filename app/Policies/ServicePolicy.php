<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determina se o usuário pode ver qualquer serviço
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina se o usuário pode ver o serviço
     */
    public function view(User $user, Service $service): bool
    {
        return $user->id === $service->user_id || $user->role === UserRole::ADMIN->value;
    }

    /**
     * Determina se o usuário pode criar serviços
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::USER->value;
    }

    /**
     * Determina se o usuário pode atualizar o serviço
     */
    public function update(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    /**
     * Determina se o usuário pode deletar o serviço
     */
    public function delete(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }

    /**
     * Determina se o usuário pode alterar o status do serviço
     */
    public function changeStatus(User $user, Service $service): bool
    {
        return $user->id === $service->user_id;
    }
}
