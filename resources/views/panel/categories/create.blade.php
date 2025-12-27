@extends('panel.templates.master')
@section('title', 'Cadastrar Categoria')
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
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text" id="name" class="form-control" name="name">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="social_network">Rede Social</label>
                                                <select id="social_network" class="form-control" name="social_network">
                                                    <option value="" disabled selected>Selecione a rede social</option>
                                                    <option value="facebook">Facebook</option>
                                                    <option value="instagram">Instagram</option>
                                                    <option value="twitter">Twitter</option>
                                                    <option value="linkedin">LinkedIn</option>
                                                    <option value="tiktok">TikTok</option>
                                                    <option value="youtube">YouTube</option>
                                                    <option value="pinterest">Pinterest</option>
                                                    <option value="snapchat">Snapchat</option>
                                                    <option value="whatsapp">WhatsApp</option>
                                                    <option value="telegram">Telegram</option>
                                                    <option value="kwai">Kwai</option>
                                                    <option value="discord">Discord</option>
                                                    <option value="reddit">Reddit</option>
                                                    <option value="twitch">Twitch</option>
                                                    <option value="vkontakte">VK</option>
                                                    <option value="weibo">Weibo</option>
                                                    <option value="douyin">Douyin</option>
                                                    <option value="line">LINE</option>
                                                    <option value="outros">Outros</option>
                                                </select>
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
                    url: "{{ route('panel.categories.store') }}",
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
                            window.location.href = "{{ route('panel.categories.index') }}";
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
