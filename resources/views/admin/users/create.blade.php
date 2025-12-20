@extends('admin.layouts.app')

@section('title', 'Novo Usuário - Painel Administrativo')
@section('page-title', 'Criar Novo Usuário')
@section('page-subtitle', 'Adicione um novo usuário ao sistema')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl">
                <i class="fas fa-user-plus text-3xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold mb-1">Adicionar Novo Usuário</h2>
                <p class="text-indigo-100 text-sm">
                    Preencha os dados abaixo para criar uma nova conta de usuário no sistema
                </p>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-clipboard-list text-indigo-600 mr-3"></i>
                Dados do Novo Usuário
            </h3>
            <p class="text-sm text-gray-600 mt-1">Todos os campos marcados com * são obrigatórios</p>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

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
                            <i class="fas fa-user mr-1 text-indigo-600"></i> Nome Completo *
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
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
                            <i class="fas fa-envelope mr-1 text-indigo-600"></i> Email *
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
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
                            value="{{ old('phone') }}"
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
                            <i class="fas fa-globe mr-1 text-indigo-600"></i> Domínio *
                        </label>
                        <input 
                            type="text" 
                            id="domain" 
                            name="domain" 
                            value="{{ old('domain') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 @error('domain') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                            placeholder="meusite"
                        >
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Será convertido para slug automaticamente
                        </p>
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
                
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-shield-alt text-amber-600 mt-1 mr-3"></i>
                        <div class="text-sm text-amber-800">
                            <p class="font-semibold mb-1">Requisitos de senha</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Mínimo de 8 caracteres</li>
                                <li>Recomendado: Letras maiúsculas, minúsculas, números e símbolos</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-key mr-1 text-purple-600"></i> Senha *
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('password') border-red-500 ring-2 ring-red-200 @enderror"
                                required
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
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
                            <i class="fas fa-key mr-1 text-purple-600"></i> Confirmar Senha *
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                                required
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            >
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
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
                            <i class="fas fa-user-tag mr-1 text-green-600"></i> Função *
                        </label>
                        <select 
                            id="role" 
                            name="role" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300 bg-white @error('role') border-red-500 ring-2 ring-red-200 @enderror"
                            required
                        >
                            <option value="">Selecione uma função</option>
                            <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>
                                👤 Usuário
                            </option>
                            <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>
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
                            <i class="fas fa-toggle-on mr-1 text-green-600"></i> Status *
                        </label>
                        <div class="flex gap-4 h-12 items-center">
                            <label class="flex items-center cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="status" 
                                    value="1" 
                                    {{ old('status', '1') == '1' ? 'checked' : '' }}
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
                                    {{ old('status') == '0' ? 'checked' : '' }}
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
                    <i class="fas fa-plus mr-2"></i> Criar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="flex-1 md:flex-none px-8 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Help Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-question-circle text-blue-600 mr-3"></i>
            Dicas de Cadastro
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-envelope text-blue-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Email Único</p>
                    <p class="text-xs text-gray-600 mt-1">O email deve ser único no sistema e será usado para login</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-globe text-purple-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Domínio Personalizado</p>
                    <p class="text-xs text-gray-600 mt-1">O domínio será usado como identificador único do usuário</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-green-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Segurança</p>
                    <p class="text-xs text-gray-600 mt-1">Use senhas fortes com letras, números e símbolos</p>
                </div>
            </div>
            
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-tag text-amber-600"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Função</p>
                    <p class="text-xs text-gray-600 mt-1">Administradores têm acesso total ao sistema</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');
        
        if (field.type === 'password') {
            field.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection