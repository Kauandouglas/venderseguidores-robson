@extends('admin.layouts.app')

@section('title', 'Detalhes do Domínio - Painel Administrativo')
@section('page-title', $domain->domain)
@section('page-subtitle', 'Visualize os detalhes do domínio')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Domínio registrado em {{ $domain->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.domains.edit', $domain) }}" class="btn-primary">
                <i class="fas fa-edit mr-2"></i> Editar
            </a>
            <form action="{{ route('admin.domains.destroy', $domain) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar este domínio?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash mr-2"></i> Deletar
                </button>
            </form>
            <a href="{{ route('admin.domains.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Main Info -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Domain Details -->
        <div class="md:col-span-2 card space-y-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informações do Domínio</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Domínio:</dt>
                        <dd class="font-medium text-gray-900">
                            <a href="https://{{ $domain->domain }}" target="_blank" class="text-indigo-600 hover:underline">
                                {{ $domain->domain }}
                            </a>
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Usuário:</dt>
                        <dd class="font-medium text-gray-900">
                            <a href="{{ route('admin.users.show', $domain->user) }}" class="text-indigo-600 hover:underline">
                                {{ $domain->user->name ?? 'N/A' }}
                            </a>
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Email:</dt>
                        <dd class="font-medium text-gray-900">{{ $domain->user->email ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Status:</dt>
                        <dd>
                            @if($domain->status == 'active')
                                <span class="badge-success">Ativo</span>
                            @elseif($domain->status == 'inactive')
                                <span class="badge-warning">Inativo</span>
                            @else
                                <span class="badge-danger">Expirado</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between border-t pt-4">
                        <dt class="text-gray-600">Expira em:</dt>
                        <dd class="font-medium text-gray-900">
                            @if($domain->expires_at)
                                {{ $domain->expires_at->format('d/m/Y') }}
                                @if($domain->expires_at->isPast())
                                    <span class="text-red-600 text-sm">(Expirado)</span>
                                @elseif($domain->expires_at->diffInDays() < 30)
                                    <span class="text-yellow-600 text-sm">(Expira em {{ $domain->expires_at->diffInDays() }} dias)</span>
                                @endif
                            @else
                                N/A
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Stats -->
        <div class="space-y-4">
            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Registrado em</p>
                    <p class="text-sm font-medium text-gray-900">{{ $domain->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="text-center">
                    <p class="text-gray-600 text-sm">Dias até expiração</p>
                    @if($domain->expires_at)
                        <p class="text-2xl font-bold {{ $domain->expires_at->isPast() ? 'text-red-600' : 'text-indigo-600' }}">
                            {{ $domain->expires_at->isPast() ? '-' : '' }}{{ abs($domain->expires_at->diffInDays()) }}
                        </p>
                    @else
                        <p class="text-2xl font-bold text-gray-600">-</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
