@extends('panel.templates.master')
@section('title', 'Adquirir Plano')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row g-5 mb-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Seu plano</span>
                        <span class="badge bg-primary rounded-pill" style="font-size: 13px;color: #fff;">1</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Plano mensal</h6>
                                <small class="text-muted">Assinatura do plano</small>
                            </div>
                            <span class="text-muted">R${{ $plan->price }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (BRL)</span>
                            <strong>R${{ $plan->price }}</strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-7 col-lg-8">
                    {{-- Form Checkout --}}
                    <form class="needs-validation" id="form-checkout" novalidate>
                        <div class="row g-3">
                            <div class="col-sm-12 mb-2">
                                <label for="typePayment" class="form-label">Escolha o pagamento</label>
                                <select class="custom-select" name="type_payment" id="typePayment" required>
                                    <option value="pix">Pagar com Pix</option>
                                </select>
                            </div>
                        </div>

                        <button id="form-checkout__submit" class="w-100 btn btn-success btn-lg">
                            <i data-feather="check" width="20"></i>
                            Finalizar pedido
                        </button>
                    </form>

                    {{-- Data Pix --}}
                    <div class="data-pix d-none">
                        <div class="row g-3">
                            <div class="col-sm-12 mb-2 text-center">
                                <img width="220px" id="imagePix" src="" alt="">
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="pixPaymentCode" class="control-label text-left">Pix code</label>
                                    <textarea id="pixPaymentCode" readonly="" class="form-control"></textarea>
                                </div>

                                <button type="button" class="btn btn-primary" id="pixPaymentCopy">Copiar QRcode</button>
                                <p class="text-success message-pix color-primary d-none mt-3">Codigo copiado com
                                    sucesso!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Copy
        $('#pixPaymentCopy').click(function () {
            var pixPaymentCode = $('#pixPaymentCode');
            pixPaymentCode.select();

            navigator.clipboard.writeText(pixPaymentCode.val());
            $('.message-pix').removeClass('d-none');

            setTimeout(function () {
                $('.message-pix').addClass('d-none');
            }, 3000);
        });

        $(function () {
            $('#form-checkout').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.plans.processSigned', ['plan' => request()->plan]) }}",
                    data: data,
                    dataType: "json",
                    beforeSend: function () {
                        form.find('button').prop('disabled', true);
                    },
                    success: function (response) {
                        if (response.type == 'card') {
                            location.href = response.url;
                        } else {
                            $('#form-checkout').addClass('d-none')
                            $('.data-pix').removeClass('d-none')

                            $('#imagePix').attr('src', 'data:image/jpeg;base64,' + response.qr_code_base64)
                            $('#pixPaymentCode').val(response.qr_code)
                        }
                    },
                    error: function (response) {
                        form.find('.alert').html('');
                        $.each(response.responseJSON.errors, function (index, value) {
                            form.find('.alert').removeClass('d-none').append(value + '<br>');
                        });
                    },
                    complete: function () {
                        form.find('button').prop('disabled', false);
                        location.href = '#';
                    }
                });
            });
        });
    </script>
@endpush
