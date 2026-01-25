@extends('panel.templates.master')
@section('title', 'Editar Template de Email')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-8 col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $typeLabel }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="emailTemplateForm" action="{{ route('panel.emailTemplates.update', ['emailTemplate' => $template->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="subject">Assunto do Email</label>
                                                <input type="text" id="subject" class="form-control" name="subject" value="{{ $template->subject }}" required>
                                                <small class="form-text text-muted">Use as variáveis abaixo para personalizar</small>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="body">Corpo do Email</label>
                                                <textarea id="body" class="form-control" name="body" rows="15" required style="font-family: monospace;">{{ $template->body }}</textarea>
                                                <small class="form-text text-muted">Use as variáveis abaixo para personalizar o conteúdo</small>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ $template->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_active">
                                                        Ativar este email
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end gap-2">
                                            <a href="{{ route('panel.emailTemplates.index') }}" class="btn btn-secondary me-1 mb-1">Voltar</a>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Salvar Template</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Variáveis Disponíveis</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                            <p class="text-muted small mb-3">Clique em uma variável para copiar</p>
                            @forelse($availableVariables as $key => $description)
                                <div class="variable-item mb-2 p-2 bg-light rounded cursor-pointer" data-variable="{{ $key }}">
                                    <code class="text-primary" id="var-{{ $key }}"></code>
                                    <br>
                                    <small class="text-muted">{{ $description }}</small>
                                </div>
                            @empty
                                <p class="text-muted">Nenhuma variável disponível</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .variable-item {
            cursor: pointer;
            transition: all 0.2s;
        }

        .variable-item:hover {
            background-color: #e3f2fd !important;
            border-left: 3px solid #1976d2;
            padding-left: calc(0.5rem - 3px) !important;
        }
        }
    </style>

    @push('scripts')
        <script>
            // Preencher nomes das variáveis
            document.querySelectorAll('.variable-item').forEach(function(el) {
                const varName = el.getAttribute('data-variable');
                const codeEl = el.querySelector('code');
                codeEl.textContent = `{{ ${varName} }}`;
            });

            // Event delegation para variáveis
            $(document).on('click', '.variable-item', function() {
                const variable = $(this).data('variable');
                copyVariable(variable);
            });

            function copyVariable(variable) {
                const text = `{{ ${variable} }}`;

                // Copiar para clipboard
                navigator.clipboard.writeText(text).then(() => {
                    // Insere no textarea se estiver focado
                    const $body = $('#body');
                    if (document.activeElement === $body[0]) {
                        const start = $body[0].selectionStart;
                        const end = $body[0].selectionEnd;
                        const before = $body.val().substring(0, start);
                        const after = $body.val().substring(end);
                        $body.val(before + text + after);
                    }

                    Swal.fire({
                        title: 'Copiado!',
                        text: `Variável copiada: ${text}`,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            }

            // Form submission
            $('#emailTemplateForm').submit(function(e) {
                e.preventDefault();

                const data = {
                    subject: $('#subject').val(),
                    body: $('#body').val(),
                    is_active: $('#is_active').is(':checked') ? 1 : 0,
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: response,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('panel.emailTemplates.index') }}";
                        });
                    },
                    error: function(response) {
                        let message = 'Erro ao salvar';
                        if (response.responseJSON && response.responseJSON.errors) {
                            message = Object.values(response.responseJSON.errors).join('<br>');
                        }

                        Swal.fire({
                            title: 'Erro!',
                            html: message,
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                    }
                });

                return false;
            });
        </script>
    @endpush
@endsection
