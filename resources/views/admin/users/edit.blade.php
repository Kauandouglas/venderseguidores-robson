@extends('admin.layouts.app')

@section('title', 'Editar Usuário - Painel Administrativo')
@section('page-title', 'Editar Usuário')
@section('page-subtitle', $user->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- User Info Card -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-3xl font-bold shadow-xl">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-1">{{ $user->name }}</h2>
                <p class="text-indigo-100 text-sm flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    {{ $user->email }}
                </p>
                <p class="text-indigo-100 text-sm flex items-center mt-1">
                    <i class="fas fa-calendar mr-2"></i>
                    Cadastrado em {{ $user->created_at->format('d/m/Y') }}
                </p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-semibold">
                    <i class="fas fa-hashtag mr-1"></i>
                    ID: {{ $user->id }}
                </span>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-edit text-indigo-600 mr-3"></i>
                Informações do Usuário
            </h3>
            <p class="text-sm text-gray-600 mt-1">Atualize os dados do usuário abaixo</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-indigo-600"></i>
                    </div>
                    Dados Pessoais
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-indigo-600"></i> Nome Completo
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                            placeholder="Digite o nome completo"
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1 text-indigo-600"></i> Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                            placeholder="email@exemplo.com"
                        >
                        @error('email')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-indigo-600"></i> Telefone
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300"
                            placeholder="(00) 00000-0000"
                        >
                        @error('phone')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Domain -->
                    <div>
                        <label for="domain" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-globe mr-1 text-indigo-600"></i> Domínio
                        </label>
                        <input 
                            type="text" 
                            id="domain" 
                            name="domain" 
                            value="{{ old('domain', $user->domain) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 @error('domain') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                            placeholder="meusite.com.br"
                        >
                        @error('domain')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Security Section -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-lock text-purple-600"></i>
                    </div>
                    Segurança
                </h4>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Alteração de senha</p>
                            <p>Deixe os campos em branco se não desejar alterar a senha atual do usuário.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-purple-600"></i> Nova Senha
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('password') border-red-500 ring-2 ring-red-200 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-purple-600"></i> Confirmar Senha
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <!-- Access Control Section -->
            <div>
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    Controle de Acesso
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-1 text-green-600"></i> Função
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 bg-white @error('role') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                        >
                            <option value="2" {{ old('role', $user->role) == 2 ? 'selected' : '' }}>
                                👤 Usuário
                            </option>
                            <option value="1" {{ old('role', $user->role) == 1 ? 'selected' : '' }}>
                                👑 Administrador
                            </option>
                        </select>
                        @error('role')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-toggle-on mr-1 text-green-600"></i> Status
                        </label>
                        <div class="flex gap-4 h-12 items-center">
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="1" 
                                    {{ old('status', $user->status) == 1 ? 'checked' : '' }}
                                    class="w-5 h-5 text-green-600 focus:ring-2 focus:ring-green-500 cursor-pointer"
                                >
                                <span class="ml-3 text-gray-700 font-medium group-hover:text-green-600 transition-colors flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Ativo
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="0" 
                                    {{ old('status', $user->status) == 0 ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-600 focus:ring-2 focus:ring-red-500 cursor-pointer"
                                >
                                <span class="ml-3 text-gray-700 font-medium group-hover:text-red-600 transition-colors flex items-center">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Inativo
                                </span>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 md:flex-none px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Salvar Alterações
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="flex-1 md:flex-none px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <a href="{{ route('admin.users.index') }}" class="hidden md:flex px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:border-gray-400 transition-all duration-300 items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar à Lista
                </a>
            </div>
        </form>
    </div>

    <!-- Additional Info Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-info-circle text-blue-600 mr-3"></i>
            Informações Adicionais
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4">
                <p class="text-sm text-gray-600 mb-1">Data de Cadastro</p>
                <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4">
                <p class="text-sm text-gray-600 mb-1">Última Atualização</p>
                <p class="text-lg font-bold text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4">
                <p class="text-sm text-gray-600 mb-1">Status Atual</p>
                <p class="text-lg font-bold {{ $user->status ? 'text-green-600' : 'text-red-600' }}">
                    {{ $user->status ? 'Ativo' : 'Inativo' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection