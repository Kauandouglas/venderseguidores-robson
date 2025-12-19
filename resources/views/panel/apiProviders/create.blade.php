@extends('panel.templates.master')
@section('title', 'Cadastrar Provedor')
@section('content')
    <a href="https://www.youtube.com/watch?v=cwGyLmVn8Mk" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="apiProviderForm">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="url">URL</label>
                                                <input type="url" id="url" class="form-control" name="url">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="key">API Key</label>
                                                <input type="text" id="key" class="form-control" name="key">
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
        // Submit form
        jQuery(document).ready(function () {
            jQuery('#apiProviderForm').submit(function () {
                var data = jQuery(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.apiProviders.store') }}",
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
                        })
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
