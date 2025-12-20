@extends('admin.layouts.app')

@section('title', 'Pedidos - Painel Administrativo')
@section('page-title', 'Gerenciamento de Pedidos')
@section('page-subtitle', 'Visualize e gerencie todos os pedidos do sistema')

@section('content')
<div x-data="ordersManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de pedidos: <span class="font-bold">{{ $orders->total() }}</span></p>
        </div>
        <div class="flex gap-2">
            <button class="btn-secondary">
                <i class="fas fa-download mr-2"></i> Exportar
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por ID, usuário ou email..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Falhou</option>
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
            
            @if(request('search') || request('status'))
                <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Usuário</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Serviço</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Valor</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Data</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->service->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">R$ {{ number_format($order->price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <select 
                                    @change="updateStatus({{ $order->id }}, $event.target.value)"
                                    class="px-3 py-1 rounded-full text-sm font-medium border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer
                                    {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status == 'failed' ? 'bg-red-100 text-red-800' : '' }}"
                                >
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                                    <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Falhou</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status == 'failed')
                                        <button 
                                            @click="reprocessOrder({{ $order->id }})"
                                            class="p-2 text-green-600 hover:bg-green-100 rounded-lg transition-colors" 
                                            title="Reprocessar"
                                        >
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhum pedido encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Mostrando <span class="font-bold">{{ $orders->firstItem() }}</span> a 
                <span class="font-bold">{{ $orders->lastItem() }}</span> de 
                <span class="font-bold">{{ $orders->total() }}</span> pedidos
            </p>
            <div class="flex gap-2">
                {{ $orders->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function ordersManager() {
        return {
            updateStatus(orderId, status) {
                fetch(`/admin/orders/${orderId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status atualizado com sucesso!');
                    }
                })
                .catch(error => console.error('Error:', error));
            },
            
            reprocessOrder(orderId) {
                if (confirm('Tem certeza que deseja reprocessar este pedido?')) {
                    fetch(`/admin/orders/${orderId}/reprocess`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Pedido reprocessado com sucesso!');
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        };
    }
</script>
@endpush
@endsection
