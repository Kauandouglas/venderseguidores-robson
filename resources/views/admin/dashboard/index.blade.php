@extends('admin.layouts.app')

@section('title', 'Dashboard - Painel Administrativo')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do sistema')

@section('content')
<div x-data="dashboardData()" class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="card hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Usuários</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $stats['active_users'] }} ativos
                    </p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="card hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de Pedidos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_orders'] }}</p>
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        {{ $stats['orders_today'] }} hoje
                    </p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="card hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Receita Total</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-arrow-up mr-1"></i>
                        R$ {{ number_format($stats['revenue_today'], 2, ',', '.') }} hoje
                    </p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="card hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pedidos Pendentes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_orders'] }}</p>
                    <p class="text-sm text-red-600 mt-2">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $stats['failed_orders'] }} falhados
                    </p>
                </div>
                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Chart -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Vendas nos Últimos 7 Dias</h3>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded-full font-medium">7 dias</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-full">30 dias</button>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Users Chart -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Novos Usuários (7 Dias)</h3>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded-full font-medium">7 dias</button>
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded-full">30 dias</button>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Users -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Últimos Usuários</h3>
                <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-striped">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Nome</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestUsers as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://via.placeholder.com/32" alt="{{ $user->name }}" class="w-8 h-8 rounded-full">
                                        <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    @if($user->status)
                                        <span class="badge-success">Ativo</span>
                                    @else
                                        <span class="badge-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum usuário encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Orders -->
        <div class="card">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Últimos Pedidos</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">Ver todos</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-striped">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Usuário</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Valor</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @switch($order->status)
                                        @case('completed')
                                            <span class="badge-success">Concluído</span>
                                            @break
                                        @case('pending')
                                            <span class="badge-warning">Pendente</span>
                                            @break
                                        @case('failed')
                                            <span class="badge-danger">Falhou</span>
                                            @break
                                        @default
                                            <span class="badge-info">{{ $order->status }}</span>
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Nenhum pedido encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Activity & System Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Stats -->
        <div class="card">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Estatísticas Rápidas</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <span class="text-gray-600">Taxa de Conversão</span>
                    <span class="font-bold text-gray-900">{{ $stats['total_orders'] > 0 ? round(($stats['total_orders'] / $stats['total_users']) * 100, 2) : 0 }}%</span>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <span class="text-gray-600">Ticket Médio</span>
                    <span class="font-bold text-gray-900">R$ {{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 2, ',', '.') : '0,00' }}</span>
                </div>
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <span class="text-gray-600">Taxa de Sucesso</span>
                    <span class="font-bold text-gray-900">{{ $stats['total_orders'] > 0 ? round((($stats['total_orders'] - $stats['failed_orders']) / $stats['total_orders']) * 100, 2) : 0 }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Usuários Inativos</span>
                    <span class="font-bold text-gray-900">{{ $stats['total_users'] - $stats['active_users'] }}</span>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="card">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Saúde do Sistema</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Banco de Dados</span>
                        <span class="text-sm font-medium text-green-600">OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 95%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Armazenamento</span>
                        <span class="text-sm font-medium text-green-600">OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Memória</span>
                        <span class="text-sm font-medium text-yellow-600">AVISO</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">CPU</span>
                        <span class="text-sm font-medium text-green-600">OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Atividades Recentes</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3 pb-4 border-b border-gray-200">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Novo usuário criado</p>
                        <p class="text-xs text-gray-500">há 2 minutos</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 pb-4 border-b border-gray-200">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Pedido completado</p>
                        <p class="text-xs text-gray-500">há 15 minutos</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3 pb-4 border-b border-gray-200">
                    <div class="w-2 h-2 bg-orange-600 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Pagamento processado</p>
                        <p class="text-xs text-gray-500">há 1 hora</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-red-600 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Falha na sincronização</p>
                        <p class="text-xs text-gray-500">há 3 horas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function dashboardData() {
        return {
            initCharts() {
                this.initSalesChart();
                this.initUsersChart();
            },
            
            initSalesChart() {
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($salesChart['labels']) !!},
                        datasets: [{
                            label: 'Vendas (R$)',
                            data: {!! json_encode($salesChart['data']) !!},
                            borderColor: '#4F46E5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#4F46E5',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'R$ ' + value.toLocaleString('pt-BR');
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            },
            
            initUsersChart() {
                const ctx = document.getElementById('usersChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($usersChart['labels']) !!},
                        datasets: [{
                            label: 'Novos Usuários',
                            data: {!! json_encode($usersChart['data']) !!},
                            backgroundColor: '#10B981',
                            borderRadius: 6,
                            maxBarThickness: 50
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        };
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const dashboard = dashboardData();
        dashboard.initCharts();
    });
</script>
@endpush
@endsection
