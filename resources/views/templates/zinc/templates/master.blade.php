<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $systemSetting->description ?? '' }}">
    <meta name="keywords" content="{{ $systemSetting->keyword ?? '' }}">
    <title>{{ $systemSetting->title ?? config('template.title') }} - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @if(isset($systemSetting->color_default) && $systemSetting->color_default == 0)
        <style>
            .bg-default-primary {
                background-color: {{ $systemSetting->primary_color . ' !important' }};
            }

            .bg-default-primary:hover {
                background-color: transparent !important;
            }

            .border-default-primary {
                border: 1px solid{{ $systemSetting->primary_color . ' !important' }};
            }

            .color-default-primary {
                color: {{ $systemSetting->primary_color . ' !important' }};
            }

            .color-default-primary-hover:hover {
                color: {{ $systemSetting->primary_color . ' !important' }};
            }

            /* Secondary */
            .bg-default-secondary {
                background-color: {{ $systemSetting->secondary_color . ' !important' }};
            }

            .bg-default-secondary:hover {
                background-color: transparent !important;
            }

            .border-default-secondary {
                border: 1px solid{{ $systemSetting->secondary_color . ' !important' }};
            }

            .color-default-secondary {
                color: {{ $systemSetting->secondary_color . ' !important' }};
            }

            .color-default-secondary-hover:hover {
                color: {{ $systemSetting->secondary_color . ' !important' }};
            }

            .active {
                color: {{ $systemSetting->secondary_color . ' !important' }};
            }

            /* Purchase */
            .btn-purchase-reg {
                background-color: {{ $systemSetting->secondary_color . ' !important' }};
                border: 1px solid{{ $systemSetting->secondary_color . ' !important' }};
                color: #fff !important;
            }

            .btn-purchase-reg:hover {
                background-color: #fff !important;
                border: 1px solid{{ $systemSetting->secondary_color . ' !important' }};
                color: {{ $systemSetting->secondary_color . ' !important' }};
            }

            .nav-fill {
                background-color: {{ $systemSetting->primary_color . ' !important' }};
            }

            .h2-heading span {
                background-color: {{ $systemSetting->primary_color . ' !important' }};
                color: #fff;
                border: 2px solid{{ $systemSetting->secondary_color . ' !important' }};
            }
        </style>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap"
          rel="stylesheet">
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
    <link href="{{ asset(mix('template_assets/zinc/css/style.css')) }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ $systemSetting->url_favicon ?? '' }}">

    {!! $systemSetting->code ?? '' !!}

    @if(!empty($conversionTag->pixel_google_ads))
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_google_ads }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ $conversionTag->pixel_google_ads }}');
        </script>
    @endif

    @if(!empty($conversionTag->pixel_analytics))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $conversionTag->pixel_analytics }}');
        </script>
    @endif
</head>
<body data-bs-spy="scroll" data-bs-target="#navbarExample">
<div id="displayLoading" class="d-none">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Carregando...</span>
        </div>
    </div>
</div>
@include('templates.zinc.includes.header')
@yield('content')
@include('templates.zinc.includes.footer')

<a href="https://api.whatsapp.com/send?phone=55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}"
   target="_blank">
    <button id="myBtn">
        <i class="fab fa-whatsapp"></i>
    </button>
</a>

@if(isset($systemSetting->notify_popup_status) && $systemSetting->notify_popup_status)
    <!-- Modal -->
    <div class="modal fade" id="alertModalWhatsapp" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 600px; max-width: 95%">
            <div class="modal-content" style="padding-right: 1rem;padding-left: 1rem;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $systemSetting->notify_popup_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">{{ $systemSetting->notify_popup_description }}</div>
                <div class="modal-footer">
                    <a target="_blank" href="{{ $systemSetting->notify_popup_url }}">
                        <button style="background-color: {{ $systemSetting->notify_popup_button_color }}"
                                id="buttonGroup"
                                type="button" class="btn btn-primary border-0">
                            {{ $systemSetting->notify_popup_button_name }}
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset(mix('template_assets/zinc/js/scripts.js')) }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.dropdown-item, #navbarsExampleDefault .bg-default-secondary').click(function () {
        document.querySelector(".offcanvas-collapse").classList.toggle("open")
    })
</script>
@if(isset($systemSetting->notify_popup_status) && $systemSetting->notify_popup_status)
    <script>
        $(function () {
            if (localStorage.modalAlertdx{{$systemSetting->id}} != "open") {
                $('#alertModalWhatsapp').modal('show')
            }

            $('#buttonGroup').on('click', function (event) {
                window.localStorage.setItem('modalAlertdx{{$systemSetting->id}}', 'open');
            })
        })
    </script>
@endif
@stack('scripts')
</body>
</html>
