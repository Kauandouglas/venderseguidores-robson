@extends('admin.layouts.app')

@section('title', 'Categorias - Painel Administrativo')
@section('page-title', 'Gerenciamento de Categorias')
@section('page-subtitle', 'Organize os serviços em categorias')

@section('content')
<div x-data="categoriesManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de categorias: <span class="font-bold">0</span></p>
        </div>
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Nova Categoria
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 font-medium">Nenhuma categoria encontrada</p>
            <p class="text-gray-400 text-sm mt-1">Comece criando uma nova categoria</p>
        </div>
    </div>

    <!-- Categories Table View -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Nome</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Descrição</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Serviços</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Nenhuma categoria encontrada</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function categoriesManager() {
        return {
            // Gerenciador de categorias
        };
    }
</script>
@endpush
@endsection
