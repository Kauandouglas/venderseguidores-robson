@extends('panel.templates.master')
@section('title', 'Vincular meu domínio')

@section('content')
<section id="domain-link-section">
    <div class="row match-height">
        <div class="col-md-12 mt-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i data-feather="globe"></i> Vincular meu domínio</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">

                        {{-- Mensagens de erro --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Erro!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                        @endif

                        {{-- Mensagem de sucesso --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                        @endif

                        <form class="form form-vertical" method="POST" action="{{ route('panel.domains.store') }}">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="domain" class="form-label fw-bold">Seu domínio</label>
                                        <input type="text" id="domain" class="form-control form-control-lg"
                                               name="domain" placeholder="ex: seudominio.com.br"
                                               value="{{ $domain->domain ?? '' }}">
                                    </div>

                                    {{-- Nameservers --}}
                                    @if($domain)
                                        <div class="col-12 mb-3">
                                            <div class="alert alert-primary d-flex flex-column gap-2 p-3 position-relative">
                                                <h6 class="mb-1 text-white fw-bold"><i data-feather="server"></i> Configuração de DNS</h6>
                                                <div class="d-flex align-items-center justify-content-between bg-light rounded p-2 mt-2">
                                                    <span id="ns1" class="text-dark fw-semibold">ns1.revendadiretapainel.site</span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary copy-btn" data-target="ns1">
                                                        <i data-feather="copy"></i>
                                                    </button>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between bg-light rounded p-2 mt-2">
                                                    <span id="ns2" class="text-dark fw-semibold">ns2.revendadiretapainel.site</span>
                                                    <button type="button" class="btn btn-sm btn-outline-primary copy-btn" data-target="ns2">
                                                        <i data-feather="copy"></i>
                                                    </button>
                                                </div>
                                                <small class="text-white-50 mt-2">
                                                    Aponte o domínio acima para esses nameservers para concluir a vinculação.
                                                </small>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-lg btn-primary">
                                            <i data-feather="plus-circle"></i> Salvar Domínio
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Script para copiar o texto --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        feather.replace();

        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const text = document.getElementById(targetId).innerText;

                navigator.clipboard.writeText(text).then(() => {
                    const original = button.innerHTML;
                    button.innerHTML = '<i data-feather="check"></i>';
                    feather.replace();
                    button.classList.remove('btn-outline-primary');
                    button.classList.add('btn-success');

                    setTimeout(() => {
                        button.innerHTML = original;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-outline-primary');
                        feather.replace();
                    }, 1500);
                });
            });
        });
    });
</script>
@endsection
