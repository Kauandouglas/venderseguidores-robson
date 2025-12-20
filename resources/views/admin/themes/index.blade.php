@extends('admin.layouts.app')

@section('title', 'Temas - Painel Administrativo')
@section('page-title', 'Gerenciamento de Temas')
@section('page-subtitle', 'Visualize e gerencie os temas disponíveis')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de temas: <span class="font-bold">{{ count($themes ?? []) }}</span></p>
        </div>
    </div>

    <!-- Themes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($themes ?? [] as $theme)
            <div class="card overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <!-- Theme Preview -->
                <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mb-4">
                    <i class="fas fa-palette text-5xl opacity-50"></i>
                </div>

                <!-- Theme Info -->
                <div class="space-y-3">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $theme['name'] ?? 'Tema' }}</h3>
                        <p class="text-sm text-gray-600">{{ $theme['description'] ?? 'Descrição não disponível' }}</p>
                    </div>

                    <!-- Theme Details -->
                    <div class="grid grid-cols-2 gap-2 text-sm py-3 border-y border-gray-200">
                        <div>
                            <p class="text-gray-600">Versão</p>
                            <p class="font-medium text-gray-900">{{ $theme['version'] ?? '1.0' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Autor</p>
                            <p class="font-medium text-gray-900">{{ $theme['author'] ?? 'Desconhecido' }}</p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex items-center justify-between">
                        @if($theme['active'] ?? false)
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-info">Inativo</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('admin.themes.show', $theme['identifier'] ?? '') }}" class="flex-1 btn-secondary text-center text-sm">
                            <i class="fas fa-eye mr-1"></i> Ver
                        </a>
                        <a href="{{ route('admin.themes.preview', $theme['identifier'] ?? '') }}" class="flex-1 btn-secondary text-center text-sm">
                            <i class="fas fa-search mr-1"></i> Preview
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-medium">Nenhum tema encontrado</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
