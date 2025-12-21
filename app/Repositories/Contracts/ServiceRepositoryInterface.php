<?php

namespace App\Repositories\Contracts;

use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ServiceRepositoryInterface extends RepositoryInterface
{
    /**
     * Retorna serviços de um usuário
     */
    public function getByUser(int $userId): Collection;

    /**
     * Retorna serviços ativos de um usuário
     */
    public function getActiveByUser(int $userId): Collection;

    /**
     * Retorna serviços de uma categoria
     */
    public function getByCategory(int $categoryId): Collection;

    /**
     * Retorna serviços ativos de uma categoria
     */
    public function getActiveByCategoryAndUser(int $categoryId, int $userId): Collection;

    /**
     * Conta serviços de um usuário por categoria
     */
    public function countByUserAndCategory(int $userId, int $categoryId): int;

    /**
     * Atualiza status do serviço
     */
    public function updateStatus(int $id, bool $status): bool;

    /**
     * Retorna serviços com preço dinâmico
     */
    public function getDynamicPricingServices(int $userId): Collection;
}
