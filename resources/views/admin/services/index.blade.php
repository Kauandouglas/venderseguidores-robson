@extends('admin.layouts.app')

@section('title', 'Serviços - Painel Administrativo')
@section('page-title', 'Gerenciamento de Serviços')
@section('page-subtitle', 'Visualize e gerencie todos os serviços disponíveis')

@section('content')
<div x-data="servicesManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de serviços: <span class="font-bold">0</span></p>
        </div>
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Serviço
        </button>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="#" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nome ou descrição..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todas as Categorias</option>
                <option value="1">Categoria 1</option>
                <option value="2">Categoria 2</option>
            </select>
            
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
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
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 font-medium">Nenhum serviço encontrado</p>
                                <p class="text-gray-400 text-sm mt-1">Comece criando um novo serviço</p>
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
    function servicesManager() {
        return {
            // Gerenciador de serviços
        };
    }
</script>
@endpush
@endsection
