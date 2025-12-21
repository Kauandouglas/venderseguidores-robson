<?php

namespace App\Repositories\Eloquent;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    protected function model(): string
    {
        return Service::class;
    }

    public function getByUser(int $userId): Collection
    {
        return $this->where('user_id', $userId)
            ->with(['category', 'apiProvider'])
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getActiveByUser(int $userId): Collection
    {
        return $this->where('user_id', $userId)
            ->where('status', 1)
            ->with(['category', 'apiProvider'])
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getByCategory(int $categoryId): Collection
    {
        return $this->where('category_id', $categoryId)
            ->with('apiProvider')
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getActiveByCategoryAndUser(int $categoryId, int $userId): Collection
    {
        return $this->where('category_id', $categoryId)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->with('apiProvider')
            ->orderBy('order', 'asc')
            ->all();
    }

    public function countByUserAndCategory(int $userId, int $categoryId): int
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('category_id', $categoryId)
            ->count();
    }

    public function updateStatus(int $id, bool $status): bool
    {
        return $this->update($id, ['status' => $status]);
    }

    public function getDynamicPricingServices(int $userId): Collection
    {
        return $this->where('user_id', $userId)
            ->where('dynamic_pricing', 1)
            ->with(['category', 'apiProvider'])
            ->all();
    }
}
