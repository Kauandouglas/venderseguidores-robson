@extends('admin.layouts.app')

@section('title', 'Domínios - Painel Administrativo')
@section('page-title', 'Gerenciamento de Domínios')
@section('page-subtitle', 'Gerencie os domínios dos usuários')

@section('content')
<div x-data="domainsManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de domínios: <span class="font-bold">{{ $domains->total() }}</span></p>
        </div>
        <a href="{{ route('admin.domains.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Domínio
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="{{ route('admin.domains.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por domínio ou usuário..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirado</option>
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
        </form>
    </div>

    <!-- Domains Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Domínio</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Usuário</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Expira em</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($domains as $domain)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <a href="https://{{ $domain->domain }}" target="_blank" class="text-indigo-600 hover:underline">
                                    {{ $domain->domain }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $domain->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                @if($domain->status == 'active')
                                    <span class="badge-success">Ativo</span>
                                @elseif($domain->status == 'inactive')
                                    <span class="badge-warning">Inativo</span>
                                @else
                                    <span class="badge-danger">Expirado</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                @if($domain->expires_at)
                                    {{ $domain->expires_at->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $domain->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.domains.show', $domain) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.domains.edit', $domain) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhum domínio encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($domains->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $domains->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function domainsManager() {
        return {
            // Gerenciador de domínios
        };
    }
</script>
@endpush
@endsection
