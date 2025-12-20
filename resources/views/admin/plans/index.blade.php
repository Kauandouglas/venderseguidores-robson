@extends('admin.layouts.app')

@section('title', 'Planos - Painel Administrativo')
@section('page-title', 'Gerenciamento de Planos')
@section('page-subtitle', 'Configure os planos de assinatura disponíveis')

@section('content')
<div x-data="plansManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de planos: <span class="font-bold">{{ $plans->total() }}</span></p>
        </div>
        <a href="{{ route('admin.plans.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Plano
        </a>
    </div>

    <!-- Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            <div class="card overflow-hidden hover:shadow-lg transition-shadow">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 text-white">
                    <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                    <p class="text-indigo-100 text-sm">{{ $plan->description }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <div class="text-center py-4 border-y border-gray-200">
                        <p class="text-gray-600 text-sm">Preço</p>
                        <p class="text-3xl font-bold text-indigo-600">R$ {{ number_format($plan->price, 2, ',', '.') }}</p>
                        <p class="text-gray-500 text-xs mt-1">por {{ $plan->period == 'monthly' ? 'mês' : ($plan->period == 'quarterly' ? 'trimestre' : 'ano') }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center py-2">
                        <div>
                            <p class="text-gray-600 text-xs">Assinantes</p>
                            <p class="font-bold text-gray-900">{{ $plan->purchases_count ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-xs">Status</p>
                            @if($plan->status)
                                <span class="badge-success text-xs">Ativo</span>
                            @else
                                <span class="badge-danger text-xs">Inativo</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('admin.plans.show', $plan) }}" class="flex-1 btn-secondary text-center text-sm">
                            <i class="fas fa-eye mr-1"></i> Ver
                        </a>
                        <a href="{{ route('admin.plans.edit', $plan) }}" class="flex-1 btn-primary text-center text-sm">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Nenhum plano encontrado</p>
                    <p class="text-gray-400 text-sm mt-1">Comece criando um novo plano</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Plans Table View -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Nome</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Preço</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Período</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Assinantes</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $plan->name }}</td>
                            <td class="px-6 py-4 font-bold text-indigo-600">R$ {{ number_format($plan->price, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($plan->period == 'monthly')
                                    Mensal
                                @elseif($plan->period == 'quarterly')
                                    Trimestral
                                @else
                                    Anual
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-info">{{ $plan->purchases_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($plan->status)
                                    <span class="badge-success">Ativo</span>
                                @else
                                    <span class="badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $plan->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.plans.edit', $plan) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
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
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Nenhum plano encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($plans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $plans->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function plansManager() {
        return {
            // Gerenciador de planos
        };
    }
</script>
@endpush
@endsection
