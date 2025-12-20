@extends('admin.layouts.app')

@section('title', 'WhatsApp - Painel Administrativo')
@section('page-title', 'Gerenciamento de Instâncias WhatsApp')
@section('page-subtitle', 'Gerencie as instâncias WhatsApp dos usuários')

@section('content')
<div x-data="whatsappManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de instâncias: <span class="font-bold">0</span></p>
        </div>
        <button class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Nova Instância
        </button>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="#" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por número ou usuário..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="connected">Conectado</option>
                <option value="disconnected">Desconectado</option>
                <option value="error">Erro</option>
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
        </form>
    </div>

    <!-- Instances Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card text-center py-12">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 font-medium">Nenhuma instância encontrada</p>
            <p class="text-gray-400 text-sm mt-1">Comece criando uma nova instância</p>
        </div>
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
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Mensagens</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">Nenhuma instância encontrada</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
