@extends('admin.layouts.app')

@section('title', 'Editar Plano - Painel Administrativo')
@section('page-title', 'Editar Plano')
@section('page-subtitle', 'Atualize as informações do plano')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.plans.update', $plan) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Plano</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $plan->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                >{{ old('description', $plan->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preço -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Preço (R$)</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    step="0.01"
                    min="0"
                    value="{{ old('price', $plan->price) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('price') border-red-500 @enderror"
                    required
                >
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Período -->
            <div>
                <label for="period" class="block text-sm font-medium text-gray-700 mb-2">Período de Cobrança</label>
                <select 
                    id="period" 
                    name="period"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('period') border-red-500 @enderror"
                    required
                >
                    <option value="monthly" {{ old('period', $plan->period) == 'monthly' ? 'selected' : '' }}>Mensal</option>
                    <option value="quarterly" {{ old('period', $plan->period) == 'quarterly' ? 'selected' : '' }}>Trimestral</option>
                    <option value="annual" {{ old('period', $plan->period) == 'annual' ? 'selected' : '' }}>Anual</option>
                </select>
                @error('period')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recursos/Features -->
            <div>
                <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Recursos (um por linha)</label>
                <textarea 
                    id="features" 
                    name="features" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('features') border-red-500 @enderror"
                >{{ old('features', $plan->features) }}</textarea>
                @error('features')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select 
                    id="status" 
                    name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >
                    <option value="1" {{ old('status', $plan->status) == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ old('status', $plan->status) == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Atualizar Plano
                </button>
                <a href="{{ route('admin.plans.show', $plan) }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
