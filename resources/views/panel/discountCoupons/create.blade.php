@extends('panel.templates.master')
@section('title', 'Cadastrar Cupom')
@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="formDescount">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="cupom">Cupom</label>
                                                <input type="text" id="cupom" class="form-control" name="cupom">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="discount_type">Tipo de Desconto</label>
                                                <select id="discount_type" class="form-control" name="discount_type">
                                                    <option value="percent">Porcentagem (%)</option>
                                                    <option value="fixed">Valor Fixo (R$)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12" id="percent_field">
                                            <div class="form-group">
                                                <label for="percent">Porcentagem desconto %</label>
                                                <input type="text" id="percent" class="form-control" name="percent">
                                            </div>
                                        </div>
                                        <div class="col-12" id="fixed_field" style="display: none;">
                                            <div class="form-group">
                                                <label for="fixed_value">Valor do desconto R$</label>
                                                <input type="text" id="fixed_value" class="form-control" name="fixed_value">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Cadastrar</button>
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
        jQuery(document).ready(function () {
            // Aplicando máscaras
            jQuery('#percent').mask('##0,00', {
                reverse: true
            });

            jQuery('#fixed_value').mask('#.##0,00', {
                reverse: true
            });
            // Toggle between percent and fixed value fields
            jQuery('#discount_type').change(function() {
                if (this.value === 'percent') {
                    jQuery('#percent_field').show();
                    jQuery('#fixed_field').hide();
                    jQuery('#fixed_value').val('');
                } else {
                    jQuery('#percent_field').hide();
                    jQuery('#fixed_field').show();
                    jQuery('#percent').val('');
                }
            });

            // Submit form
            jQuery('#formDescount').submit(function () {
                // Removendo máscara antes de enviar
                var percentValue = jQuery('#percent').val();
                var fixedValue = jQuery('#fixed_value').val();

                if (percentValue) {
                    jQuery('#percent').val(percentValue.replace(/\./g, '').replace(',', '.'));
                }
                if (fixedValue) {
                    jQuery('#fixed_value').val(fixedValue.replace(/\./g, '').replace(',', '.'));
                }
                var data = jQuery(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.discountCoupons.store') }}",
                    data: data,
                    responseType: 'json',
                    beforeSend: function (response) {
                        displayLoading('show');
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: response,
                            icon: 'success',
                            confirmButtonText: 'Confirmar',
                        }).then(function () {
                            window.location.href = "{{ route('panel.discountCoupons.index') }}";
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
                        })
                    },
                    complete: function (response) {
                        displayLoading('hide');
                    }
                });

                return false;
            });
        });
    </script>
@endpush
