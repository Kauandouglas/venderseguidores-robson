@extends('admin.layouts.app')

@section('title', 'Detalhes da Instância WhatsApp - Painel Administrativo')
@section('page-title', $whatsappInstance->phone_number)
@section('page-subtitle', 'Visualize os detalhes da instância')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <form action="{{ route('admin.whatsapp.destroy', $whatsappInstance) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar esta instância?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash mr-2"></i> Deletar
                </button>
            </form>
            <a href="{{ route('admin.whatsapp.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Main Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Instance Details -->
        <div class="md:col-span-2 card space-y-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações da Instância</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Número:</dt>
                        <dd class="font-medium text-gray-900">
                            <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                            +55 {{ $whatsappInstance->phone_number }}
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Usuário:</dt>
                        <dd class="font-medium text-gray-900">
                            <a href="{{ route('admin.users.show', $whatsappInstance->user) }}" class="text-indigo-600 hover:underline">
                                {{ $whatsappInstance->user->name ?? 'N/A' }}
                            </a>
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Email:</dt>
                        <dd class="font-medium text-gray-900">{{ $whatsappInstance->user->email ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Status:</dt>
                        <dd>
                            @if($whatsappInstance->status == 'connected')
                                <span class="badge-success">
                                    <i class="fas fa-circle text-xs mr-1"></i> Conectado
                                </span>
                            @elseif($whatsappInstance->status == 'disconnected')
                                <span class="badge-warning">
                                    <i class="fas fa-circle text-xs mr-1"></i> Desconectado
                                </span>
                            @else
                                <span class="badge-danger">
                                    <i class="fas fa-circle text-xs mr-1"></i> Erro
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Criado em:</dt>
                        <dd class="font-medium text-gray-900">{{ $whatsappInstance->created_at }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Status da Conexão</p>
                    @if($whatsappInstance->status == 'connected')
                        <div class="text-3xl font-bold text-green-600 mt-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="text-sm text-green-600 mt-1">Conectado</p>
                    @elseif($whatsappInstance->status == 'disconnected')
                        <div class="text-3xl font-bold text-yellow-600 mt-2">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <p class="text-sm text-yellow-600 mt-1">Desconectado</p>
                    @else
                        <div class="text-3xl font-bold text-red-600 mt-2">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <p class="text-sm text-red-600 mt-1">Erro</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Última Atualização</p>
                    <p class="text-sm font-medium text-gray-900 mt-2">{{ $whatsappInstance->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
