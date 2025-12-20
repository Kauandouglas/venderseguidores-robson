@extends('admin.layouts.app')

@section('title', 'Dashboard - Painel Administrativo')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Visão geral do sistema')

@section('content')
<div x-data="dashboardData()" class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="fas fa-users text-2xl text-blue-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-3 py-1 rounded-full">Usuários</span>
                </div>
                <p class="text-sm font-medium text-blue-700 mb-1">Total de Usuários</p>
                <p class="text-4xl font-bold text-blue-900 mb-3">{{ $stats['total_users'] }}</p>
                <div class="flex items-center text-sm">
                    <span class="flex items-center text-green-700 font-semibold">
                        <i class="fas fa-check-circle mr-1.5"></i>
                        {{ $stats['active_users'] }} ativos
                    </span>
                    <span class="mx-2 text-blue-400">•</span>
                    <span class="text-blue-600">
                        {{ $stats['total_users'] - $stats['active_users'] }} inativos
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="fas fa-shopping-cart text-2xl text-purple-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-purple-700 bg-purple-200 px-3 py-1 rounded-full">Pedidos</span>
                </div>
                <p class="text-sm font-medium text-purple-700 mb-1">Total de Pedidos</p>
                <p class="text-4xl font-bold text-purple-900 mb-3">{{ $stats['total_orders'] }}</p>
                <div class="flex items-center text-sm">
                    <span class="flex items-center text-green-700 font-semibold">
                        <i class="fas fa-arrow-up mr-1.5"></i>
                        {{ $stats['orders_today'] }} hoje
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-200 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="fas fa-dollar-sign text-2xl text-emerald-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-200 px-3 py-1 rounded-full">Receita</span>
                </div>
                <p class="text-sm font-medium text-emerald-700 mb-1">Receita Total</p>
                <p class="text-4xl font-bold text-emerald-900 mb-3">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                <div class="flex items-center text-sm">
                    <span class="flex items-center text-green-700 font-semibold">
                        <i class="fas fa-arrow-up mr-1.5"></i>
                        R$ {{ number_format($stats['revenue_today'], 2, ',', '.') }} hoje
                    </span>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 hover:shadow-2xl transition-all duration-500 hover:scale-[1.02]">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-200 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-500">
                        <i class="fas fa-clock text-2xl text-orange-600"></i>
                    </div>
                    <span class="text-xs font-semibold text-orange-700 bg-orange-200 px-3 py-1 rounded-full">Status</span>
                </div>
                <p class="text-sm font-medium text-orange-700 mb-1">Pedidos Pendentes</p>
                <p class="text-4xl font-bold text-orange-900 mb-3">{{ $stats['pending_orders'] }}</p>
                <div class="flex items-center text-sm">
                    <span class="flex items-center text-red-700 font-semibold">
                        <i class="fas fa-times-circle mr-1.5"></i>
                        {{ $stats['failed_orders'] }} falhados
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Vendas nos Últimos 7 Dias</h3>
                    <p class="text-sm text-gray-500 mt-1">Evolução das vendas diárias</p>
                </div>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Users Chart -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Novos Usuários (7 Dias)</h3>
                    <p class="text-sm text-gray-500 mt-1">Cadastros realizados por dia</p>
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
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white">Últimos Usuários</h3>
                        <p class="text-blue-100 text-sm mt-0.5">Registros mais recentes</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-50 transition-colors duration-200">
                        Ver todos
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Nome</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestUsers as $user)
                                <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->status)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                Ativo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                                Inativo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-users text-4xl mb-3"></i>
                                            <p class="text-sm font-medium">Nenhum usuário encontrado</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Orders -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white">Últimos Pedidos</h3>
                        <p class="text-purple-100 text-sm mt-0.5">Transações recentes</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-white text-purple-600 rounded-lg text-sm font-semibold hover:bg-purple-50 transition-colors duration-200">
                        Ver todos
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Usuário</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Valor</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                                <tr class="border-b border-gray-100 hover:bg-purple-50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-bold text-purple-600">#{{ $order->id }}</td>
                                    <td class="px-4 py-3 text-gray-700 font-medium">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        @switch($order->status)
                                            @case('completed')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Concluído
                                                </span>
                                                @break
                                            @case('pending')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pendente
                                                </span>
                                                @break
                                            @case('failed')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Falhou
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                    {{ $order->status }}
                                                </span>
                                        @endswitch
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                                            <p class="text-sm font-medium">Nenhum pedido encontrado</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Estatísticas Rápidas</h3>
                    <p class="text-sm text-gray-500">Indicadores de performance</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-percentage text-blue-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Taxa de Conversão</span>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">
                            {{ $stats['total_orders'] > 0 ? round(($stats['total_orders'] / $stats['total_users']) * 100, 2) : 0 }}%
                        </span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-ticket-alt text-purple-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Ticket Médio</span>
                        </div>
                        <span class="text-2xl font-bold text-purple-600">
                            R$ {{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 2, ',', '.') : '0,00' }}
                        </span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-check-double text-green-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Taxa de Sucesso</span>
                        </div>
                        <span class="text-2xl font-bold text-green-600">
                            {{ $stats['total_orders'] > 0 ? round((($stats['total_orders'] - $stats['failed_orders']) / $stats['total_orders']) * 100, 2) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-server text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Saúde do Sistema</h3>
                    <p class="text-sm text-gray-500">Monitoramento de recursos</p>
                </div>
            </div>
            <div class="space-y-5">
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-database text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">Banco de Dados</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-full">95% OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: 95%"></div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-hdd text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">Armazenamento</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-full">65% OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: 65%"></div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-memory text-yellow-600 mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">Memória</span>
                        </div>
                        <span class="text-xs font-bold text-yellow-600 bg-yellow-100 px-2.5 py-1 rounded-full">78% AVISO</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-2.5 rounded-full transition-all duration-500" style="width: 78%"></div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <i class="fas fa-microchip text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-gray-700">CPU</span>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2.5 py-1 rounded-full">45% OK</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: 45%"></div>
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
                            borderColor: '#6366F1',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#6366F1',
                            pointBorderWidth: 3,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#6366F1',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                borderRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: function(context) {
                                        return 'Vendas: R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
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
                                    font: {
                                        size: 12
                                    },
                                    callback: function(value) {
                                        return 'R$ ' + value.toLocaleString('pt-BR');
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
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
                            backgroundColor: 'rgba(16, 185, 129, 0.8)',
                            hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                            borderRadius: 8,
                            maxBarThickness: 60
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                borderRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 13
                                }
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
                                    font: {
                                        size: 12
                                    },
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 12
                                    }
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