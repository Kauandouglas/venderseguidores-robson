<?php

namespace App\Repositories\Eloquent;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected function model(): string
    {
        return User::class;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findBy('email', $email);
    }

    public function findByDomain(string $domain): ?User
    {
        return $this->findBy('domain', $domain);
    }

    public function getUsers(): Collection
    {
        return $this->where('role', UserRole::USER->value)
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getAdmins(): Collection
    {
        return $this->where('role', UserRole::ADMIN->value)
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function getActiveUsers(): Collection
    {
        return $this->where('role', UserRole::USER->value)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->all();
    }

    public function isDomainAvailable(string $domain, ?int $exceptUserId = null): bool
    {
        $query = $this->model->where('domain', $domain);

        if ($exceptUserId) {
            $query->where('id', '!=', $exceptUserId);
        }

        return !$query->exists();
    }

    public function getUsersWithActivePlan(): Collection
    {
        return $this->model
            ->whereHas('planPurchase', function ($query) {
                $query->where('status', 'active')
                    ->where('expires_at', '>', now());
            })
            ->get();
    }
}
