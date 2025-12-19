<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected OrderRepositoryInterface $orderRepository
    ) {}

    public function index()
    {
        // Estatísticas gerais
        $stats = [
            'total_users' => User::where('role', UserRole::USER->value)->count(),
            'active_users' => User::where('role', UserRole::USER->value)->where('status', 1)->count(),
            'total_orders' => Purchase::count(),
            'orders_today' => Purchase::whereDate('created_at', today())->count(),
            'total_revenue' => Purchase::where('status', OrderStatus::COMPLETED->value)->sum('price'),
            'revenue_today' => Purchase::where('status', OrderStatus::COMPLETED->value)
                ->whereDate('created_at', today())
                ->sum('price'),
            'pending_orders' => Purchase::where('status', OrderStatus::PENDING->value)->count(),
            'failed_orders' => Purchase::where('status', OrderStatus::FAILED->value)->count(),
        ];

        // Últimos usuários
        $latestUsers = User::where('role', UserRole::USER->value)
            ->latest()
            ->take(10)
            ->get();

        // Últimos pedidos
        $latestOrders = Purchase::with(['user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        // Vendas dos últimos 7 dias
        $salesChart = $this->getSalesChartData();

        // Usuários cadastrados nos últimos 7 dias
        $usersChart = $this->getUsersChartData();

        return view('admin.dashboard.index', compact(
            'stats',
            'latestUsers',
            'latestOrders',
            'salesChart',
            'usersChart'
        ));
    }

    protected function getSalesChartData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d/m');
            
            $total = Purchase::where('status', OrderStatus::COMPLETED->value)
                ->whereDate('created_at', $date)
                ->sum('price');
            
            $data[] = $total;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    protected function getUsersChartData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d/m');
            
            $count = User::where('role', UserRole::USER->value)
                ->whereDate('created_at', $date)
                ->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
