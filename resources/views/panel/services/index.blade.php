@extends('panel.templates.master')
@section('title', 'Serviços')
@section('content')
    <div class="d-flex gap-2 mb-3 flex-wrap">
        <a href="{{ route('panel.services.create') }}" class="btn btn-primary">
            <i class="mb-1" data-feather="plus" width="20"></i> Cadastrar serviço
        </a>
        <a href="https://youtu.be/wnnNAX90lXs" target="_blank" class="btn btn-danger">
            <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
        </a>
        <button type="button" class="btn btn-success" id="copyDataBtnServices" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border: none;color: white;font-weight: bold;">
            <i class="mb-1" data-feather="copy" width="20"></i> Copiar Categorias e Serviços
        </button>
    </div>
    <section class="section">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @foreach($categories as $category)
            <div class="card">
                <div class="card-body overflow-auto">
                    <h4>{{ $category->name }}</h4>
                    <table class='table table-striped mt-3' id="table1">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Provedor</th>
                            <th>Nome</th>
                            <th>Provider ID</th>
                            <th>Venda</th>
                            <th>Custo</th>
                            <th>Quantidade</th>
                            <th>Preço Dinâmico</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody class="services">
                        @foreach($category->services as $service)
                            <tr class="ui-state-default" id="services_{{ $service->id }}">
                                <td>
                                    <div class="arrow-container">
                                        <svg class="move-up" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path d="M10 4l6 6H4z"/>
                                        </svg>
                                        <svg class="move-down" width="14" height="14" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path d="M10 16l-6-6h12z"/>
                                        </svg>
                                    </div>
                                </td>
                                <td>Provedor #{{ $service->apiProvider->id }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->api_service }}</td>
                                <td>R$ {{ $service->convert_price }}</td>
                                <td>R$ {{ ($service->api_rate / 1000) * $service->quantity }}</td>
                                <td>{{ $service->quantity }}</td>
                                <td>{{ ($service->dynamic_pricing ? 'Sim' : 'Não') }}</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input {{ ($service->status == 1 ? 'checked' : '') }} type="checkbox"
                                               class="custom-control-input statusChange"
                                               data-action="{{ route('panel.services.status', ['service' => $service]) }}"
                                               id="status_{{ $service->id }}">
                                        <label class="custom-control-label" for="status_{{ $service->id }}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('panel.services.edit', ['service' => $service]) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i data-feather="edit" width="20"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary btn-sm clone-service"
                                                data-service-id="{{ $service->id }}">
                                            <i data-feather="copy" width="20"></i>
                                        </button>
                                        <a href="" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                           data-target="#deleteModal"
                                           data-delete="{{ route('panel.services.destroy', ['service' => $service]) }}">
                                            <i data-feather="trash-2" width="20"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Modal Clone -->
    <div class="modal fade" id="cloneModal" tabindex="-1" aria-labelledby="cloneModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="cloneModalLabel">Duplicar serviço</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cloneForm">
                        @csrf
                        <input type="hidden" id="clone_service_id">
                        <div class="form-group">
                            <label for="target_category_id">Selecione a categoria de destino</label>
                            <select id="target_category_id" class="form-control" name="target_category_id">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="confirmClone">Duplicar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Remover serviço</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Você realmente deseja remover essa serviço?
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var action = button.data('delete')
                var modal = $(this)

                modal.find('form').attr('action', action)
            })

            $('.statusChange').change(function () {
                var serviceStatus = $(this);

                $.post(serviceStatus.data('action'), function (response) {

                }, 'json');
            });

            function moveRowUp(row) {
                var prev = row.prev();
                if (prev.length) {
                    row.insertBefore(prev);
                }
            }

            function moveRowDown(row) {
                var next = row.next();
                if (next.length) {
                    row.insertAfter(next);
                }
            }

            function updateOrder($list) {
                // Usa a lista que disparou o evento; se não vier, usa a primeira
                var $target = $list && $list.length ? $list : $('.services').first();
                var services = $target.sortable("serialize");

                if (!services) {
                    return; // nada para enviar
                }

                displayLoading('show');

                // Inclui o token CSRF manualmente
                services += '&_token=' + $('meta[name="csrf-token"]').attr('content');

                $.post("{{ route('panel.services.order') }}", services, function () {
                    displayLoading('hide');
                });
            }

            $('.services').sortable({
                handle: '.arrow-container',
                axis: 'y',
                update: function () {
                    updateOrder($(this));
                }
            });

            $('.move-up').on('click', function () {
                var row = $(this).closest('tr');
                moveRowUp(row);
                updateOrder(row.closest('.services'));
            });

            $('.move-down').on('click', function () {
                var row = $(this).closest('tr');
                moveRowDown(row);
                updateOrder(row.closest('.services'));
            });

            // Clone service
            $('.clone-service').on('click', function () {
                var serviceId = $(this).data('service-id');
                $('#clone_service_id').val(serviceId);
                $('#cloneModal').modal('show');
            });

            $('#confirmClone').on('click', function () {
                var serviceId = $('#clone_service_id').val();
                var targetCategory = $('#target_category_id').val();

                displayLoading('show');

                $.post("{{ url('painel/servicos') }}/" + serviceId + "/clonar", {
                    target_category_id: targetCategory,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function (response) {
                    $('#cloneModal').modal('hide');
                    displayLoading('hide');
                    Swal.fire({
                        title: 'Sucesso!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then(function () {
                        window.location.reload();
                    });
                }).fail(function (xhr) {
                    displayLoading('hide');
                    var message = 'Erro ao duplicar serviço.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: 'Erro',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'Fechar'
                    });
                });
            });

            // Copiar Categorias e Serviços
            $('#copyDataBtnServices').on('click', function() {
                Swal.fire({
                    title: 'Copiar Categorias e Serviços',
                    text: 'Isso irá copiar todas as categorias e serviços do template padrão para sua conta. Deseja continuar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, copiar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        displayLoading('show');
                        $.post("{{ route('panel.copyData.copyFromTemplate') }}", {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }, function(response) {
                            displayLoading('hide');
                            Swal.fire({
                                title: 'Sucesso!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(function() {
                                window.location.reload();
                            });
                        }).fail(function(xhr) {
                            displayLoading('hide');
                            var message = 'Erro ao copiar dados.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                title: 'Erro',
                                text: message,
                                icon: 'error',
                                confirmButtonText: 'Fechar'
                            });
                        });
                    }
                });
            });
        });
    </script>
@endpush







