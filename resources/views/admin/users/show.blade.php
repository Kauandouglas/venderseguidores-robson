@extends('admin.layouts.app')

@section('title', 'Detalhes do Usuário - Painel Administrativo')
@section('page-title', 'Detalhes do Usuário')
@section('page-subtitle', $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div></div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- User Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="card">
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center space-x-4">
                        <img src="https://via.placeholder.com/80" alt="{{ $user->name }}" class="w-20 h-20 rounded-full">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="flex gap-2 mt-2">
                                @if($user->status)
                                    <span class="badge-success">Ativo</span>
                                @else
                                    <span class="badge-danger">Inativo</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Domínio</p>
                        <p class="font-medium text-gray-900">{{ $user->domain }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Telefone</p>
                        <p class="font-medium text-gray-900">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Data de Cadastro</p>
                        <p class="font-medium text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Última Atualização</p>
                        <p class="font-medium text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">ID do Usuário</p>
                        <p class="font-medium text-gray-900">#{{ $user->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 gap-6">
                <div class="card">
                    <p class="text-sm text-gray-600 mb-2">Total de Pedidos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-check-circle text-green-600 mr-1"></i>
                        {{ $stats['completed_orders'] }} concluídos
                    </p>
                </div>

                <div class="card">
                    <p class="text-sm text-gray-600 mb-2">Receita Total</p>
                    <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($stats['total_revenue'], 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-arrow-up text-green-600 mr-1"></i>
                        Ticket médio: R$ {{ $stats['total_orders'] > 0 ? number_format($stats['total_revenue'] / $stats['total_orders'], 2, ',', '.') : '0,00' }}
                    </p>
                </div>

                <div class="card">
                    <p class="text-sm text-gray-600 mb-2">Total de Serviços</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_services'] }}</p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-check-circle text-green-600 mr-1"></i>
                        {{ $stats['active_services'] }} ativos
                    </p>
                </div>

                <div class="card">
                    <p class="text-sm text-gray-600 mb-2">Taxa de Conversão</p>
                    <p class="text-3xl font-bold text-gray-900">
                        @if($stats['total_orders'] > 0)
                            {{ round(($stats['completed_orders'] / $stats['total_orders']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </p>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Taxa de sucesso
                    </p>
                </div>
            </div>

            <!-- Plan Information -->
            @if($user->planPurchase)
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Plano Ativo</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Plano</p>
                            <p class="font-medium text-gray-900">{{ $user->planPurchase->plan->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Status</p>
                            <span class="badge-success">Ativo</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Data de Início</p>
                            <p class="font-medium text-gray-900">{{ $user->planPurchase->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Próxima Renovação</p>
                            <p class="font-medium text-gray-900">{{ $user->planPurchase->expires_at ? $user->planPurchase->expires_at->format('d/m/Y') : 'Sem data' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ações Rápidas</h3>
                <div class="space-y-2">
                    <button class="w-full btn-primary text-left">
                        <i class="fas fa-envelope mr-2"></i> Enviar Email
                    </button>
                    <button class="w-full btn-secondary text-left">
                        <i class="fas fa-key mr-2"></i> Resetar Senha
                    </button>
                    <button class="w-full btn-secondary text-left">
                        <i class="fas fa-download mr-2"></i> Exportar Dados
                    </button>
                    <button class="w-full btn-danger text-left">
                        <i class="fas fa-trash mr-2"></i> Deletar Usuário
                    </button>
                </div>
            </div>

            <!-- System Settings -->
            @if($user->systemSetting)
                <div class="card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Configurações do Sistema</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">API Key Ativa</span>
                            <span class="badge-success">Sim</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">2FA Habilitado</span>
                            <span class="badge-danger">Não</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Notificações</span>
                            <span class="badge-success">Ativas</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Orders -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Últimos Pedidos</h3>
                <div class="space-y-3">
                    @forelse($user->purchases()->latest()->take(5)->get() as $order)
                        <div class="pb-3 border-b border-gray-200 last:border-0">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                                <span class="text-sm font-medium">R$ {{ number_format($order->price, 2, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Nenhum pedido encontrado</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Histórico de Pedidos</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Serviço</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Valor</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Data</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->purchases()->latest()->take(10)->get() as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->service->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
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
                            <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Nenhum pedido encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
