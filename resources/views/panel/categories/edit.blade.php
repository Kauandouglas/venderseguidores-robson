@extends('panel.templates.master')
@section('title', 'Editar Categoria')
@section('content')
    <a href="https://youtu.be/yJd4sx_Rf4o" target="_blank" class="btn btn-danger mb-3">
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
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Desativado</option>
                                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Ativado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{ $category->name }}">
                                            </div>
                                        </div>

                                        <!-- Select de Redes Sociais -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="social_network">Rede Social</label>
                                                <select id="social_network" class="form-control" name="social_network">
                                                    <option value="" disabled {{ !$category->social_network ? 'selected' : '' }}>Selecione a rede social</option>
                                                    @php
                                                        $networks = [
                                                            'facebook', 'instagram', 'twitter', 'linkedin', 'tiktok',
                                                            'youtube', 'pinterest', 'snapchat', 'whatsapp', 'telegram',
                                                            'kwai', 'discord', 'reddit', 'twitch', 'vkontakte', 'weibo',
                                                            'douyin', 'line'
                                                        ];
                                                    @endphp
                                                    @foreach($networks as $network)
                                                        <option value="{{ $network }}" {{ $category->social_network == $network ? 'selected' : '' }}>
                                                            {{ ucfirst($network) }}
                                                        </option>
                                                    @endforeach
                                                </select>
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
    jQuery(document).ready(function () {
        jQuery('#apiProviderForm').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            jQuery.ajax({
                type: "POST",
                url: "{{ route('panel.categories.update', ['category' => $category]) }}",
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    displayLoading('show');
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: response.message || 'Categoria atualizada com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'Confirmar',
                    }).then(function () {
                        window.location.href = "{{ route('panel.categories.index') }}";
                    });
                },
                error: function (response) {
                    var message = '';
                    if(response.responseJSON && response.responseJSON.errors){
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });
                    } else if(response.responseJSON && response.responseJSON.message){
                        message = response.responseJSON.message;
                    } else {
                        message = 'Ocorreu um erro inesperado.';
                    }

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
        });
    });
</script>
@endpush
