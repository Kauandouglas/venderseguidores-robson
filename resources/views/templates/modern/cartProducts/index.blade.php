<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Título da página --}}
    <title>{{ $systemSetting->title ?? config('template.title') }} - Home</title>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ $systemSetting->url_favicon ?? asset('images/default-favicon.ico') }}">

    {{-- Meta básicos --}}
    <meta name="title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta name="description" content="{{ $systemSetting->description ?? config('template.description') ?? '' }}">
    <meta name="keywords" content="{{ $systemSetting->keyword ?? '' }}">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Portuguese">
    <meta name="author" content="{{ $systemSetting->title ?? config('template.title') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta property="og:description" content="{{ $systemSetting->description ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:image" content="{{ $systemSetting?->logo ? Storage::url($systemSetting->logo) : asset('images/default-logo.png') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta name="twitter:description" content="{{ $systemSetting->description ?? '' }}">
    <meta name="twitter:image" content="{{ $systemSetting?->logo ? Storage::url($systemSetting->logo) : asset('images/default-logo.png') }}">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->full() }}" />

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

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
<body>

    <!-- BOTÃO WHATSAPP FLUTUANTE -->
    <a href="https://wa.me/55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}" target="_blank"
       style="
          position: fixed;
          bottom: 20px;
          right: 20px;
          background: #25d366;
          color: #fff;
          width: 60px;
          height: 60px;
          border-radius: 50%;
          display: flex;
          justify-content: center;
          align-items: center;
          font-size: 32px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.25);
          text-decoration: none;
          z-index: 9999;
       ">
       <i class="fab fa-whatsapp"></i>
    </a>

    @php
        if (empty($_SERVER['HTTPS'])){
            header("location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        }
    @endphp

    <style>
        /* Custom styles for smooth transitions */
        .smooth-transition {
            transition: all 0.3s ease;
        }

        /* Fix for Tailwind container */
        .container {
            max-width: 1200px;
        }

        /* Garantir que elementos hidden fiquem ocultos */
        .hidden {
            display: none !important;
        }
    </style>

    <!-- Hero Section with Instructions -->
    <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 py-8">
        <div class="container mx-auto px-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <h2 class="text-white text-2xl font-bold mb-4 text-center">Instruções Importantes</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white/90 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">✅</span>
                        <p class="text-gray-800 text-sm">Para seguidores e visualizações no story, use o nome de usuário ou o link do perfil.</p>
                    </div>
                    <div class="bg-white/90 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">✅</span>
                        <p class="text-gray-800 text-sm">Para curtidas, visualizações e comentários, use o link do post.</p>
                    </div>
                    <div class="bg-white/90 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">🚫</span>
                        <p class="text-gray-800 text-sm">O perfil não pode estar privado, nem com restrição de idade ou país.</p>
                    </div>
                    <div class="bg-white/90 rounded-xl p-4 flex items-start gap-3">
                        <span class="text-2xl flex-shrink-0">🚫</span>
                        <p class="text-gray-800 text-sm">Nunca faça dois pedidos da mesma função da rede social para o mesmo link ao mesmo tempo.</p>
                    </div>
                </div>
            </div>

            <div id="show-cart" class="mt-6"></div>
        </div>
    </div>

    <!-- Main Checkout Section -->
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4">
            <form class="pix-body" method="post" action="">
                <div class="grid lg:grid-cols-5 gap-8">

                    <!-- Column 1: Personal Data -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-4">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold text-lg">1</span>
                                    </div>
                                    <h3 class="text-white font-bold text-xl">Dados Pessoais</h3>
                                </div>
                            </div>

                            <!-- Form Fields -->
                            <div class="p-6 space-y-5">
                                <div class="alert alert-danger hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded"></div>

                                <input type="hidden" name="type" value="pix">

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                           placeholder="Digite seu nome completo">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">WhatsApp</label>
                                    <input type="text"
                                           name="whatsapp"
                                           id="whatsapp"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                           placeholder="(00) 00000-0000">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail</label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                           placeholder="seu@email.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Payment Data -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-green-600 to-emerald-500 p-6">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-bold text-lg">2</span>
                                    </div>
                                    <h3 class="text-white font-bold text-xl">Dados de Pagamento</h3>
                                </div>
                            </div>

                            <div class="p-6 space-y-8">

                                <!-- Coupon Section -->
                                <div class="border-b border-gray-200 pb-6">
                                    <h4 class="font-bold text-gray-800 text-lg mb-4">Cupom de Desconto</h4>

                                    <div id="ativa_cupom" class="mb-4">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox"
                                                   id="possui-cupom"
                                                   value="cupom"
                                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                            <span class="text-gray-700 font-medium">Tenho um cupom de desconto</span>
                                        </label>
                                    </div>

                                    <div class="hidden" id="discountCupom">
                                        <div class="flex gap-3">
                                            <input type="text"
                                                   id="coupon-code"
                                                   name="coupon"
                                                   class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                                   placeholder="Digite o código do cupom">
                                            <button type="button"
                                                    id="apply-coupon"
                                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl smooth-transition">
                                                Aplicar
                                            </button>
                                        </div>
                                        <div class="mt-3 hidden" id="coupon-message">
                                            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded">
                                                ✓ Cupom aplicado com sucesso!
                                            </div>
                                        </div>
                                    </div>
                                    <span class="hidden text-red-600 text-sm mt-2 block" id="cupom-error"></span>
                                </div>

                                <!-- Payment Method -->
                                <div class="border-b border-gray-200 pb-6">
                                    <h4 class="font-bold text-gray-800 text-lg mb-2">Método de Pagamento</h4>
                                    <p class="text-gray-600 text-sm mb-4">Selecione como deseja pagar</p>

                                    <button type="button"
                                            id="pagarcom-pix"
                                            class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg smooth-transition">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                        </svg>
                                        <span>Pagar com PIX</span>
                                    </button>
                                </div>

                                <span class="hidden bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded block" id="total_descontos"></span>

                                <!-- PIX Payment Section -->
                                <div id="pagamento-pix">
                                    <!-- Total -->
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-6 border-2 border-gray-200">
                                        @if(isset($serviceDescount))
                                            <div class="space-y-3">
                                                <div class="flex justify-between items-center text-gray-500">
                                                    <span class="line-through">Valor Original</span>
                                                    <span class="line-through">R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                                </div>
                                                <div class="flex justify-between items-center text-green-600 font-semibold">
                                                    <span>Desconto</span>
                                                    <span>- R$ {{ number_format($sumProducts - $pricePercent, 2, ',', '.') }}</span>
                                                </div>
                                                <div class="border-t-2 border-gray-300 pt-3">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-xl font-bold text-gray-800">Total a Pagar</span>
                                                        <span class="text-3xl font-bold text-green-600">R$ {{ number_format($pricePercent, 2, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-between items-center">
                                                <span class="text-xl font-bold text-gray-800">Total a Pagar</span>
                                                <span class="text-3xl font-bold text-blue-600">R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- PIX QR Code -->
                                    <div class="pix-generate-body hidden">
                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-dashed border-blue-300 rounded-xl p-8 text-center">
                                            <h5 class="text-xl font-bold text-gray-800 mb-4">Escaneie o QR Code</h5>
                                            <div class="bg-white p-4 rounded-xl inline-block mb-6 shadow-lg">
                                                <img alt="QR Code PIX"
                                                     id="pixPaymentImage"
                                                     src=""
                                                     class="w-64 h-64 mx-auto">
                                            </div>

                                            <div class="text-left mb-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Ou copie o código PIX abaixo:
                                                </label>
                                                <textarea id="pixPaymentCode"
                                                          readonly
                                                          class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl text-sm font-mono resize-none"
                                                          rows="3"></textarea>
                                            </div>

                                            <button type="button"
                                                    id="pixPaymentCopy"
                                                    class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg smooth-transition">
                                                📋 Copiar Código PIX
                                            </button>
                                            <p class="message hidden mt-3 text-green-600 font-semibold">✓ Código copiado com sucesso!</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Credit Card Section (Hidden) -->
                                <div class="hidden" id="pagamento-cartao" data-cartao="credito">
                                    <h5 class="font-bold text-gray-800 text-lg mb-4">Dados do Cartão</h5>

                                    <!-- Card Preview -->
                                    <div class="card-cred mb-6" id="credito" data-jp-card-initialized="true">
                                        <div class="jp-card-container">
                                            <div class="jp-card">
                                                <div class="jp-card-front">
                                                    <div class="jp-card-logo jp-card-elo"><div class="e">e</div><div class="l">l</div><div class="o">o</div></div>
                                                    <div class="jp-card-logo jp-card-visa">Visa</div>
                                                    <div class="jp-card-logo jp-card-visaelectron">Visa<div class="elec">Electron</div></div>
                                                    <div class="jp-card-logo jp-card-mastercard">Mastercard</div>
                                                    <div class="jp-card-logo jp-card-maestro">Maestro</div>
                                                    <div class="jp-card-logo jp-card-amex"></div>
                                                    <div class="jp-card-logo jp-card-discover">discover</div>
                                                    <div class="jp-card-logo jp-card-dinersclub"></div>
                                                    <div class="jp-card-logo jp-card-dankort"><div class="dk"><div class="d"></div><div class="k"></div></div></div>
                                                    <div class="jp-card-logo jp-card-jcb"><div class="j">J</div><div class="c">C</div><div class="b">B</div></div>
                                                    <div class="jp-card-lower">
                                                        <div class="jp-card-shiny"></div>
                                                        <div class="jp-card-cvc jp-card-display">•••</div>
                                                        <div class="jp-card-number jp-card-display">•••• •••• •••• ••••</div>
                                                        <div class="jp-card-name jp-card-display">Full Name</div>
                                                        <div class="jp-card-expiry jp-card-display" data-before="month/year" data-after="valid thru">••/••</div>
                                                    </div>
                                                </div>
                                                <div class="jp-card-back">
                                                    <div class="jp-card-bar"></div>
                                                    <div class="jp-card-cvc jp-card-display">•••</div>
                                                    <div class="jp-card-shiny"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accepted Cards -->
                                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 mb-6">
                                        <p class="text-xs font-bold text-gray-700 mb-3 text-center">Bandeiras Aceitas</p>
                                        <div class="flex flex-wrap justify-center gap-3">
                                            <img src="https://media.braip.com/public/card-flag/visa.png" alt="Visa" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/master-card.png" alt="Master Card" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/hiper-card.png" alt="Hipercard" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/american-express.png" alt="American Express" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/diners.png" alt="Diners Club" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/elo.png" alt="Elo" class="h-8">
                                        </div>
                                    </div>

                                    <!-- Card Number -->
                                    <div class="mb-5">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Número do Cartão</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                                <i class="far fa-credit-card"></i>
                                            </span>
                                            <input type="tel"
                                                   autocomplete="cc-number"
                                                   name="credito_numero_cartao"
                                                   data-cartao="credito"
                                                   data-name="numero_cartao"
                                                   data-iugu="number"
                                                   data-encrypted-name="number"
                                                   data-checkout="cardNumber"
                                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                                   placeholder="0000 0000 0000 0000"
                                                   onselectstart="return false"
                                                   oncopy="return false"
                                                   oncut="return false"
                                                   ondrag="return false"
                                                   ondrop="return false">
                                        </div>
                                        <span class="hidden text-red-600 text-sm mt-1 block" id="credito_numero_cartao-error">Informe um número válido</span>
                                        <span class="hidden text-red-600 text-sm mt-1 block number-cards-duplicate">Os números de cartões não podem ser iguais.</span>
                                    </div>

                                    <!-- Cardholder Name -->
                                    <div class="mb-5">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nome do Titular</label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <input type="text"
                                                   autocomplete="cc-name"
                                                   name="credito_full_name"
                                                   data-cartao="credito"
                                                   data-checkout="cardholderName"
                                                   data-iugu="full_name"
                                                   data-name="full_name"
                                                   data-encrypted-name="holderName"
                                                   maxlength="255"
                                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition"
                                                   placeholder="Nome como está no cartão">
                                        </div>
                                        <span class="hidden text-red-600 text-sm mt-1 block" id="credito_full_name-error">Informe um nome válido</span>
                                    </div>

                                    <!-- Expiry and CVC -->
                                    <div class="grid grid-cols-2 gap-5 mb-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Validade</label>
                                            <div class="flex gap-2">
                                                <input type="text"
                                                       maxlength="2"
                                                       name="credito_mes"
                                                       autocomplete="cc-exp-month"
                                                       data-cartao="credito"
                                                       data-encrypted-name="expiryMonth"
                                                       data-name="mes"
                                                       class="w-1/2 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition text-center"
                                                       placeholder="MM"
                                                       onselectstart="return false"
                                                       onpaste="return false"
                                                       oncopy="return false"
                                                       oncut="return false"
                                                       ondrag="return false"
                                                       ondrop="return false">
                                                <input type="text"
                                                       maxlength="2"
                                                       name="credito_ano"
                                                       autocomplete="cc-exp-year"
                                                       data-cartao="credito"
                                                       data-name="ano_exibido"
                                                       class="w-1/2 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition text-center"
                                                       placeholder="AA"
                                                       onselectstart="return false"
                                                       onpaste="return false"
                                                       oncopy="return false"
                                                       oncut="return false"
                                                       ondrag="return false"
                                                       ondrop="return false">
                                                <input type="hidden"
                                                       data-cartao="credito"
                                                       data-name="ano"
                                                       autocomplete="cc-exp"
                                                       data-encrypted-name="expiryYear"
                                                       data-checkout="cardExpirationYear"
                                                       value="20">
                                            </div>
                                            <span class="hidden text-red-600 text-sm mt-1 block" id="credito_data-validade-error">Informe uma data válida.</span>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="number"
                                                       name="credito_cvc"
                                                       autocomplete="cc-csc"
                                                       data-cartao="credito"
                                                       data-name="codigo_seguranca"
                                                       data-iugu="verification_value"
                                                       data-encrypted-name="cvc"
                                                       data-checkout="securityCode"
                                                       class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition text-center"
                                                       placeholder="123"
                                                       onselectstart="return false"
                                                       onpaste="return false"
                                                       oncopy="return false"
                                                       oncut="return false"
                                                       ondrag="return false"
                                                       ondrop="return false">
                                                <input type="hidden" value="2023-09-30T10:51:52-03:00" data-encrypted-name="generationtime">
                                            </div>
                                            <span class="hidden text-red-600 text-sm mt-1 block" id="credito_codigo_seguranca-error">Informe um CVV válido</span>
                                        </div>
                                    </div>

                                    <!-- Installments -->
                                    <div class="mb-5" id="parcelamento_cartao">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Parcelamento</label>
                                        <select data-cartao="credito"
                                                data-name="parcelamento"
                                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition">
                                            <option value="1" selected data-vlr-parcela-original="0" data-vlr-parcelado-sem-desconto="2500.00" data-vlr-parcelado="2500.00" data-valor_total="2500" data-vlr-parcela="2500" data-vlr-parcela-sem-desconto="2500">
                                                1x de R$ 25,00
                                            </option>
                                            <option value="2" data-vlr-parcela-original="0.00" data-vlr-parcelado-sem-desconto="1306.00" data-vlr-parcelado="1306.00" data-valor_total="2500" data-vlr-parcela="1306" data-vlr-parcela-sem-desconto="1306">
                                                2x de R$ 13,06
                                            </option>
                                            <option value="3" data-vlr-parcela-original="0.00" data-vlr-parcelado-sem-desconto="884.00" data-vlr-parcelado="884.00" data-valor_total="2500" data-vlr-parcela="884" data-vlr-parcela-sem-desconto="884">
                                                3x de R$ 8,84
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="border-t-2 border-gray-200 pt-8">
                                    <button type="submit"
                                            id="submit"
                                            class="w-full py-5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-xl font-bold rounded-xl shadow-2xl smooth-transition transform hover:scale-[1.02] active:scale-[0.98]">
                                        🛒 FINALIZAR COMPRA
                                    </button>

                                    <div class="mt-6 flex items-center justify-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">Ambiente 100% seguro e criptografado</span>
                                    </div>

                                    <div class="mt-6 flex justify-center">
                                        <img src="https://ev.braip.com/img/checkout/compra-segura.png"
                                             alt="Compra Segura"
                                             class="h-14 opacity-60 hover:opacity-100 smooth-transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <script>
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
            $('input[name="whatsapp"]').mask(SPMaskBehavior, spOptions);
        });
    </script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showCart();

            function showCart() {
                var showCart = $('#show-cart');
                loadShowCart();

                $.get('{{ route('api.carts.fragmentIndex', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}', function (response) {
                    showCart.html(response);
                    loadHideCart();
                }, 'html').fail(function () {
                    alert('Ocorreu um erro');
                })
            }

            function loadShowCart() {
                var showCart = $('#show-cart');
                showCart.css('opacity', '0.3').css('pointer-events', 'none');
            }

            function loadHideCart() {
                var showCart = $('#show-cart');
                showCart.css('opacity', '').css('pointer-events', '');
            }

            $(document).on("click", "#cart-product-remove", function () {
                var action = $(this).data('action');

                jQuery.ajax({
                    type: "DELETE",
                    url: action,
                    dataType: "json",
                    success: function (response) {
                        showCart();
                    },
                    error: function (response) {
                        alert('Ocorreu um erro ao remover o produto');
                    }
                });
            })

            $(document).on("blur", ".input-change-profile", function () {
    var input = $(this);
    var action = input.data('action');
    var value = input.val();
    var container = input.closest('td'); // Pega o container da linha atual
    var messageBox = container.find('.show-message');
    var postsContainer = container.find('.list-posts-container');
    var postsGrid = container.find('.list-posts-grid');

    // Limpa estados anteriores
    messageBox.addClass('hidden').html('');
    
    if (value === '') {
        messageBox.removeClass('hidden').html('O campo não pode estar vazio.');
        return false;
    }

    loadShowCart(); // Sua função de loading

    // 1. Validar o Perfil/Usuário
    // Assumindo que você criou uma rota para o método validateUser do seu Controller
    $.post('/api/instagram/validate-user', { 'username': value }, function (response) {
        if (response.success) {
            messageBox.addClass('hidden');
            
            // 2. Se o perfil for válido, listar os posts
            fetchPosts(value, postsContainer, postsGrid, input);
            
            // Salva o valor no banco (sua lógica original)
            $.post(action, { 'profile': value }, function () {
                loadHideCart();
            }, 'json');

        } else {
            loadHideCart();
            messageBox.removeClass('hidden').html(response.message || 'Perfil inválido ou privado.');
            postsContainer.addClass('hidden');
        }
    }, 'json').fail(function () {
        loadHideCart();
        messageBox.removeClass('hidden').html('Erro ao validar perfil.');
    });
});

// Função para buscar e renderizar posts
function fetchPosts(username, container, grid, inputField) {
    grid.html('<div class="col-span-full text-center py-4 text-sm text-gray-500">Carregando posts...</div>');
    container.removeClass('hidden');

    $.post('/api/instagram/list-posts', { 'username': username }, function (response) {
        if (response.success && response.posts.length > 0) {
            grid.empty();
            
            response.posts.forEach(function (post) {
                var postHtml = `
                    <div class="relative aspect-square cursor-pointer hover:opacity-80 transition post-item" 
                         data-url="${post.post_url}">
                        <img src="${post.display_url}" class="w-full h-full object-cover rounded-lg border border-gray-200">
                        ${post.media_type == 2 ? '<span class="absolute top-1 right-1 bg-black/50 text-white p-1 rounded text-[10px]">Vídeo</span>' : ''}
                    </div>
                `;
                grid.append(postHtml);
            });

            // Evento de clique no post
            grid.find('.post-item').on('click', function() {
                var url = $(this).data('url');
                inputField.val(url);
                inputField.trigger('blur'); // Dispara o blur para salvar o link do post
                
                // Opcional: Destacar o post selecionado
                grid.find('.post-item img').removeClass('border-blue-500 border-4');
                $(this).find('img').addClass('border-blue-500 border-4');
            });

        } else {
            grid.html('<div class="col-span-full text-center py-4 text-sm text-red-500">Nenhum post público encontrado.</div>');
        }
    }, 'json');
}

            $(document).on("blur", ".input-change-comment", function () {
                var input = $(this);
                var action = input.data('action');

                if (input.val() === '') {
                    input.next().parent().find('.show-message').removeClass('hidden').html('Comentario vazio.');
                    return false;
                }

                loadShowCart();
                $.post(action, {'comments': input.val()}, function () {
                    loadHideCart();
                    showCart()
                }, 'json').fail(function () {
                    alert('Ocorreu um erro');
                });
            })
        })

        // ===== CORREÇÃO: Aplicar cupom =====
        $('#apply-coupon').click(function () {
            var couponCode = $('#coupon-code').val();

            $.ajax({
                type: "POST",
                url: "{{ route('api.cartProducts.addCoupon', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}",
                data: {coupon: couponCode},
                dataType: "json",
                success: function (response) {
                    $('#coupon-message').removeClass('hidden');
                    $('#discountCoupon').html('<span>Desconto (Cupom)</span> R$ ' + response.discount);
                    $('.cart-total-price').html('<span>Total</span> R$ ' + response.total);
                },
                error: function (response) {
                    $('#coupon-message').addClass('hidden');
                    $.each(response.responseJSON.errors, function (index, value) {
                        alert(value);
                    });
                }
            });
        })
    </script>
    <script>
        // Copy
        $('#pixPaymentCopy').click(function () {
            navigator.clipboard.writeText($('#pixPaymentCode').val());
            $('.message').removeClass('hidden');

            setTimeout(function () {
                $('.message').addClass('hidden');
            }, 3000);
        });

        $(function () {
            $('.pix-body').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                var inputs = document.querySelectorAll('.input-change-profile');
                var inputsComment = document.querySelectorAll('.input-change-comment');
                var isEmpty = false;
                var isEmptyComment = false;

                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].value.trim() === '') {
                        firstEmptyInput = inputs[i];
                        isEmpty = true;
                        break;
                    }
                }

                for (var i = 0; i < inputsComment.length; i++) {
                    if (inputsComment[i].value.trim() === '') {
                        firstEmptyInputComment = inputsComment[i];
                        isEmptyComment = true;
                        break;
                    }
                }

                if (isEmpty) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Insira um Usuário ou Link do Post',
                        icon: 'warning',
                        confirmButtonText: 'Confirmar',
                    }).then(function () {
                        setTimeout(function () {
                            $('html, body').animate({scrollTop: $(firstEmptyInput).offset().top - 200}, 500);
                            firstEmptyInput.focus();
                        }, 500);
                    });
                    return false;
                }

                if (isEmptyComment) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Digite seu comentário',
                        icon: 'warning',
                        confirmButtonText: 'Confirmar',
                    }).then(function () {
                        setTimeout(function () {
                            $('html, body').animate({scrollTop: $(firstEmptyInputComment).offset().top - 200}, 500);
                            firstEmptyInputComment.focus();
                        }, 500);
                    });
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.purchases.store', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}",
                    data: data,
                    dataType: "json",
                    beforeSend: function () {
                        form.find('button').prop('disabled', true);
                    },
                    success: function (response) {
                        // ===== CORREÇÃO: Remover classe hidden corretamente =====
                        $('.pix-generate-body').removeClass('hidden');

                        $('#pixPaymentCode').val(response.qr_code);
                        $('#pixPaymentImage').attr('src', 'data:image/png;base64, ' + response.qr_code_base64);

                        // Scroll suave até o QR Code
                        $('html, body').animate({
                            scrollTop: $('.pix-generate-body').offset().top - 100
                        }, 500);

                        verifyPayment('{{ route('api.purchases.status') }}?id=' + response.id)
                    },
                    error: function (response) {
                        form.find('.alert').html('');
                        $.each(response.responseJSON.errors, function (index, value) {
                            form.find('.alert').removeClass('hidden').append(value + '<br>');
                        });
                    },
                    complete: function () {
                        form.find('button').prop('disabled', false);
                    }
                });
            });
        });

        // Verify Payment
        function verifyPayment(action) {
            var count = 0

            setInterval(function () {
                $.get(action, function (response) {
                    if (response['status'] == "approved" && count == 0) {
                        gtag('event', 'conversion', {
                            'send_to': response['code_event_ads'],
                            'value': response['price'],
                            'currency': 'BRL',
                            'transaction_id': response['id']
                        });

                        Swal.fire({
                            title: 'Pagamento confirmado!',
                            text: 'Seu pedido será enviado, muito obrigado(a) pela confiança',
                            icon: 'success',
                            confirmButtonText: 'Confirmar',
                        }).then(function () {
                            window.location.reload()
                        });

                        count++
                    }
                })
            }, 3000)
        }

        // ===== CORREÇÃO: Toggle do cupom =====
        $('#possui-cupom').change(function (){
            if ($(this).is(':checked')) {
                $('#discountCupom').removeClass('hidden');
            } else {
                $('#discountCupom').addClass('hidden');
            }
        })
    </script>
</body>
</html>