@extends('admin.layouts.app')

@section('title', 'Detalhes da Categoria - Painel Administrativo')
@section('page-title', $category->name)
@section('page-subtitle', 'Visualize os detalhes da categoria')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Categoria criada em {{ $category->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar esta categoria?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash mr-2"></i> Deletar
                </button>
            </form>
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Main Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Category Details -->
        <div class="md:col-span-2 card space-y-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações da Categoria</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Nome:</dt>
                        <dd class="font-medium text-gray-900">{{ $category->name }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Descrição:</dt>
                        <dd class="font-medium text-gray-900">{{ $category->description ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Status:</dt>
                        <dd>
                            @if($category->status ?? true)
                                <span class="badge-success">Ativo</span>
                            @else
                                <span class="badge-danger">Inativo</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Serviços</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $category->services->count() ?? 0 }}</p>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Criado em</p>
                    <p class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    @if($category->services->count() > 0)
        <div class="card overflow-hidden">
            <h3 class="text-lg font-bold text-gray-900 mb-4 px-6 pt-6">Serviços nesta Categoria</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm table-striped">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Nome</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Preço</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left font-semibold text-gray-700">Data</th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->services as $service)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $service->name }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">R$ {{ number_format($service->price, 2, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($service->status)
                                        <span class="badge-success">Ativo</span>
                                    @else
                                        <span class="badge-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $service->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.services.show', $service) }}" class="text-indigo-600 hover:text-indigo-900">
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
