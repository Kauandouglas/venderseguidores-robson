@extends('admin.layouts.app')

@section('title', 'Editar Serviço - Painel Administrativo')
@section('page-title', 'Editar Serviço')
@section('page-subtitle', 'Atualize as informações do serviço')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Serviço</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $service->name) }}"
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
                >{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                <select 
                    id="category_id" 
                    name="category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('category_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
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
                    value="{{ old('price', $service->price) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('price') border-red-500 @enderror"
                    required
                >
                @error('price')
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
                    <option value="1" {{ old('status', $service->status) == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ old('status', $service->status) == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Atualizar Serviço
                </button>
                <a href="{{ route('admin.services.show', $service) }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
