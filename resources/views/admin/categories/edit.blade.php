@extends('admin.layouts.app')

@section('title', 'Editar Categoria - Painel Administrativo')
@section('page-title', 'Editar Categoria')
@section('page-subtitle', 'Atualize as informações da categoria')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome da Categoria</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $category->name) }}"
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
                >{{ old('description', $category->description) }}</textarea>
                @error('description')
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
                    <option value="1" {{ old('status', $category->status ?? 1) == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ old('status', $category->status ?? 1) == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Atualizar Categoria
                </button>
                <a href="{{ route('admin.categories.show', $category) }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
