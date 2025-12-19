<?php

namespace App\Repositories\Eloquent;

use App\Enums\OrderStatus;
use App\Models\Purchase;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected function model(): string
    {
        return Purchase::class;
    }

    public function getByUser(int $userId): Collection
    {
        return $this->where('user_id', $userId)
            ->with(['service', 'payment'])
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getByStatus(OrderStatus $status): Collection
    {
        return $this->where('status', $status->value)
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getPending(): Collection
    {
        return $this->getByStatus(OrderStatus::PENDING);
    }

    public function getFailed(): Collection
    {
        return $this->getByStatus(OrderStatus::FAILED);
    }

    public function updateStatus(int $id, OrderStatus $status): bool
    {
        return $this->update($id, ['status' => $status->value]);
    }

    public function getToday(): Collection
    {
        return $this->model
            ->whereDate('created_at', today())
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTotalSales(): float
    {
        return $this->model
            ->where('status', OrderStatus::COMPLETED->value)
            ->sum('price');
    }

    public function getSalesByPeriod(string $startDate, string $endDate): float
    {
        return $this->model
            ->where('status', OrderStatus::COMPLETED->value)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('price');
    }

    public function getWithErrors(): Collection
    {
        return $this->model
            ->whereNotNull('error')
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
