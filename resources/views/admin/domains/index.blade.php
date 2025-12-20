@extends('admin.layouts.app')

@section('title', 'Domínios - Painel Administrativo')
@section('page-title', 'Gerenciamento de Domínios')
@section('page-subtitle', 'Gerencie os domínios dos usuários')

@section('content')
<div x-data="domainsManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de domínios: <span class="font-bold">0</span></p>
        </div>
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Domínio
        </button>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="#" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por domínio ou usuário..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="active">Ativo</option>
                <option value="inactive">Inativo</option>
                <option value="expired">Expirado</option>
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
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 font-medium">Nenhum domínio encontrado</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
