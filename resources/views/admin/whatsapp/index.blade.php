@extends('admin.layouts.app')

@section('title', 'WhatsApp - Painel Administrativo')
@section('page-title', 'Gerenciamento de Instâncias WhatsApp')
@section('page-subtitle', 'Gerencie as instâncias WhatsApp dos usuários')

@section('content')
<div x-data="whatsappManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de instâncias: <span class="font-bold">{{ $instances->total() }}</span></p>
        </div>
        <a href="{{ route('admin.whatsapp.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Nova Instância
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="{{ route('admin.whatsapp.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por número ou usuário..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="connected" {{ request('status') == 'connected' ? 'selected' : '' }}>Conectado</option>
                <option value="disconnected" {{ request('status') == 'disconnected' ? 'selected' : '' }}>Desconectado</option>
                <option value="error" {{ request('status') == 'error' ? 'selected' : '' }}>Erro</option>
            </select>

            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
        </form>
    </div>

    <!-- Instances Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Número</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Usuário</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instances as $instance)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                                {{ $instance->phone_number }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $instance->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                @if($instance->status == 'connected')
                                    <span class="badge-success">
                                        <i class="fas fa-circle text-xs mr-1"></i> Conectado
                                    </span>
                                @elseif($instance->status == 'disconnected')
                                    <span class="badge-danger">
                                        <i class="fas fa-circle text-xs mr-1"></i> Desconectado
                                    </span>
                                @else
                                    <span class="badge-warning">
                                        <i class="fas fa-circle text-xs mr-1"></i> Pendente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $instance->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.whatsapp.show', $instance) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.whatsapp.edit', $instance) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                    <form action="{{ route('admin.whatsapp.destroy', $instance) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Deletar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b border-gray-200">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhuma instância encontrada</p>
                                    <p class="text-gray-400 text-sm mt-1">Comece criando uma nova instância</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($instances->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $instances->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function whatsappManager() {
        return {
            // Gerenciador de WhatsApp
        };
    }
</script>
@endpush
@endsection
