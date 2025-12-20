@extends('admin.layouts.app')

@section('title', 'Criar Plano - Painel Administrativo')
@section('page-title', 'Criar Novo Plano')
@section('page-subtitle', 'Adicione um novo plano de assinatura')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.plans.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Plano</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Ex: Plano Básico"
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
                    placeholder="Descreva o plano e seus benefícios"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                >{{ old('description') }}</textarea>
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
                    value="{{ old('price') }}"
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
                    <option value="">Selecione um período</option>
                    <option value="monthly" {{ old('period') == 'monthly' ? 'selected' : '' }}>Mensal</option>
                    <option value="quarterly" {{ old('period') == 'quarterly' ? 'selected' : '' }}>Trimestral</option>
                    <option value="annual" {{ old('period') == 'annual' ? 'selected' : '' }}>Anual</option>
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
                    placeholder="Recurso 1&#10;Recurso 2&#10;Recurso 3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('features') border-red-500 @enderror"
                >{{ old('features') }}</textarea>
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
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Criar Plano
                </button>
                <a href="{{ route('admin.plans.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
