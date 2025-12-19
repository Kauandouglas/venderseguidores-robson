<?php

namespace App\Repositories\Contracts;

use App\Contracts\RepositoryInterface;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * Retorna pedidos de um usuário
     */
    public function getByUser(int $userId): Collection;

    /**
     * Retorna pedidos por status
     */
    public function getByStatus(OrderStatus $status): Collection;

    /**
     * Retorna pedidos pendentes
     */
    public function getPending(): Collection;

    /**
     * Retorna pedidos falhados
     */
    public function getFailed(): Collection;

    /**
     * Atualiza status do pedido
     */
    public function updateStatus(int $id, OrderStatus $status): bool;

    /**
     * Retorna pedidos de hoje
     */
    public function getToday(): Collection;

    /**
     * Retorna total de vendas
     */
    public function getTotalSales(): float;

    /**
     * Retorna total de vendas por período
     */
    public function getSalesByPeriod(string $startDate, string $endDate): float;

    /**
     * Retorna pedidos com erro
     */
    public function getWithErrors(): Collection;
}
