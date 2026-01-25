@extends('panel.templates.master')
@section('title', 'Templates de Email')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Configurar Emails Automáticos</h4>
                        <p class="text-muted mt-2">Customize os títulos e corpo de cada email automaticamente enviado aos seus clientes. Você pode ativar/desativar cada email individualmente.</p>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipo de Email</th>
                                            <th>Assunto</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($templates as $template)
                                            <tr>
                                                <td>
                                                    <strong>
                                                        @switch($template->type)
                                                            @case('purchase')
                                                                📦 Cliente Comprou
                                                                @break
                                                            @case('pix_generated')
                                                                💳 PIX Gerado
                                                                @break
                                                            @case('payment_reminder')
                                                                ⏰ Lembrete de Pagamento
                                                                @break
                                                            @case('order_completed')
                                                                ✅ Pedido Concluído
                                                                @break
                                                        @endswitch
                                                    </strong>
                                                </td>
                                                <td>{{ $template->subject }}</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox"
                                                               class="custom-control-input toggle-email-active"
                                                               id="switch-{{ $template->id }}"
                                                               data-id="{{ $template->id }}"
                                                               {{ $template->is_active ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="switch-{{ $template->id }}">
                                                            {{ $template->is_active ? 'Ativo' : 'Inativo' }}
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('panel.emailTemplates.edit', $template) }}" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    Nenhum template de email encontrado
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table td {
            vertical-align: middle;
        }
    </style>

    @push('scripts')
        <script>
            $('.toggle-email-active').on('change', function() {
                const templateId = $(this).data('id');
                const $switch = $(this);
                const $label = $switch.next('label');

                $.post("{{ route('panel.emailTemplates.toggleActive', ':id') }}".replace(':id', templateId), {
                    '_token': "{{ csrf_token() }}"
                }, function(response) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: response.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Update label
                    $label.text(response.is_active ? 'Ativo' : 'Inativo');
                }).fail(function() {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao atualizar status',
                        icon: 'error'
                    });
                    $switch.prop('checked', !$switch.is(':checked'));
                });
            });
        </script>
    @endpush
@endsection
