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
        {{-- <a href="{{ route('admin.plans.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Plano
        </a> --}}
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
                        <p class="text-gray-500 text-xs mt-1">por mês</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center py-2">
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
