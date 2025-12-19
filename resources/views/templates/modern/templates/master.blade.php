<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $systemSetting->description ?? '' }}">
    <meta name="keywords" content="{{ $systemSetting->keyword ?? '' }}">
    <title>{{ $systemSetting->title ?? config('template.title') }} - Home</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ $systemSetting->url_favicon ?? '' }}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Mercado Pago -->
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        :root {
            --primary-color: {{ $systemSetting->primary_color ?? '#9333ea' }};
            --secondary-color: {{ $systemSetting->secondary_color ?? '#ec4899' }};
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            border-radius: 6px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            opacity: 0.8;
        }

        /* Loading Spinner */
        #displayLoading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #displayLoading.d-none {
            display: none !important;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border: 4px solid #f3f4f6;
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* WhatsApp Float Button */
        #myBtn {
            position: fixed;
            bottom: 100px;
            right: 30px;
            z-index: 998;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 32px;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #myBtn:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 15px 35px rgba(37, 211, 102, 0.6);
        }

        #myBtn:active {
            transform: scale(0.95);
        }

        /* Pulse Animation for WhatsApp */
        #myBtn::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #25D366;
            animation: pulse-whatsapp 2s infinite;
            z-index: -1;
        }

        @keyframes pulse-whatsapp {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.3);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 0;
            }
        }

        /* Smooth Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        /* Modal Improvements */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-dialog {
            width: 600px;
            max-width: 95%;
            margin: auto;
        }

        .modal-content {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.3s ease-out;
            overflow: hidden;
        }

        .modal-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .btn-close {
            background: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            opacity: 0.9;
            transition: all 0.3s;
        }

        .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem 1.5rem;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #4b5563;
        }

        .modal-footer {
            padding: 1.5rem;
            border: none;
            background: #f9fafb;
        }

        /* Custom Button Styles */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 0.875rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(147, 51, 234, 0.4);
        }

        @if(isset($systemSetting->color_default) && $systemSetting->color_default == 0)
        /* Dynamic Color Classes */
        .bg-default-primary {
            background-color: {{ $systemSetting->primary_color }} !important;
        }

        .bg-default-primary:hover {
            background-color: transparent !important;
        }

        .border-default-primary {
            border-color: {{ $systemSetting->primary_color }} !important;
        }

        .text-default-primary {
            color: {{ $systemSetting->primary_color }} !important;
        }

        .text-default-primary-hover:hover {
            color: {{ $systemSetting->primary_color }} !important;
        }

        /* Secondary Colors */
        .bg-default-secondary {
            background-color: {{ $systemSetting->secondary_color }} !important;
        }

        .bg-default-secondary:hover {
            background-color: transparent !important;
        }

        .border-default-secondary {
            border-color: {{ $systemSetting->secondary_color }} !important;
        }

        .text-default-secondary {
            color: {{ $systemSetting->secondary_color }} !important;
        }

        .text-default-secondary-hover:hover {
            color: {{ $systemSetting->secondary_color }} !important;
        }

        .active {
            color: {{ $systemSetting->secondary_color }} !important;
        }

        /* Purchase Button */
        .btn-purchase-reg {
            background-color: {{ $systemSetting->secondary_color }} !important;
            border: 2px solid {{ $systemSetting->secondary_color }} !important;
            color: #fff !important;
            padding: 0.875rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-purchase-reg:hover {
            background-color: #fff !important;
            color: {{ $systemSetting->secondary_color }} !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-fill {
            background-color: {{ $systemSetting->primary_color }} !important;
        }

        .h2-heading span {
            background-color: {{ $systemSetting->primary_color }} !important;
            color: #fff;
            border: 2px solid {{ $systemSetting->secondary_color }} !important;
        }
        @endif

        /* Tailwind Config Extension */
        @layer utilities {
            .text-balance {
                text-wrap: balance;
            }
        }
    </style>

    <!-- Original CSS (if needed for compatibility) -->
    <link href="{{ asset(mix('template_assets/zinc/css/style.css')) }}" rel="stylesheet">

    <!-- Custom Code from Settings -->
    {!! $systemSetting->code ?? '' !!}

    <!-- Google Ads Pixel -->
    @if(!empty($conversionTag->pixel_google_ads))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_google_ads }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $conversionTag->pixel_google_ads }}');
        </script>
    @endif

    <!-- Google Analytics -->
    @if(!empty($conversionTag->pixel_analytics))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $conversionTag->pixel_analytics }}');
        </script>
    @endif

    @stack('styles')
