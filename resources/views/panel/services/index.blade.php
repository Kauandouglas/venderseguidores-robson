@extends('panel.templates.master')
@section('title', 'Serviços')
@section('content')
    <a href="{{ route('panel.services.create') }}" class="btn btn-primary mb-3">
        <i class="mb-1" data-feather="plus" width="20"></i> Cadastrar serviço
    </a>
    <a href="https://youtu.be/wnnNAX90lXs" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
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
                        <tbody>
                        @foreach($category->services as $service)
                            <tr>
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
        });
    </script>
@endpush

