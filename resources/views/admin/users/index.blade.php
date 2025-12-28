@extends('admin.layouts.app')

@section('title', 'Usuários - Painel Administrativo')
@section('page-title', 'Gerenciamento de Usuários')
@section('page-subtitle', 'Visualize e gerencie todos os usuários do sistema')

@section('content')
<div x-data="usersManager()" class="space-y-6">
    <!-- Header with Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Total de Usuários</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">{{ $users->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-blue-700"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Usuários Ativos</p>
                    <p class="text-3xl font-bold text-green-900 mt-2">{{ $users->where('status', 1)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-green-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-check text-2xl text-green-700"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-700">Usuários Inativos</p>
                    <p class="text-3xl font-bold text-red-900 mt-2">{{ $users->where('status', 0)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-red-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-times text-2xl text-red-700"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Novos (30 dias)</p>
                    <p class="text-3xl font-bold text-purple-900 mt-2">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-2xl text-purple-700"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-300">
                <i class="fas fa-download mr-2"></i> Exportar
            </button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-300">
                <i class="fas fa-filter mr-2"></i> Filtros Avançados
            </button>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary flex items-center">
            <i class="fas fa-plus mr-2"></i> Novo Usuário
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-4 flex-wrap items-end">
            <div class="flex-1 min-w-64">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-search mr-1"></i> Buscar
                </label>
                <input type="text" name="search" placeholder="Nome, email ou domínio..." value="{{ request('search') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-toggle-on mr-1"></i> Status
                </label>
                <select name="status" class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white">
                    <option value="">Todos os Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-user mr-2 text-indigo-600"></i>Usuário</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-envelope mr-2 text-indigo-600"></i>Email</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-globe mr-2 text-indigo-600"></i>Domínio</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-phone mr-2 text-indigo-600"></i>Telefone</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-toggle-on mr-2 text-indigo-600"></i>Status</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-crown mr-2 text-indigo-600"></i>Plano</th>
                        <th class="px-6 py-4 text-left font-bold text-gray-700"><i class="fas fa-calendar mr-2 text-indigo-600"></i>Cadastro</th>
                        <th class="px-6 py-4 text-center font-bold text-gray-700"><i class="fas fa-cog mr-2 text-indigo-600"></i>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4"><a href="https://{{ $user->domain }}" target="_blank" class="text-indigo-600 hover:underline">{{ $user->domain }}</a></td>
                            <td class="px-6 py-4">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <button
                                    @click="toggleStatus({{ $user->id }}, {{ $user->status ? 'true' : 'false' }})"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold transition-all duration-300 hover:shadow-md hover:scale-105 {{ $user->status ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white' : 'bg-gradient-to-r from-red-400 to-pink-500 text-white' }}"
                                >
                                    <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                    {{ $user->status ? 'Ativo' : 'Inativo' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">{{ $user->planPurchase->plan->name ?? 'Sem plano' }}</td>
                            <td class="px-6 py-4">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="p-2.5 text-blue-600 hover:bg-blue-100 rounded-xl" title="Visualizar"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2.5 text-indigo-600 hover:bg-indigo-100 rounded-xl" title="Editar"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-red-600 hover:bg-red-100 rounded-xl" title="Deletar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16 text-gray-500">
                                Nenhum usuário encontrado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="flex items-center justify-between bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center space-x-2 text-gray-600">
                Mostrando <span class="font-bold text-gray-900">{{ $users->firstItem() }}</span> a
                <span class="font-bold text-gray-900">{{ $users->lastItem() }}</span> de
                <span class="font-bold text-gray-900">{{ $users->total() }}</span> usuários
            </div>
            <div>{{ $users->links('pagination::tailwind') }}</div>
        </div>
    @endif
</div>
@endsection
