@extends('admin.layouts.app')

@section('title', 'Detalhes do Pedido - Painel Administrativo')
@section('page-title', 'Detalhes do Pedido')
@section('page-subtitle', 'Pedido #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div></div>
        <div class="flex gap-3">
            @if($order->status == 'failed')
                <button class="btn-success">
                    <i class="fas fa-redo mr-2"></i> Reprocessar
                </button>
            @endif
            <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Order Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Details -->
            <div class="card">
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Pedido #{{ $order->id }}</h2>
                        <p class="text-gray-600 mt-1">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
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
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Valor Total</p>
                        <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status do Pagamento</p>
                        <p class="font-medium text-gray-900">
                            @switch($order->status)
                                @case('completed')
                                    <span class="text-green-600">Pago</span>
                                    @break
                                @case('pending')
                                    <span class="text-yellow-600">Aguardando</span>
                                    @break
                                @case('failed')
                                    <span class="text-red-600">Falha</span>
                                    @break
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações do Usuário</h3>
                <div class="flex items-start space-x-4 pb-6 border-b border-gray-200">
                    <img src="https://via.placeholder.com/60" alt="{{ $order->user->name }}" class="w-16 h-16 rounded-full">
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-gray-600">{{ $order->user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">ID: #{{ $order->user->id }}</p>
                    </div>
                    <a href="{{ route('admin.users.show', $order->user) }}" class="btn-secondary">
                        <i class="fas fa-arrow-right mr-2"></i> Ver Perfil
                    </a>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Domínio</p>
                        <p class="font-medium text-gray-900">{{ $order->user->domain }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Telefone</p>
                        <p class="font-medium text-gray-900">{{ $order->user->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Service Information -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações do Serviço</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Serviço</p>
                        <p class="font-medium text-gray-900">{{ $order->service->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Categoria</p>
                        <p class="font-medium text-gray-900">{{ $order->service->category->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Preço Unitário</p>
                        <p class="font-medium text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Quantidade</p>
                        <p class="font-medium text-gray-900">1</p>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Histórico do Pedido</h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center">
                            <div class="w-4 h-4 bg-green-600 rounded-full"></div>
                            <div class="w-0.5 h-12 bg-gray-300 mt-2"></div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Pedido Criado</p>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    @if($order->status == 'completed')
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 bg-green-600 rounded-full"></div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Pedido Concluído</p>
                                <p class="text-sm text-gray-600">{{ $order->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    @elseif($order->status == 'failed')
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 bg-red-600 rounded-full"></div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Pedido Falhou</p>
                                <p class="text-sm text-gray-600">{{ $order->updated_at->format('d/m/Y H:i:s') }}</p>
                                @if($order->error)
                                    <p class="text-sm text-red-600 mt-2">Erro: {{ $order->error }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-4 h-4 bg-yellow-600 rounded-full"></div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Aguardando Processamento</p>
                                <p class="text-sm text-gray-600">Pendente desde {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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
                    @if($order->status != 'completed')
                        <button class="w-full btn-success text-left">
                            <i class="fas fa-check mr-2"></i> Marcar como Concluído
                        </button>
                    @endif
                    @if($order->status != 'failed')
                        <button class="w-full btn-danger text-left">
                            <i class="fas fa-times mr-2"></i> Marcar como Falha
                        </button>
                    @endif
                    <button class="w-full btn-secondary text-left">
                        <i class="fas fa-print mr-2"></i> Imprimir
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Resumo do Pedido</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Impostos</span>
                        <span class="font-medium text-gray-900">R$ 0,00</span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                        <span class="text-gray-600">Desconto</span>
                        <span class="font-medium text-gray-900">R$ 0,00</span>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-indigo-600">R$ {{ number_format($order->price, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Info -->
            <div class="card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações de Status</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status Atual</p>
                        <p class="font-medium text-gray-900 capitalize">{{ $order->status }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Última Atualização</p>
                        <p class="font-medium text-gray-900">{{ $order->updated_at->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">ID da Transação</p>
                        <p class="font-medium text-gray-900 font-mono text-xs">{{ $order->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
