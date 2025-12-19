@extends('panel.templates.master')
@section('title', 'Configuração do template')
@section('content')
    <a href="https://youtu.be/JZrWS0vB9yc" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="configTemplateForm"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Menu</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Botão</label>
                                                <input type="text" id="title" class="form-control" name="nav_button"
                                                       value="{{ $configTemplate->nav_button ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Cabeçalho</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Título</label>
                                                <input type="text" id="title" class="form-control" name="header_title"
                                                       value="{{ $configTemplate->header_title ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Subtitulo</label>
                                                <textarea class="form-control" name="header_sub_title" id="title"
                                                          cols="30"
                                                          rows="5">{{ $configTemplate->header_sub_title ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Botão</label>
                                                <input type="text" id="title" class="form-control" name="header_button"
                                                       value="{{ $configTemplate->header_button ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <p>Imagem</p>
                                                <label>
                                                    <img width="180" style="cursor: pointer"
                                                         src="{{ $configTemplate->url_header_image ?? asset(config('template.url_header_image')) }}">
                                                    <input type="file" id="title" class="d-none"
                                                           name="header_image" value="" accept="image/*">
                                                </label>
                                                <p>
                                                    <a class="text-danger"
                                                       href="{{ route('panel.configTemplates.removeImage', ['type' => 'header_image']) }}">
                                                        Restaurar Imagem
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Serviço</h4>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <p>Imagem 1</p>
                                                <label>
                                                    <img width="180" style="cursor: pointer"
                                                         src="{{ $configTemplate->url_service_image_1 ?? asset(config('template.url_service_image_1')) }}">
                                                    <input type="file" id="title" class="d-none"
                                                           name="service_image_1" value="" accept="image/*">
                                                </label>
                                                <p>
                                                    <a class="text-danger"
                                                       href="{{ route('panel.configTemplates.removeImage', ['type' => 'service_image_1']) }}">
                                                        Restaurar Imagem
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Título 1</label>
                                                <input type="text" id="title" class="form-control"
                                                       name="service_title_1"
                                                       value="{{ $configTemplate->service_title_1 ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Subtítulo 1</label>
                                                <textarea class="form-control" name="service_sub_title_1" id="title"
                                                          cols="30"
                                                          rows="5">{{ $configTemplate->service_sub_title_1 ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_description_1">Descrição 1</label>
                                                <textarea class="form-control" name="service_description_1"
                                                          id="service_description_1" cols="30"
                                                          rows="5">{{ $configTemplate->service_description_1 ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <div class="form-group">
                                                <p>Imagem 2</p>
                                                <label>
                                                    <img width="180" style="cursor: pointer"
                                                         src="{{ $configTemplate->url_service_image_2 ?? asset(config('template.url_service_image_2')) }}">
                                                    <input type="file" id="title" class="d-none"
                                                           name="service_image_2" value="" accept="image/*">
                                                </label>
                                                <p>
                                                    <a class="text-danger"
                                                       href="{{ route('panel.configTemplates.removeImage', ['type' => 'service_image_2']) }}">
                                                        Restaurar Imagem
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_title_2">Título 2</label>
                                                <input type="text" id="service_title_2" class="form-control"
                                                       name="service_title_2"
                                                       value="{{ $configTemplate->service_title_2 ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_sub_title_2">Subtítulo 2</label>
                                                <textarea class="form-control" name="service_sub_title_2"
                                                          id="service_sub_title_2" cols="30"
                                                          rows="5">{{ $configTemplate->service_sub_title_2 ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_description_2">Descrição 2</label>
                                                <textarea class="form-control" name="service_description_2"
                                                          id="service_description_2" cols="30"
                                                          rows="5">{{ $configTemplate->service_description_2 ?? '' }}</textarea>
                                            </div>
                                        </div>


                                        <div class="col-12 mt-5">
                                            <div class="form-group">
                                                <p>Imagem 3</p>
                                                <label>
                                                    <img width="180" style="cursor: pointer"
                                                         src="{{ $configTemplate->url_service_image_3 ?? asset(config('template.url_service_image_3')) }}">
                                                    <input type="file" id="title" class="d-none"
                                                           name="service_image_3" value="" accept="image/*">
                                                </label>
                                                <p>
                                                    <a class="text-danger"
                                                       href="{{ route('panel.configTemplates.removeImage', ['type' => 'service_image_3']) }}">
                                                        Restaurar Imagem
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_title_3">Título 3</label>
                                                <input type="text" id="service_title_3" class="form-control"
                                                       name="service_title_3"
                                                       value="{{ $configTemplate->service_title_3 ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_sub_title_3">Subtítulo 3</label>
                                                <textarea class="form-control" name="service_sub_title_3"
                                                          id="service_sub_title_3" cols="30"
                                                          rows="5">{{ $configTemplate->service_sub_title_3 ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="service_description_3">Descrição 3</label>
                                                <textarea class="form-control" name="service_description_3"
                                                          id="service_description_3" cols="30"
                                                          rows="5">{{ $configTemplate->service_description_3 ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Sobre</h4>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <p>Imagem 2</p>
                                                <label>
                                                    <img width="180" style="cursor: pointer"
                                                         src="{{ $configTemplate->url_about_image ?? asset(config('template.url_about_image')) }}">
                                                    <input type="file" id="title" class="d-none"
                                                           name="about_image" value="" accept="image/*">
                                                </label>
                                                <p>
                                                    <a class="text-danger"
                                                       href="{{ route('panel.configTemplates.removeImage', ['type' => 'url_about_image']) }}">
                                                        Restaurar Imagem
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="about_title">Título</label>
                                                <input type="text" id="about_title" class="form-control"
                                                       name="about_title"
                                                       value="{{ $configTemplate->about_title ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="about_description">Descrição</label>
                                                <textarea class="form-control" name="about_description"
                                                          id="about_description" cols="30"
                                                          rows="5">{{ $configTemplate->about_description ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="about_button">Botão</label>
                                                <input type="text" id="about_button" class="form-control"
                                                       name="about_button"
                                                       value="{{ $configTemplate->about_button ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Basico</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="basic_title">Título</label>
                                                <input type="text" id="basic_title" class="form-control"
                                                       name="basic_title"
                                                       value="{{ $configTemplate->basic_title ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="basic_description">Descrição</label>
                                                <textarea class="form-control" name="basic_description"
                                                          id="basic_description" cols="30"
                                                          rows="5">{{ $configTemplate->basic_description ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Contato</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact_title">Título</label>
                                                <input type="text" id="contact_title" class="form-control"
                                                       name="contact_title"
                                                       value="{{ $configTemplate->contact_title ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact_description">Descrição</label>
                                                <textarea class="form-control" name="contact_description"
                                                          id="contact_description" cols="30"
                                                          rows="5">{{ $configTemplate->contact_description ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Rodapé</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="footer_title">Título</label>
                                                <input type="text" id="footer_title" class="form-control"
                                                       name="footer_title"
                                                       value="{{ $configTemplate->footer_title ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
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
            jQuery('#configTemplateForm').submit(function () {
                var data = new FormData(this);
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    data: data,
                    url: "{{ route('panel.configTemplates.update') }}",
                    responseType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function (response) {
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
                        })
                    },
                    complete: function (response) {
                        displayLoading('hide');
                    }
                });

                return false;
            });
        });

        $('input[type="file"]').change(function (event) {
            previewImage(event);
        });

        function previewImage(event) {
            var input = event.target;
            var preview = event.target.previousElementSibling;

            var reader = new FileReader();

            reader.onload = function() {
                preview.src = reader.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
