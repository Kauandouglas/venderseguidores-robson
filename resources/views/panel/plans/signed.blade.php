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
                        @csrf
                        <div class="row g-3">
                            <div class="col-sm-12 mb-2">
                                <label for="typePayment" class="form-label">Escolha o pagamento</label>
                                <select class="custom-select form-select" name="type_payment" id="typePayment" required>
                                    <option value="pix">Pagar com Pix</option>
                                    <option value="card">Pagar com Cartão</option>
                                </select>
                            </div>
                        </div>

                        <button id="form-checkout__submit" class="w-100 btn btn-success btn-lg">
                            <i data-feather="check" width="20"></i>
                            Finalizar pedido
                        </button>
                    </form>

                    {{-- Data Pix --}}
                    <div class="data-pix d-none mt-4">
                        <div class="row g-3">
                            <div class="col-sm-12 mb-2 text-center">
                                <img width="220px" id="imagePix" src="" alt="QR Code Pix">
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label for="pixPaymentCode" class="control-label text-left">Pix code</label>
                                    <textarea id="pixPaymentCode" readonly class="form-control"></textarea>
                                </div>

                                <button type="button" class="btn btn-primary mt-2" id="pixPaymentCopy">
                                    Copiar código Pix
                                </button>

                                <p class="text-success message-pix color-primary d-none mt-3">
                                    Código copiado com sucesso!
                                </p>
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
        // --- Função para copiar código PIX ---
        $('#pixPaymentCopy').click(function () {
            var pixPaymentCode = $('#pixPaymentCode');
            navigator.clipboard.writeText(pixPaymentCode.val());
            $('.message-pix').removeClass('d-none');

            setTimeout(function () {
                $('.message-pix').addClass('d-none');
            }, 3000);
        });

        let paymentChecker;

        function checkPaymentStatus() {
            $.ajax({
                url: "{{ route('panel.plans.verify', ['plan' => request()->plan]) }}",
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.paid === true) {
                        clearInterval(paymentChecker);

                        Swal.fire({
                            icon: 'success',
                            title: 'Pagamento confirmado!',
                            text: 'Seu plano foi ativado com sucesso 🎉',
                            iconColor: '#25D366',
                            confirmButtonColor: '#25D366'
                        }).then(() => {
                            location.reload(); // atualiza ou redireciona
                        });
                    }
                }
            });
        }

        // --- Envio do formulário de checkout ---
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
                        if (response.type === 'card') {
                            location.href = response.url;
                        } else {
                            // Exibe dados do PIX
                            $('#form-checkout').addClass('d-none');
                            $('.data-pix').removeClass('d-none');

                            $('#imagePix').attr('src', 'data:image/jpeg;base64,' + response.qr_code_base64);
                            $('#pixPaymentCode').val(response.qr_code);

                            // Inicia a checagem automática a cada 10s
                            paymentChecker = setInterval(checkPaymentStatus, 3000);
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
                    }
                });
            });
        });
    </script>
@endpush
