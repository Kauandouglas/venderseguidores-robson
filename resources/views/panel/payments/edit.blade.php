@extends('panel.templates.master')
@section('title', 'Configuração Pagamento')
@section('content')
    <a href="https://youtu.be/HdKDpQDj_eg" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="paymentForm" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="paymentMethod">Meios de pagamento</label>
                                                <select name="payment_method_id" id="paymentMethod" class="form-control">
                                                    @foreach($paymentMethods as $paymentMethod)
                                                        <option
                                                            {{ (isset($payment->payment_method_id) && $payment->payment_method_id == $paymentMethod->id ? 'selected' : '') }}
                                                            value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- MERCADO PAGO --}}
                                        <div class="col-12 d-none" id="keyMpContainer">
                                            <div class="form-group">
                                                <label>Selecione as opções de pagamento disponíveis</label>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                               {{ (in_array('pix', $paymentData['option']) ? 'checked' : '') }}
                                                               name="option[]" id="pix" value="pix">
                                                        <label class="custom-control-label" for="pix">PIX</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="public_key">Public Key (*) Obrigatório se for usar cartão</label>
                                                <input type="text" id="public_key" class="form-control"
                                                       name="public_key"
                                                       value="{{ $paymentData['public_key'] ?? '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="access_token">Access Token (*) Obrigatório</label>
                                                <input type="text" id="access_token" class="form-control"
                                                       name="access_token"
                                                       value="{{ $paymentData['access_token'] ?? '' }}">
                                                <a target="_blank" href="https://youtu.be/4mQvJQr_VuE"
                                                   class="text-primary text-lowercase domain-person-text">
                                                    Como pegar meus Tokens?
                                                </a>
                                            </div>
                                        </div>

                                        {{-- OUTRO MÉTODO (ex: PushInPay) --}}
                                        <div class="col-12 d-none" id="keyOtherContainer">
                                            <div class="form-group">
                                                <label>Selecione as opções de pagamento disponíveis</label>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input"
                                                               {{ (in_array('pix', $paymentData['option']) ? 'checked' : '') }}
                                                               name="option[]" id="pix2" value="pix">
                                                        <label class="custom-control-label" for="pix2">PIX</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="bearer_token">Bearer Token (*) Obrigatório</label>
                                                <input type="text" id="bearer_token" class="form-control"
                                                       name="bearer_token"
                                                       value="{{ $paymentData['bearer_token'] ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Editar</button>
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
@endsection

@push('scripts')
    <script>
        // Envio AJAX
        jQuery(document).ready(function () {
            jQuery('#paymentForm').submit(function () {
                var data = jQuery(this).serialize();

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.payments.update') }}",
                    data: data,
                    responseType: 'json',
                    beforeSend: function () {
                        displayLoading('show');
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: response,
                            icon: 'success',
                            confirmButtonText: 'Confirmar',
                        });
                    },
                    error: function (response) {
                        var message = '';
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });

                        Swal.fire({
                            title: 'Erro!',
                            html: message,
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        });
                    },
                    complete: function () {
                        displayLoading('hide');
                    }
                });

                return false;
            });

            // Alternar campos
            $('#paymentMethod').change(function () {
                verifyPaymentMethod($(this).val());
            });

            function verifyPaymentMethod(value) {
                if (value == 1) {
                    $('#keyMpContainer').removeClass('d-none');
                    $('#keyOtherContainer').addClass('d-none');
                } else {
                    $('#keyMpContainer').addClass('d-none');
                    $('#keyOtherContainer').removeClass('d-none');
                }
            }

            // Executa ao carregar
            verifyPaymentMethod($('#paymentMethod').val());
        });
    </script>
@endpush
