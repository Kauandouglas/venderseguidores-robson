@extends('admin.layouts.app')

@section('title', 'Novo Usuário - Painel Administrativo')
@section('page-title', 'Criar Novo Usuário')
@section('page-subtitle', 'Adicione um novo usuário ao sistema')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror"
                    required
                    placeholder="João Silva"
                >
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror"
                    required
                    placeholder="joao@example.com"
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Domain -->
            <div>
                <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">Domínio</label>
                <input 
                    type="text" 
                    id="domain" 
                    name="domain" 
                    value="{{ old('domain') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('domain') border-red-500 @enderror"
                    required
                    placeholder="joao-silva"
                >
                <p class="text-xs text-gray-500 mt-1">Será convertido para slug automaticamente</p>
                @error('domain')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="(11) 99999-9999"
                >
                @error('phone')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-500 @enderror"
                    required
                    placeholder="Mínimo 8 caracteres"
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Função</label>
                <select 
                    id="role" 
                    name="role" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('role') border-red-500 @enderror"
                    required
                >
                    <option value="">Selecione uma função</option>
                    <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Usuário</option>
                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('role')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="flex gap-4">
                    <label class="flex items-center">
                        <input 
                            type="radio" 
                            name="status" 
                            value="1" 
                            {{ old('status', '1') == '1' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600"
                        >
                        <span class="ml-2 text-gray-700">Ativo</span>
                    </label>
                    <label class="flex items-center">
                        <input 
                            type="radio" 
                            name="status" 
                            value="0" 
                            {{ old('status') == '0' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600"
                        >
                        <span class="ml-2 text-gray-700">Inativo</span>
                    </label>
                </div>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i> Criar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
