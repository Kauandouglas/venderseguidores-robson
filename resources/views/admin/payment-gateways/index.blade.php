@extends('admin.layouts.app')

@section('title', 'Gateways de Pagamento - Painel Administrativo')
@section('page-title', 'Gerenciamento de Gateways de Pagamento')
@section('page-subtitle', 'Configure e gerencie os métodos de pagamento')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de gateways: <span class="font-bold">{{ count($gateways ?? []) }}</span></p>
        </div>
    </div>

    <!-- Gateways Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($gateways ?? [] as $gateway)
            <div class="card">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $gateway['name'] ?? 'Gateway' }}</h3>
                        <p class="text-sm text-gray-600">{{ $gateway['description'] ?? 'Descrição não disponível' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-indigo-600 text-xl"></i>
                    </div>
                </div>

                <!-- Gateway Info -->
                <div class="grid grid-cols-2 gap-4 py-4 border-y border-gray-200 mb-4">
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        @if($gateway['enabled'] ?? false)
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-danger">Inativo</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Tipo</p>
                        <span class="badge-info">{{ $gateway['type'] ?? 'Padrão' }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.payment-gateways.show', $gateway['identifier'] ?? '') }}" class="flex-1 btn-secondary text-center text-sm">
                        <i class="fas fa-eye mr-1"></i> Ver
                    </a>
                    <a href="{{ route('admin.payment-gateways.configure', $gateway['identifier'] ?? '') }}" class="flex-1 btn-primary text-center text-sm">
                        <i class="fas fa-cog mr-1"></i> Configurar
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Nenhum gateway encontrado</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Popular Gateways -->
    <div class="card">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Gateways Populares</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-stripe text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Stripe</p>
                        <p class="text-xs text-gray-500">Pagamentos internacionais</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-paypal text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">PayPal</p>
                        <p class="text-xs text-gray-500">Carteira digital global</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-mobile-alt text-purple-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Mercado Pago</p>
                        <p class="text-xs text-gray-500">Pagamentos Brasil</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">PagSeguro</p>
                        <p class="text-xs text-gray-500">Pagamentos Brasil</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-coins text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Asaas</p>
                        <p class="text-xs text-gray-500">Pagamentos Brasil</p>
                    </div>
                </div>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-500 transition-colors cursor-pointer">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Adicionar Gateway</p>
                        <p class="text-xs text-gray-500">Integrar novo método</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
