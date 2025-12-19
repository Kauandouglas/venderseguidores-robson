@extends('panel.templates.master')
@section('title', 'Cupom de desconto')
@section('content')
    <a href="{{ route('panel.discountCoupons.create') }}" class="btn btn-primary mb-3">
        <i class="mb-1" data-feather="plus" width="20"></i> Cadastrar Cupom de desconto
    </a>
    <section class="section">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body overflow-auto">
                <table class='table table-striped' id="table1">
                    <thead>
                    <tr>
                        <th>Cupom</th>
                        <th>Quantidade Usada</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discountCoupons as $discountCoupon)
                        <tr>
                            <td>{{ $discountCoupon->cupom }}</td>
                            <td>0</td>
                            <td>
                                <div class="btn-group">
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                       data-target="#deleteModal"
                                       data-delete="{{ route('panel.discountCoupons.destroy', ['discountCoupon' => $discountCoupon]) }}">
                                        <i data-feather="trash-2" width="20"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{ $discountCoupons->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Remover categoria</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Você realmente deseja remover essa cupom?
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
        })
    </script>
@endpush