</head>

<body class="antialiased bg-gray-50" data-bs-spy="scroll" data-bs-target="#navbarExample">
    <!-- Loading Spinner -->
    <div id="displayLoading" class="d-none">
        <div class="flex flex-col items-center gap-4">
            <div class="spinner-border" role="status"></div>
            <span class="text-gray-600 font-medium">Carregando...</span>
        </div>
    </div>

    <!-- Header -->
    @include('templates.modern.includes.header')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('templates.modern.includes.footer')

    <!-- Notification Modal -->
    @if(isset($systemSetting->notify_popup_status) && $systemSetting->notify_popup_status)
        <div class="modal fade" id="alertModalWhatsapp" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ $systemSetting->notify_popup_title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ $systemSetting->notify_popup_description }}
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" href="{{ $systemSetting->notify_popup_url }}" rel="noopener noreferrer">
                            <button style="background-color: {{ $systemSetting->notify_popup_button_color ?? 'var(--primary-color)' }}"
                                    id="buttonGroup"
                                    type="button" 
                                    class="btn-primary-custom">
                                {{ $systemSetting->notify_popup_button_name }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset(mix('template_assets/zinc/js/scripts.js')) }}"></script>

    <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Mobile Menu Toggle
        $('.dropdown-item, #navbarsExampleDefault .bg-default-secondary').click(function () {
            const offcanvas = document.querySelector(".offcanvas-collapse");
            if (offcanvas) {
                offcanvas.classList.toggle("open");
            }
        });

        // Smooth Scroll Enhancement
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Scroll to Top on Page Load
        window.addEventListener('load', function() {
            window.scrollTo(0, 0);
        });

        // Add Animation on Scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const fadeInObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeIn');
                    fadeInObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card, .group, section > div').forEach(el => {
            fadeInObserver.observe(el);
        });

        // Enhanced SweetAlert2 Defaults
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Custom SweetAlert2 Theme
        window.Swal = Swal.mixin({
            customClass: {
                popup: 'rounded-2xl shadow-2xl',
                title: 'text-2xl font-bold',
                confirmButton: 'btn-primary-custom px-6 py-3',
                cancelButton: 'bg-gray-200 text-gray-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-300 transition-all'
            },
            buttonsStyling: false
        });
    </script>

    <!-- Popup Modal Script -->
    @if(isset($systemSetting->notify_popup_status) && $systemSetting->notify_popup_status)
        <script>
            $(function () {
                const modalKey = 'modalAlertdx{{ $systemSetting->id }}';
                
                if (localStorage.getItem(modalKey) !== "open") {
                    setTimeout(() => {
                        $('#alertModalWhatsapp').addClass('show');
                    }, 500);
                }

                $('#buttonGroup, .btn-close').on('click', function () {
                    localStorage.setItem(modalKey, 'open');
                    $('#alertModalWhatsapp').removeClass('show');
                });

                // Close modal on backdrop click
                $('#alertModalWhatsapp').on('click', function(e) {
                    if (e.target === this) {
                        localStorage.setItem(modalKey, 'open');
                        $(this).removeClass('show');
                    }
                });

                // Close modal on ESC key
                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape' && $('#alertModalWhatsapp').hasClass('show')) {
                        localStorage.setItem(modalKey, 'open');
                        $('#alertModalWhatsapp').removeClass('show');
                    }
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>