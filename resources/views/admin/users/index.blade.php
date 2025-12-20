@extends('admin.layouts.app')

@section('title', 'Usuários - Painel Administrativo')
@section('page-title', 'Gerenciamento de Usuários')
@section('page-subtitle', 'Visualize e gerencie todos os usuários do sistema')

@section('content')
<div x-data="usersManager()" class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Total de usuários: <span class="font-bold">{{ $users->total() }}</span></p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> Novo Usuário
        </a>
    </div>

    <!-- Filters -->
    <div class="card">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-64">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar por nome, email ou domínio..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
            </div>
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos os Status</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ativo</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
            </select>
            
            <button type="submit" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Filtrar
            </button>
            
            @if(request('search') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm table-striped">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Usuário</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Domínio</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Telefone</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Plano</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Data de Cadastro</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="https://via.placeholder.com/40" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="text-indigo-600 font-medium">{{ $user->domain }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <button 
                                    @click="toggleStatus({{ $user->id }}, {{ $user->status ? 'true' : 'false' }})"
                                    class="px-3 py-1 rounded-full text-sm font-medium transition-colors duration-200 {{ $user->status ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                                >
                                    {{ $user->status ? 'Ativo' : 'Inativo' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->planPurchase)
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium">
                                        {{ $user->planPurchase->plan->name ?? 'Plano' }}
                                    </span>
                                @else
                                    <span class="text-gray-500 text-xs">Sem plano</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors" title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button 
                                        @click="deleteUser({{ $user->id }})"
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors" 
                                        title="Deletar"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 font-medium">Nenhum usuário encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Mostrando <span class="font-bold">{{ $users->firstItem() }}</span> a 
                <span class="font-bold">{{ $users->lastItem() }}</span> de 
                <span class="font-bold">{{ $users->total() }}</span> usuários
            </p>
            <div class="flex gap-2">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function usersManager() {
        return {
            toggleStatus(userId, currentStatus) {
                if (confirm('Tem certeza que deseja alterar o status deste usuário?')) {
                    fetch(`/admin/users/${userId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            },
            
            deleteUser(userId) {
                if (confirm('Tem certeza que deseja deletar este usuário? Esta ação não pode ser desfeita.')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/users/${userId}`;
                    form.innerHTML = `
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        };
    }
</script>
@endpush
@endsection
