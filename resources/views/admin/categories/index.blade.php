@extends('admin.layouts.app')

@section('title', 'Categorias - Painel Administrativo')
@section('page-title', 'Gerenciamento de Categorias')
@section('page-subtitle', 'Organize os serviços em categorias')

@section('content')
<div x-data="categoriesManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de categorias: <span class="font-bold">{{ $categories->total() }}</span></p>
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
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Criado em</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-600 truncate">{{ Str::limit($category->description, 50) }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-info">{{ $category->services_count ?? 0 }} serviços</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($category->status ?? true)
                                    <span class="badge-success">Ativo</span>
                                @else
                                    <span class="badge-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $category->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-900" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhuma categoria encontrada</p>
                                    <p class="text-gray-400 text-sm mt-1">Comece criando uma nova categoria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $categories->links() }}
            </div>
        @endif
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
