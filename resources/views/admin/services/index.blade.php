@extends('admin.layouts.app')

@section('title', 'Serviços - Painel Administrativo')
@section('page-title', 'Gerenciamento de Serviços')
@section('page-subtitle', 'Visualize e gerencie todos os serviços disponíveis')

@section('content')
<div x-data="servicesManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de serviços: <span class="font-bold">{{ $services->total() }}</span></p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Serviço
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="{{ route('admin.services.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nome ou descrição..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todas as Categorias</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
        </form>
    </div>

    <!-- Services Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Nome</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Categoria</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Preço</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Descrição</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $service->name }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="badge-info">{{ $service->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-600 truncate">{{ Str::limit($service->description, 50) }}</td>
                            <td class="px-6 py-4">
                                @if($service->status)
                                    <span class="badge-success">Ativo</span>
                                @else
                                    <span class="badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $service->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.services.show', $service) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhum serviço encontrado</p>
                                    <p class="text-gray-400 text-sm mt-1">Comece criando um novo serviço</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function servicesManager() {
        return {
            // Gerenciador de serviços
        };
    }
</script>
@endpush
@endsection
