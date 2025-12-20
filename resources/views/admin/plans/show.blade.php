@extends('admin.layouts.app')

@section('title', 'Detalhes do Plano - Painel Administrativo')
@section('page-title', $plan->name)
@section('page-subtitle', 'Visualize os detalhes do plano')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Plano criado em {{ $plan->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar este plano?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash mr-2"></i> Deletar
                </button>
            </form>
            <a href="{{ route('admin.plans.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Main Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Plan Details -->
        <div class="md:col-span-2 card space-y-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações do Plano</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Nome:</dt>
                        <dd class="font-medium text-gray-900">{{ $plan->name }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Descrição:</dt>
                        <dd class="font-medium text-gray-900">{{ $plan->description ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Preço:</dt>
                        <dd class="font-bold text-indigo-600 text-lg">R$ {{ number_format($plan->price, 2, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Período:</dt>
                        <dd class="font-medium text-gray-900">
                            @if($plan->period == 'monthly')
                                Mensal
                            @elseif($plan->period == 'quarterly')
                                Trimestral
                            @else
                                Anual
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Status:</dt>
                        <dd>
                            @if($plan->status)
                                <span class="badge-success">Ativo</span>
                            @else
                                <span class="badge-danger">Inativo</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            @if($plan->features)
                <div class="border-t pt-6">
                    <h4 class="font-bold text-gray-900 mb-3">Recursos Inclusos</h4>
                    <ul class="space-y-2">
                        @foreach(explode("\n", $plan->features) as $feature)
                            @if(trim($feature))
                                <li class="flex items-center text-gray-700">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    {{ trim($feature) }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Assinantes</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $plan->purchases->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Receita Total</p>
                    <p class="text-2xl font-bold text-green-600">R$ {{ number_format($plan->purchases->sum('price') ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Criado em</p>
                    <p class="text-sm font-medium text-gray-900">{{ $plan->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchases Table -->
    @if($plan->purchases->count() > 0)
        <div class="card overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 px-6 pt-6">Assinantes Ativos</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-striped">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Usuário</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Data</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plan->purchases as $purchase)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">#{{ $purchase->id }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $purchase->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $purchase->user->email ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    @if($purchase->status == 'completed')
                                        <span class="badge-success">Ativo</span>
                                    @elseif($purchase->status == 'pending')
                                        <span class="badge-warning">Pendente</span>
                                    @else
                                        <span class="badge-danger">Cancelado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $purchase) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
