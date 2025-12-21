<?php

namespace App\Repositories\Contracts;

use App\Contracts\RepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Encontra usuário por email
     */
    public function findByEmail(string $email): ?User;

    /**
     * Encontra usuário por domínio
     */
    public function findByDomain(string $domain): ?User;

    /**
     * Retorna apenas usuários (não admins)
     */
    public function getUsers(): Collection;

    /**
     * Retorna apenas admins
     */
    public function getAdmins(): Collection;

    /**
     * Retorna usuários ativos
     */
    public function getActiveUsers(): Collection;

    /**
     * Verifica se domínio está disponível
     */
    public function isDomainAvailable(string $domain, ?int $exceptUserId = null): bool;

    /**
     * Retorna usuários com plano ativo
     */
    public function getUsersWithActivePlan(): Collection;
}
