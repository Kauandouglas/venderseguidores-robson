@extends('panel.templates.master')
@section('title', 'Vendas')
@section('content')
    <section class="section">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body overflow-auto">
                <div class="custom-control custom-switch mb-3">
                    <form style="float: right; display: flex;">
                        <input class="form-control" type="search" name="search" placeholder="Pesquisar"
                               value="{{ request()->search }}">
                        <select class="form-control" name="status">
                            <option value="">Todos</option>
                            <option value="pending">Pendente</option>
                            <option value="approved">Enviado</option>
                            <option value="canceled">Error</option>
                        </select>
                        <button class="btn-primary"><i data-feather="search" width="20"></i></button>
                        <br>
                    </form>
                </div>

                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th>ID Venda</th>
                        <th>ID Forn.</th>
                        <th>ID MP.</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                        <th>Link</th>
                        <th>Serviço</th>
                        <th>Quantidade</th>
                        <th>Custo</th>
                        <th>Venda</th>
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchases as $purchase)
                        @if(isset($purchase->service))
                            <tr>
                                <td>{{ $purchase->id }}<br>
                                    <span style="color: #a9b7c4;">{{ $purchase->order_id }}</span>
                                </td>
                                <td>{{ $purchase->order_id }}</td>
                                <td>{{ $purchase->payment_id }}</td>
                                <td>{{ $purchase->name }}</td>
                                <td>{{ $purchase->email }}</td>
                                <td>
                                    <a target="_blank"
                                       href="https://api.whatsapp.com/send?phone=55{{ preg_replace("/[^0-9]/", "", $purchase->whatsapp) }}">
                                        {{ $purchase->whatsapp }}
                                    </a>
                                </td>
                                <td>{{ ($purchase->service->type == 2 || $purchase->service->type == 4 ? 'https://instagram.com/p/' . $purchase->instagram : $purchase->instagram) }}</td>
                                <td>{{ $purchase->service->name }}</td>
                                <td>{{ $purchase->service->quantity }}</td>
                                <td>R$ {{ $purchase->convert_charge }}<br>
                                <td>
                                    R$ {{ $purchase->price }}
                                    @if($purchase->descount > 0)
                                        <b class="text-success">{{ $purchase->descount }}%</b>
                                    @endif
                                </td>
                                <td>{{ $purchase->convert_date }}</td>
                                <td>
                                    @if($purchase->status == 'pending')
                                        <span class="badge badge-warning">{{ $purchase->status_string }}</span>
                                    @elseif($purchase->status == 'approved')
                                        <span class="badge badge-success">{{ $purchase->status_string }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $purchase->status_string }}</span><br>
                                        <a href="" data-toggle="modal" data-target="#errorModal"
                                           data-error="{{ $purchase->error }}"
                                           data-action="{{ route('panel.purchases.sendOrder', ['purchase' => $purchase]) }}"
                                           class="mt-1 detais-order-cancel text-secondary">Ver Detalhes</a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                {{ $purchases->withQueryString()->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Resposta API</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre></pre>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Reenviar
                            <i data-feather="send" width="20"></i></button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#errorModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var error = button.data('error')
                var action = button.data('action')
                var modal = $(this)

                modal.find('.modal-body pre').html(JSON.stringify(error, null, 2))
                modal.find('form').attr('action', action)
            })

            $('#errorModal form').submit(function () {
                $(this).find('button').attr('disabled', true)
            })
        });
    </script>
@endpush
