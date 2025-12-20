@extends('admin.layouts.app')

@section('title', 'Criar Domínio - Painel Administrativo')
@section('page-title', 'Registrar Novo Domínio')
@section('page-subtitle', 'Adicione um novo domínio ao sistema')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.domains.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Domínio -->
            <div>
                <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Domínio</label>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">https://</span>
                    <input 
                        type="text" 
                        id="domain" 
                        name="domain" 
                        value="{{ old('domain') }}"
                        placeholder="exemplo.com.br"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('domain') border-red-500 @enderror"
                        required
                    >
                </div>
                @error('domain')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Usuário -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Usuário</label>
                <select 
                    id="user_id" 
                    name="user_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('user_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Data de Expiração -->
            <div>
                <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">Data de Expiração</label>
                <input 
                    type="date" 
                    id="expires_at" 
                    name="expires_at" 
                    value="{{ old('expires_at') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('expires_at') border-red-500 @enderror"
                >
                @error('expires_at')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select 
                    id="status" 
                    name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione um status</option>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inativo</option>
                    <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expirado</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Registrar Domínio
                </button>
                <a href="{{ route('admin.domains.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
