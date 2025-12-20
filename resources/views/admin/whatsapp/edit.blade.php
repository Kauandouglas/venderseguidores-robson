@extends('admin.layouts.app')

@section('title', 'Editar Instância WhatsApp - Painel Administrativo')
@section('page-title', 'Editar Instância WhatsApp')
@section('page-subtitle', 'Atualize as informações da instância')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <form action="{{ route('admin.whatsapp.update', $whatsappInstance) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Número de Telefone -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Número de Telefone</label>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">+55</span>
                    <input 
                        type="text" 
                        id="phone_number" 
                        name="phone_number" 
                        value="{{ old('phone_number', $whatsappInstance->phone_number) }}"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('phone_number') border-red-500 @enderror"
                        required
                    >
                </div>
                @error('phone_number')
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
                        <option value="{{ $user->id }}" {{ old('user_id', $whatsappInstance->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- API Key -->
            <div>
                <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                <input 
                    type="password" 
                    id="api_key" 
                    name="api_key" 
                    value="{{ old('api_key', $whatsappInstance->api_key) }}"
                    placeholder="Deixe em branco para manter a chave atual"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('api_key') border-red-500 @enderror"
                >
                @error('api_key')
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
                    <option value="connected" {{ old('status', $whatsappInstance->status) == 'connected' ? 'selected' : '' }}>Conectado</option>
                    <option value="disconnected" {{ old('status', $whatsappInstance->status) == 'disconnected' ? 'selected' : '' }}>Desconectado</option>
                    <option value="error" {{ old('status', $whatsappInstance->status) == 'error' ? 'selected' : '' }}>Erro</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i> Atualizar Instância
                </button>
                <a href="{{ route('admin.whatsapp.show', $whatsappInstance) }}" class="btn-secondary">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
