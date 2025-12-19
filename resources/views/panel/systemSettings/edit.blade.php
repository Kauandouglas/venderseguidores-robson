@extends('panel.templates.master')
@section('title', 'Configuração do sistema')
@section('content')
    <a href="https://youtu.be/Ba92lzJNSIU" target="_blank" class="btn btn-danger mb-3">
        <i class="mb-1" data-feather="play" width="20"></i> Vídeo Tutorial
    </a>
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-md-12 col-12 mt-3">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="post" id="systemSettingForm"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="url">URL do site</label>
                                                <input type="text" id="url" class="form-control"
                                                       value="{{ route('web.systemSettings.template', ['domain' => Auth::user()->domain]) }}"
                                                       readonly>
                                                <i data-toggle="tooltip" id="copy" data-placement="left"
                                                   title="Copiado com sucesso!"
                                                   style="position: relative; float: right;margin-top: -36px;margin-right: 7px;cursor: pointer;height: 35px;background-color: #f2f4f4;width: 21px;"
                                                   data-feather="copy" width="20"></i>
                                            </div>
                                        </div>

                                        {{-- Configuration --}}
                                        <div class="col-12 mt-3">
                                            <h4 class="font-bold">Configuração do site</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="template">Templates</label>
                                                <select name="template_id" class="form-control" id="template">
                                                    @foreach($templates as $template)
                                                        <option
                                                            {{ (isset($systemSetting->template_id) && $template->id == $systemSetting->template_id) ? 'selected' : '' }}
                                                            value="{{ $template->id }}">{{ $template->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="title">Título</label>
                                                <input type="text" id="title" class="form-control" name="title"
                                                       value="{{ $systemSetting->title ?? 'Título do site' }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Descrição</label>
                                                <textarea name="description" id="description" class="form-control"
                                                          rows="10"
                                                          cols="30">{{ $systemSetting->description ?? null }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="keyword">Palavras-chave</label>
                                                <textarea name="keyword" id="keyword" class="form-control"
                                                          rows="10"
                                                          cols="30">{{ $systemSetting->keyword ?? null }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Logo --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Logotipo do site</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="logo">Logo (.png) (100 x 38)</label>
                                                <input type="file" id="logo" class="form-control" name="logo"
                                                       accept="image/*">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="favicon">Favicon (.png) (50 x 50)</label>
                                                <input type="file" id="favicon" class="form-control" name="favicon"
                                                       accept="image/*">
                                            </div>
                                        </div>

                                        {{-- Color --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Layout do site</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="primary_color">Cor primária</label>
                                                <input type="color" id="primary_color" class="form-control"
                                                       name="primary_color"
                                                       value="{{ $systemSetting->primary_color ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="secondary_color">Cor secundária</label>
                                                <input type="color" id="secondary_color" class="form-control"
                                                       name="secondary_color"
                                                       value="{{ $systemSetting->secondary_color ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch mt-2">
                                                    <input
                                                        {{ (isset($systemSetting->color_default) && $systemSetting->color_default ? 'checked' : (!isset($systemSetting->color_default) ? 'checked' : '')) }}
                                                        name="color_default" type="checkbox"
                                                        class="custom-control-input" id="colorDefault">
                                                    <label class="custom-control-label" for="colorDefault">
                                                        Cor padrão
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Terms --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Termos do site</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="terms">Conteúdo</label>
                                                <textarea name="terms" id="terms" class="form-control" rows="10"
                                                          cols="30">{{ $systemSetting->terms ?? null }}</textarea>
                                            </div>
                                        </div>

                                        {{-- Code --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Código embutido</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-danger text-lowercase" for="code">Inserido na
                                                    tag {{ '<head>' }} da página. Usado para Google Analytics, código de
                                                    pixel do Facebook etc.
                                                </label>
                                                <textarea name="code" id="code" class="form-control" rows="10"
                                                          cols="30">{!! $systemSetting->code ?? null !!}</textarea>
                                            </div>
                                        </div>

                                        {{-- Contract --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Contatos</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="phone">Telefone</label>
                                                <input type="text" id="phone" class="form-control" name="phone"
                                                       value="{{ $systemSetting->phone ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                       value="{{ $systemSetting->email ?? null }}">
                                            </div>
                                        </div>

                                        {{-- Popup --}}
                                        <div class="col-12 mt-5">
                                            <h4 class="font-bold">Popup de notificação</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch mt-2">
                                                    <input name="notify_popup_status" type="checkbox"
                                                           {{ (isset($systemSetting->notify_popup_status) && $systemSetting->notify_popup_status ? 'checked' : '') }}
                                                           class="custom-control-input" id="statusNotify" value="1">
                                                    <label class="custom-control-label" for="statusNotify">
                                                        Ativar Popup
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notify_popup_description">URL</label>
                                                <input type="url" id="notify_popup_url" class="form-control"
                                                       name="notify_popup_url"
                                                       value="{{ $systemSetting->notify_popup_url ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notify_popup_description">Descrição</label>
                                                <input type="text" id="notify_popup_description" class="form-control"
                                                       name="notify_popup_description"
                                                       value="{{ $systemSetting->notify_popup_description ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notify_popup_title">Título</label>
                                                <input type="text" id="notify_popup_title" class="form-control"
                                                       name="notify_popup_title"
                                                       value="{{ $systemSetting->notify_popup_title ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notify_popup_button_color">Cor (Botão)</label>
                                                <input type="color" id="notify_popup_button_color" class="form-control"
                                                       name="notify_popup_button_color"
                                                       value="{{ $systemSetting->notify_popup_button_color ?? null }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="notify_popup_button_name">Nome (Botão)</label>
                                                <input type="text" id="notify_popup_button_name" class="form-control"
                                                       name="notify_popup_button_name"
                                                       value="{{ $systemSetting->notify_popup_button_name ?? null }}">
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
{{--    <!-- Main Quill library -->--}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

{{--    <!-- Theme included stylesheets -->--}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <script>
        var quill = new Quill('textarea', {
            modules: {
                toolbar: [
                    [{font: []}, {size: []}],
                    ["bold", "italic", "underline", "strike"],
                    [
                        {color: []},
                        {background: []}
                    ],
                    [
                        {script: "super"},
                        {script: "sub"}
                    ],
                    [
                        {list: "ordered"},
                        {list: "bullet"},
                        {indent: "-1"},
                        {indent: "+1"}
                    ],
                    ["direction", {align: []}],
                    ["link", "video"],
                    ["clean"]]
            },
            theme: "snow"
        });

        // Submit form
        jQuery(document).ready(function () {
            jQuery('#systemSettingForm').submit(function () {
                var data = new FormData(this);
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    data: data,
                    url: "{{ route('panel.systemSettings.update') }}",
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

            // Mask
            $(document).ready(function () {
                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function (val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        },
                        clearIfNotMatch: true
                    };
                $('input[name="phone"]').mask(SPMaskBehavior, spOptions);
            });

            // Check Color Default
            $('#colorDefault').change(function () {
                colorDefault();
            })

            function colorDefault() {
                if ($('#colorDefault').is(':checked')) {
                    $('input[type="color"]').attr('disabled', true);
                } else {
                    $('input[type="color"]').attr('disabled', false);
                }
            }

            colorDefault();

            // Copy URL
            $('#copy').click(function () {
                $('[data-toggle="tooltip"]').tooltip('show');
                var url = $('#url');
                url.select();
                navigator.clipboard.writeText(url.val());
            })
        });
    </script>
@endpush
