@extends('admin.layouts.app')

@section('title', 'Configurações - Painel Administrativo')
@section('page-title', 'Configurações do Sistema')
@section('page-subtitle', 'Gerencie as configurações gerais da plataforma')

@section('content')
<div x-data="settingsManager()" class="space-y-6">
    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <div class="flex gap-8">
            <button 
                @click="activeTab = 'general'" 
                :class="activeTab === 'general' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="py-4 font-medium transition-colors"
            >
                <i class="fas fa-cog mr-2"></i> Geral
            </button>
            <button 
                @click="activeTab = 'email'" 
                :class="activeTab === 'email' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="py-4 font-medium transition-colors"
            >
                <i class="fas fa-envelope mr-2"></i> Email
            </button>
            <button 
                @click="activeTab = 'security'" 
                :class="activeTab === 'security' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="py-4 font-medium transition-colors"
            >
                <i class="fas fa-shield-alt mr-2"></i> Segurança
            </button>
            <button 
                @click="activeTab = 'system'" 
                :class="activeTab === 'system' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                class="py-4 font-medium transition-colors"
            >
                <i class="fas fa-server mr-2"></i> Sistema
            </button>
        </div>
    </div>

    <!-- General Settings -->
    <div x-show="activeTab === 'general'" class="space-y-6">
        <div class="card">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Site Name -->
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nome do Site</label>
                        <input 
                            type="text" 
                            id="site_name" 
                            name="site_name" 
                            value="Meu Site"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Site URL -->
                    <div>
                        <label for="site_url" class="block text-sm font-medium text-gray-700 mb-2">URL do Site</label>
                        <input 
                            type="url" 
                            id="site_url" 
                            name="site_url" 
                            value="https://example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Support Email -->
                    <div>
                        <label for="support_email" class="block text-sm font-medium text-gray-700 mb-2">Email de Suporte</label>
                        <input 
                            type="email" 
                            id="support_email" 
                            name="support_email" 
                            value="support@example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="(11) 3000-0000"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição do Site</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >Descrição do seu site aqui</textarea>
                </div>

                <!-- Timezone -->
                <div>
                    <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Fuso Horário</label>
                    <select id="timezone" name="timezone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="America/Sao_Paulo" selected>São Paulo (GMT-3)</option>
                        <option value="America/Rio_Branco">Rio Branco (GMT-5)</option>
                        <option value="America/Manaus">Manaus (GMT-4)</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i> Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Settings -->
    <div x-show="activeTab === 'email'" class="space-y-6">
        <div class="card">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mail Driver -->
                    <div>
                        <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-2">Driver de Email</label>
                        <select id="mail_driver" name="mail_driver" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="smtp">SMTP</option>
                            <option value="mailgun">Mailgun</option>
                            <option value="sendgrid">SendGrid</option>
                        </select>
                    </div>

                    <!-- Mail Host -->
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-2">Host SMTP</label>
                        <input 
                            type="text" 
                            id="mail_host" 
                            name="mail_host" 
                            value="smtp.mailtrap.io"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Mail Port -->
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-2">Porta SMTP</label>
                        <input 
                            type="number" 
                            id="mail_port" 
                            name="mail_port" 
                            value="587"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Mail Username -->
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-2">Usuário SMTP</label>
                        <input 
                            type="text" 
                            id="mail_username" 
                            name="mail_username" 
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Mail Password -->
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-2">Senha SMTP</label>
                        <input 
                            type="password" 
                            id="mail_password" 
                            name="mail_password" 
                            value=""
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>

                    <!-- Mail From -->
                    <div>
                        <label for="mail_from" class="block text-sm font-medium text-gray-700 mb-2">Email de Origem</label>
                        <input 
                            type="email" 
                            id="mail_from" 
                            name="mail_from" 
                            value="noreply@example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i> Salvar Configurações
                    </button>
                    <button type="button" class="btn-secondary">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar Email de Teste
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Settings -->
    <div x-show="activeTab === 'security'" class="space-y-6">
        <div class="card">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Configurações de Segurança</h3>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Two Factor Authentication -->
                <div class="pb-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-900">Autenticação de Dois Fatores</p>
                            <p class="text-sm text-gray-600">Exigir 2FA para todos os administradores</p>
                        </div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="two_factor_enabled" class="w-5 h-5 text-indigo-600">
                        </label>
                    </div>
                </div>

                <!-- IP Whitelist -->
                <div class="pb-6 border-b border-gray-200">
                    <p class="font-medium text-gray-900 mb-3">Whitelist de IPs</p>
                    <textarea 
                        name="ip_whitelist" 
                        rows="4"
                        placeholder="Um IP por linha (ex: 192.168.1.1)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    ></textarea>
                </div>

                <!-- Session Timeout -->
                <div class="pb-6 border-b border-gray-200">
                    <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-2">Tempo de Sessão (minutos)</label>
                    <input 
                        type="number" 
                        id="session_timeout" 
                        name="session_timeout" 
                        value="60"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>

                <!-- Password Policy -->
                <div class="pb-6 border-b border-gray-200">
                    <p class="font-medium text-gray-900 mb-4">Política de Senhas</p>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="password_require_uppercase" class="w-4 h-4 text-indigo-600">
                            <span class="ml-2 text-gray-700">Exigir letras maiúsculas</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="password_require_numbers" class="w-4 h-4 text-indigo-600">
                            <span class="ml-2 text-gray-700">Exigir números</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="password_require_special" class="w-4 h-4 text-indigo-600">
                            <span class="ml-2 text-gray-700">Exigir caracteres especiais</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-6">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i> Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- System Settings -->
    <div x-show="activeTab === 'system'" class="space-y-6">
        <div class="card">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Informações do Sistema</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Versão do Laravel</p>
                    <p class="font-medium text-gray-900">{{ app()->version() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Versão do PHP</p>
                    <p class="font-medium text-gray-900">{{ phpversion() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ambiente</p>
                    <p class="font-medium text-gray-900">{{ config('app.env') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Debug Mode</p>
                    <p class="font-medium text-gray-900">{{ config('app.debug') ? 'Ativado' : 'Desativado' }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="font-bold text-gray-900">Ações do Sistema</h4>
                
                <form action="{{ route('admin.settings.clear-cache') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-broom mr-2"></i> Limpar Cache
                    </button>
                </form>

                <form action="{{ route('admin.settings.optimize') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-cogs mr-2"></i> Otimizar Sistema
                    </button>
                </form>

                <button class="btn-secondary">
                    <i class="fas fa-sync mr-2"></i> Sincronizar Banco de Dados
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function settingsManager() {
        return {
            activeTab: 'general'
        };
    }
</script>
@endpush
@endsection
