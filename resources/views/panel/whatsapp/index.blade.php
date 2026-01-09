@extends('panel.templates.master')
@section('title', 'Conexão do Whatsapp')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                {{-- Mensagens de Erro e Sucesso --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <h5><i class="fas fa-exclamation-triangle mr-2"></i>Atenção!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <h5><i class="fas fa-check-circle mr-2"></i>Sucesso!</h5>
                    <p class="mb-0">{{ session('success') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <h5><i class="fas fa-times-circle mr-2"></i>Erro!</h5>
                    <p class="mb-0">{{ session('error') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <h5><i class="fas fa-exclamation-circle mr-2"></i>Aviso!</h5>
                    <p class="mb-0">{{ session('warning') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <h5><i class="fas fa-info-circle mr-2"></i>Informação!</h5>
                    <p class="mb-0">{{ session('info') }}</p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            
                @if (!isset($instance) || $instance->status === 'error')
                    {{-- Card de Ativação --}}
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow-lg border-0">
                                <div class="card-body text-center py-5">
                                    
                                    <h3 class="mb-3">WhatsApp não está ativo</h3>
                                    <p class="text-muted mb-4">Ative sua instância gratuita do WhatsApp para começar a enviar mensagens e PIX automaticamente.</p>
                                    
                                    <div class="row justify-content-center mb-4">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <i class="fas fa-bolt text-warning fa-2x mb-2"></i>
                                                        <h6>Rápido</h6>
                                                        <small class="text-muted">Ativação instantânea</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                                                        <h6>Seguro</h6>
                                                        <small class="text-muted">Conexão criptografada</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <div class="p-3 bg-light rounded">
                                                        <i class="fas fa-gift text-success fa-2x mb-2"></i>
                                                        <h6>Gratuito</h6>
                                                        <small class="text-muted">Sem custos adicionais</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('panel.whatsapp.activate') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; border: none; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);">
                                            <i class="fas fa-rocket mr-2"></i> Ativar WhatsApp Agora
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        {{-- Card de Status --}}
                        <div class="col-md-4">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="text-white mb-0">
                                        <i class="fas fa-info-circle mr-2"></i>Informações da Instância
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <label class="text-muted small mb-1">Nome da Instância</label>
                                        <div class="p-2 bg-light rounded">
                                            <code style="font-size: 14px;">{{ $instance->instance_name }}</code>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Status da Conexão</label>
                                        <div class="text-center">
                                            @if ($instance->status === 'connected')
                                                <div class="mb-3">
                                                    <i class="fas fa-check-circle" style="font-size: 48px; color: #28a745;"></i>
                                                </div>
                                                <span class="badge badge-success badge-lg px-4 py-2" style="font-size: 14px;">
                                                    <i class="fas fa-check mr-1"></i> CONECTADO
                                                </span>
                                            @elseif ($instance->status === 'connecting')
                                                <div class="mb-3">
                                                    <i class="fas fa-spinner fa-spin" style="font-size: 48px; color: #ffc107;"></i>
                                                </div>
                                                <span class="badge badge-warning badge-lg px-4 py-2" style="font-size: 14px;">
                                                    <i class="fas fa-clock mr-1"></i> CONECTANDO
                                                </span>
                                            @elseif ($instance->status === 'disconnected')
                                                <div class="mb-3">
                                                    <i class="fas fa-times-circle" style="font-size: 48px; color: #dc3545;"></i>
                                                </div>
                                                <span class="badge badge-danger badge-lg px-4 py-2" style="font-size: 14px;">
                                                    <i class="fas fa-unlink mr-1"></i> DESCONECTADO
                                                </span>
                                            @else
                                                <div class="mb-3">
                                                    <i class="fas fa-question-circle" style="font-size: 48px; color: #6c757d;"></i>
                                                </div>
                                                <span class="badge badge-secondary badge-lg px-4 py-2" style="font-size: 14px;">
                                                    {{ strtoupper($instance->status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($instance->status === 'connected')
                                        <div class="alert alert-success border-0" style="background-color: #d4edda;">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <strong>Tudo pronto!</strong><br>
                                            <small>Seu WhatsApp está conectado e operacional.</small>
                                        </div>
                                        
                                        <form action="{{ route('panel.whatsapp.disconnect') }}" method="POST" class="mt-3">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-block py-2" onclick="return confirm('Deseja realmente desconectar o WhatsApp?')">
                                                <i class="fas fa-power-off mr-2"></i> Desconectar WhatsApp
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Card de QR Code / Conexão --}}
                        <div class="col-md-8">
                            <div class="card shadow border-0 h-100">
                                <div class="card-header border-0" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);">
                                    <h5 class="text-white mb-0">
                                        <i class="fab fa-whatsapp mr-2"></i>Conexão WhatsApp
                                    </h5>
                                </div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    @if ($instance->status === 'connecting' && $instance->qr_code)
                                        <div class="text-center">
                                            <h4 class="mb-3">
                                                <i class="fas fa-qrcode mr-2 text-primary"></i>Escaneie o QR Code
                                            </h4>
                                            <p class="text-muted mb-4">Abra o WhatsApp no seu celular e escaneie o código abaixo</p>
                                            
                                            <div class="qr-code-container mb-4" style="display: inline-block; padding: 20px; background: white; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                                                <img src="{{ $instance->qr_code }}" alt="QR Code WhatsApp" style="width: 280px; height: 280px; display: block;">
                                            </div>

                                            <div class="alert alert-info border-0 mb-4" style="background-color: #1eba6e;">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                <strong>Como conectar:</strong>
                                                <ol class="text-left mb-0 mt-2 pl-4" style="font-size: 13px;">
                                                    <li>Abra o WhatsApp no seu celular</li>
                                                    <li>Toque em <strong>Configurações</strong> ou <strong>Menu (⋮)</strong></li>
                                                    <li>Selecione <strong>Aparelhos conectados</strong></li>
                                                    <li>Toque em <strong>Conectar um aparelho</strong></li>
                                                    <li>Aponte a câmera para este código</li>
                                                </ol>
                                            </div>

                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('panel.whatsapp.index') }}" class="btn btn-primary px-4">
                                                    <i class="fas fa-sync-alt mr-2"></i> Atualizar Status
                                                </a>
                                            </div>

                                            <p class="text-muted mt-3 small">
                                                <i class="fas fa-clock mr-1"></i> A página será atualizada automaticamente em <span id="countdown">30</span> segundos
                                            </p>
                                        </div>
                                    @elseif ($instance->status === 'disconnected')
                                        <div class="text-center py-5">
                                            <i class="fas fa-unlink mb-4" style="font-size: 64px; color: #dc3545;"></i>
                                            <h4 class="mb-3">WhatsApp Desconectado</h4>
                                            <p class="text-muted mb-4">Clique no botão abaixo para gerar um novo QR Code e conectar seu WhatsApp</p>
                                            
                                            <a href="{{ route('panel.whatsapp.index') }}" class="btn btn-lg px-5" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white; border: none; border-radius: 50px;">
                                                <i class="fas fa-qrcode mr-2"></i> Gerar QR Code
                                            </a>
                                        </div>
                                    @elseif ($instance->status === 'connected')
                                        <div class="text-center py-5">
                                            <i class="fab fa-whatsapp mb-4" style="font-size: 80px; color: #25D366;"></i>
                                            <h3 class="mb-3">WhatsApp Conectado com Sucesso!</h3>
                                            <p class="text-muted mb-4">Sua instância está ativa e pronta para enviar mensagens e PIX</p>
                                            
                                            <div class="row justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <div class="p-3 border rounded">
                                                                <i class="fas fa-paper-plane text-primary fa-2x mb-2"></i>
                                                                <h6 class="mb-1">Mensagens</h6>
                                                                <small class="text-muted">Envio automático ativo</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <div class="p-3 border rounded">
                                                                <i class="fas fa-dollar-sign text-success fa-2x mb-2"></i>
                                                                <h6 class="mb-1">PIX</h6>
                                                                <small class="text-muted">Pagamentos habilitados</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('styles')
<style>
    .content-wrapper {
        background: #f4f6f9;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .alert h5 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .alert ul {
        padding-left: 20px;
    }

    .alert-dismissible .close {
        padding: 0.5rem 1rem;
    }

    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
    }

    .badge-lg {
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 25px;
    }

    .qr-code-container {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        50% {
            box-shadow: 0 8px 35px rgba(37, 211, 102, 0.3);
        }
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .small-box {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        const status = '{{ $instance->status ?? '' }}';
        
        if (status === 'connecting') {
            // Countdown timer
            let seconds = 30;
            const countdownElement = $('#countdown');
            
            const countdownInterval = setInterval(function() {
                seconds--;
                countdownElement.text(seconds);
                
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    window.location.reload();
                }
            }, 1000);

            // Auto reload após 30 segundos
            setTimeout(function() {
                window.location.reload();
            }, 30000);
        }
    });
</script>
@endpush