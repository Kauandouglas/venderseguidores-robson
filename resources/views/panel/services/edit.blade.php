@extends('panel.templates.master')
@section('title', 'Editar Serviço')
@section('content')
    <a href="https://youtu.be/wnnNAX90lXs" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="serviceForm" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="category">Categorias</label>
                                                <select name="category_id" id="category" class="form-control">
                                                    @foreach($categories as $category)
                                                        <option
                                                            {{ ($category->id == $service->category_id ? 'selected' : '') }}
                                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="apiProvider">Provedores</label>
                                                <select name="api_provider_id" id="apiProvider" class="form-control">
                                                    @foreach($apiProviders as $apiProvider)
                                                        <option
                                                            {{ ($apiProvider->id == $service->api_provider_id ? 'selected' : '') }}
                                                            value="{{ $apiProvider->id }}">Provedor
                                                            #{{ $apiProvider->id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="apiService">Lista de serviços API</label>
                                                <select name="api_service" id="apiService"
                                                        class="form-control"></select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                       value="{{ $service->name }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="quantity">Quantidade</label>
                                                <input type="number" id="quantity" class="form-control" name="quantity"
                                                       value="{{ $service->quantity }}">
                                            </div>
                                            <div class="custom-control custom-switch mt-2 mb-2">
                                                <input name="dynamic_pricing" type="checkbox" value="1" {{ ($service->dynamic_pricing ? 'checked' : '') }}
                                                       class="custom-control-input" id="colorDefault">
                                                <label class="custom-control-label" for="colorDefault">
                                                    Preço dinâmico
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="price" id="priceLabel">Preço</label>
                                                <input type="text" id="price" class="form-control" name="price"
                                                       value="{{ $service->price }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="priceCost">Preço Custo</label>
                                                <input type="text" id="priceCost" name="api_rate" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Descrição</label>
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                          class="form-control">{{ $service->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#price').mask('000.000,00', {reverse: true});

        // Submit form
        jQuery(document).ready(function () {
            jQuery('#serviceForm').submit(function () {
                var data = jQuery(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.services.update', ['service' => $service]) }}",
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
                            window.location.href = "{{ route('panel.services.index') }}";
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

            // Service
            $('#apiService').change(function () {
                apiCostPrice()
            });

            function apiCostPrice() {
                var rate = $('#apiService').find(':selected').attr('data-rate')
                var quantity = $('#quantity').val()

                $('#priceCost').val('R$ ' + (rate / 1000) * quantity)
            }

            $('#quantity').on('keyup blur', function () {
                apiCostPrice()
            });

            // Provider
            $('#apiProvider').change(function () {
                apiProvider();
            });

            function apiProvider() {
                var val = $('#apiProvider').val();
                displayLoading('show');

                $.post('{{ route('panel.services.providerService') }}', {'provider': val}, function (response) {
                    displayLoading('hide');
                    var apiService = $('#apiService');
                    apiService.empty();

                    $.each(response, function (index, value) {
                        if ('{{ $service->api_service  }}' == value.service) {
                            apiService.append('<option selected data-rate="' + value.rate + '" value="' + value.service + '">' + value.service + ' - ' + value.name + '</option>');
                        } else {
                            apiService.append('<option data-rate="' + value.rate + '" value="' + value.service + '">' + value.service + ' - ' + value.name + '</option>');
                        }
                    });

                    $("#apiService").select2();

                    apiCostPrice();
                }, 'json')
            }

            @if($apiProviders != '[]')
            apiProvider();
            @endif
        });

        // Verify type comment
        $('#type').change(function () {
            typeChangeComment();
        })

        function typeChangeComment() {
            var value = $('#type').val();

            if (value == 4) {
                $('#quantity').attr('disabled', true)
                $('#priceLabel').html('Preço por (Cada comentário)')
            } else {
                $('#quantity').attr('disabled', false)
                $('#priceLabel').html('Preço')
            }
        }

        typeChangeComment();

        function typeChangeComment() {
            var type = $('#apiService').find(':selected').attr('data-type')

            if (type == 'Custom Comments') {
                $('#quantity').attr('disabled', true)
                $('#priceLabel').html('Preço por (Cada comentário)')
                $('#type').val(4)
            } else {
                $('#quantity').attr('disabled', false)
                $('#priceLabel').html('Preço')
                $('#type').val(1)
            }
        }
        function toggleDynamicPricing() {
            const isChecked = $('#colorDefault').is(':checked');

            if (isChecked) {
                $('#quantity').closest('.form-group').hide(); // Esconde a quantidade
                $('#priceLabel').text('Preço (A cada 100)');
            } else {
                $('#quantity').closest('.form-group').show(); // Mostra a quantidade
                $('#priceLabel').text('Preço');
            }
        }

        // Chamada inicial
        toggleDynamicPricing();

        // Listener para o switch
        $('#colorDefault').on('change', function () {
            toggleDynamicPricing();
        });
    </script>
@endpush
