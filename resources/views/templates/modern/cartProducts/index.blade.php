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
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_google_ads }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8fafc;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
        }

        .smooth-transition {
            transition: all 0.2s ease;
        }
    </style>
</head>
<body>

    <!-- BOTÃO WHATSAPP FLUTUANTE -->
    <a href="https://wa.me/55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}"
       target="_blank"
       class="fixed bottom-5 right-5 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center text-3xl shadow-lg z-50 smooth-transition">
        <i class="fab fa-whatsapp"></i>
    </a>

    @php
        if (empty($_SERVER['HTTPS'])){
            header("location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        }
    @endphp

    <!-- Instructions -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                    <span class="text-xl">✅</span>
                    <p class="text-sm text-gray-700">Para seguidores e visualizações no story, use o nome de usuário ou link do perfil.</p>
                </div>
                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg">
                    <span class="text-xl">✅</span>
                    <p class="text-sm text-gray-700">Para curtidas, visualizações e comentários, use o link do post.</p>
                </div>
                <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                    <span class="text-xl">🚫</span>
                    <p class="text-sm text-gray-700">O perfil não pode estar privado, nem com restrição de idade ou país.</p>
                </div>
                <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg">
                    <span class="text-xl">🚫</span>
                    <p class="text-sm text-gray-700">Nunca faça dois pedidos da mesma função para o mesmo link simultaneamente.</p>
                </div>
            </div>

            <div id="show-cart" class="mt-6"></div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="py-8 md:py-12">
        <div class="container mx-auto px-4">
            <form class="pix-body" method="post" action="">
                <div class="grid lg:grid-cols-3 gap-6">

                    <!-- Personal Data -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border overflow-hidden sticky top-4">
                            <div class="bg-blue-600 px-5 py-4">
                                <h3 class="text-white font-semibold text-lg">Dados Pessoais</h3>
                            </div>

                            <div class="p-5 space-y-4">
                                <div class="alert alert-danger hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-3 text-sm rounded"></div>

                                <input type="hidden" name="type" value="pix">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome Completo</label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none smooth-transition text-sm"
                                           placeholder="Digite seu nome">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp</label>
                                    <input type="text"
                                           name="whatsapp"
                                           id="whatsapp"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none smooth-transition text-sm"
                                           placeholder="(00) 00000-0000">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none smooth-transition text-sm"
                                           placeholder="seu@email.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Data -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
                            <div class="bg-green-600 px-5 py-4">
                                <h3 class="text-white font-semibold text-lg">Dados de Pagamento</h3>
                            </div>

                            <div class="p-5 space-y-6">

                                <!-- Coupon -->
                                <div class="pb-6 border-b">
                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox"
                                               id="possui-cupom"
                                               value="cupom"
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                        <span class="text-sm font-medium text-gray-700">Tenho um cupom de desconto</span>
                                    </label>

                                    <div class="hidden mt-3" id="discountCupom">
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   id="coupon-code"
                                                   name="coupon"
                                                   class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                                                   placeholder="Digite o código">
                                            <button type="button"
                                                    id="apply-coupon"
                                                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg smooth-transition">
                                                Aplicar
                                            </button>
                                        </div>
                                        <div class="hidden mt-2" id="coupon-message">
                                            <p class="text-sm text-green-600 font-medium">✓ Cupom aplicado com sucesso!</p>
                                        </div>
                                    </div>
                                    <span class="hidden text-red-600 text-sm mt-2 block" id="cupom-error"></span>
                                </div>

                                <!-- Payment Method -->
                                <div class="pb-6 border-b">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Método de Pagamento</h4>
                                    <button type="button"
                                            id="pagarcom-pix"
                                            class="inline-flex items-center gap-2 px-5 py-3 bg-teal-500 hover:bg-teal-600 text-white font-medium rounded-lg smooth-transition text-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                        </svg>
                                        Pagar com PIX
                                    </button>
                                </div>

                                <span class="hidden bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-3 rounded text-sm block" id="total_descontos"></span>

                                <!-- Total -->
                                <div id="pagamento-pix">
                                    <div class="bg-gray-50 rounded-lg p-5 border">
                                        @if(isset($serviceDescount))
                                            <div class="space-y-2">
                                                <div class="flex justify-between text-sm text-gray-500">
                                                    <span class="line-through">Valor Original</span>
                                                    <span class="line-through">R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                                </div>
                                                <div class="flex justify-between text-sm text-green-600 font-medium">
                                                    <span>Desconto</span>
                                                    <span>- R$ {{ number_format($sumProducts - $pricePercent, 2, ',', '.') }}</span>
                                                </div>
                                                <div class="border-t pt-2 mt-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-semibold text-gray-800">Total a Pagar</span>
                                                        <span class="text-2xl font-bold text-green-600">R$ {{ number_format($pricePercent, 2, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-gray-800">Total a Pagar</span>
                                                <span class="text-2xl font-bold text-blue-600">R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- PIX QR Code -->
                                    <div class="pix-generate-body hidden mt-6">
                                        <div class="bg-blue-50 border-2 border-dashed border-blue-300 rounded-lg p-6 text-center">
                                            <h5 class="font-semibold text-gray-800 mb-4">Escaneie o QR Code</h5>
                                            <div class="bg-white p-3 rounded-lg inline-block mb-4 shadow-sm">
                                                <img alt="QR Code PIX" id="pixPaymentImage" src="" class="w-56 h-56">
                                            </div>

                                            <div class="text-left mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                                    Ou copie o código PIX:
                                                </label>
                                                <textarea id="pixPaymentCode"
                                                          readonly
                                                          class="w-full px-3 py-2.5 bg-white border border-gray-300 rounded-lg text-xs font-mono resize-none"
                                                          rows="3"></textarea>
                                            </div>

                                            <button type="button"
                                                    id="pixPaymentCopy"
                                                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg smooth-transition text-sm">
                                                📋 Copiar Código
                                            </button>
                                            <p class="message hidden mt-2 text-sm text-green-600 font-medium">✓ Código copiado!</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="pt-6 border-t">
                                    <button type="submit"
                                            id="submit"
                                            class="w-full py-4 bg-green-600 hover:bg-green-700 text-white text-base font-semibold rounded-lg smooth-transition shadow-sm">
                                        🛒 Finalizar Compra
                                    </button>

                                    <p class="text-center text-xs text-gray-500 mt-4 flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Ambiente 100% seguro
                                    </p>

                                    <div class="flex justify-center mt-3">
                                        <img src="https://ev.braip.com/img/checkout/compra-segura.png" alt="Compra Segura" class="h-12 opacity-50">
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

        // Cart
        $(function () {
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
                $('#show-cart').css('opacity', '0.3').css('pointer-events', 'none');
            }

            function loadHideCart() {
                $('#show-cart').css('opacity', '').css('pointer-events', '');
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

                if (input.val() === '') {
                    input.next().parent().find('.show-message').removeClass('d-none').html('Perfil vazio.');
                    return false;
                } else {
                    input.next().parent().find('.show-message').addClass('d-none')
                }

                loadShowCart();
                $.post(action, {'profile': input.val()}, function () {
                    loadHideCart();
                }, 'json').fail(function () {
                    alert('Ocorreu um erro');
                });
            })

            $(document).on("blur", ".input-change-comment", function () {
                var input = $(this);
                var action = input.data('action');

                if (input.val() === '') {
                    input.next().parent().find('.show-message').removeClass('d-none').html('Comentario vazio.');
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

        // Coupon Toggle
        $('#possui-cupom').change(function (){
            if ($(this).is(':checked')) {
                $('#discountCupom').removeClass('hidden')
            } else {
                $('#discountCupom').addClass('hidden')
            }
        })

        // Apply Coupon
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

        // Copy PIX
        $('#pixPaymentCopy').click(function () {
            navigator.clipboard.writeText($('#pixPaymentCode').val());
            $('.message').removeClass('hidden');
            setTimeout(function () {
                $('.message').addClass('hidden');
            }, 3000);
        });

        // Submit Form
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
                        $('.pix-generate-body').removeClass('hidden')
                        $('#pixPaymentCode').val(response.qr_code);
                        $('#pixPaymentImage').attr('src', 'data:image/png;base64, ' + response.qr_code_base64);
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
    </script>
</body>
</html>
