@extends('templates.modern.templates.master')
@section('content')
    @php
        if (empty($_SERVER['HTTPS'])){
            header("location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        }
    @endphp
    <link rel="stylesheet" type="text/css" href="https://ev.braip.com/css/checkout.css?id=d6820ec9bcc88a23ba10">
    <link href="https://ev.braip.com/css/intlTelInput.min.css?v=1696005736" rel="stylesheet">

    <!-- Alert Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-6">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-md p-6 space-y-3">
                <div class="flex items-start space-x-3">
                    <span class="text-green-500 text-xl flex-shrink-0">✅</span>
                    <p class="text-gray-700">Para seguidores e visualizações no story, use o nome de usuário ou o link do perfil.</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="text-green-500 text-xl flex-shrink-0">✅</span>
                    <p class="text-gray-700">Para curtidas, visualizações e comentários, use o link do post.</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="text-red-500 text-xl flex-shrink-0">🚫</span>
                    <p class="text-gray-700">O perfil não pode estar privado, nem com restrição de idade ou país.</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="text-red-500 text-xl flex-shrink-0">🚫</span>
                    <p class="text-gray-700">Nunca faça dois pedidos da mesma função da rede social para o mesmo link ao mesmo tempo.</p>
                </div>
            </div>

            <div id="show-cart" class="mt-6"></div>
        </div>
    </div>

    <!-- Main Form Section -->
    <section class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <form class="pix-body" method="post" action="">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- Personal Data Section -->
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center space-x-3">
                                <span class="bg-white text-blue-600 font-bold w-8 h-8 rounded-full flex items-center justify-center text-lg">1</span>
                                <h6 class="text-white font-bold text-lg">DADOS PESSOAIS</h6>
                            </div>

                            <!-- Form Content -->
                            <div class="p-6 space-y-4">
                                <div class="alert alert-danger hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg"></div>

                                <input type="hidden" name="type" value="pix">

                                <!-- Name Field -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">NOME</label>
                                    <input type="text"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                           name="name"
                                           id="name"
                                           placeholder="Seu nome">
                                </div>

                                <!-- WhatsApp Field -->
                                <div>
                                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">WHATSAPP</label>
                                    <input type="text"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                           name="whatsapp"
                                           id="whatsapp"
                                           placeholder="(00) 0000-0000">
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">EMAIL</label>
                                    <input type="text"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                           name="email"
                                           id="email"
                                           placeholder="seuemail@mail.com">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Data Section -->
                    <div class="lg:col-span-7">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center space-x-3">
                                <span class="bg-white text-green-600 font-bold w-8 h-8 rounded-full flex items-center justify-center text-lg">2</span>
                                <h6 class="text-white font-bold text-lg">DADOS DE PAGAMENTO</h6>
                            </div>

                            <div class="p-6 space-y-6">
                                <!-- Coupon Section -->
                                <div class="border-b border-gray-200 pb-6">
                                    <h5 class="font-bold text-gray-800 mb-4">POSSUI CUPOM DE DESCONTO?</h5>

                                    <!-- Coupon Input (Hidden by default) -->
                                    <div class="hidden mb-4" id="discountCupom">
                                        <div class="flex gap-2">
                                            <input type="text"
                                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   id="coupon-code"
                                                   name="coupon"
                                                   placeholder="Digite seu cupom">
                                            <button class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200"
                                                    type="button"
                                                    id="apply-coupon">
                                                Aplicar
                                            </button>
                                        </div>
                                        <div class="mt-2 hidden" id="coupon-message">
                                            <small class="text-green-600 font-medium">✓ Cupom aplicado com sucesso!</small>
                                        </div>
                                    </div>

                                    <!-- Checkbox -->
                                    <div id="ativa_cupom">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox"
                                                   id="possui-cupom"
                                                   value="cupom"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="text-gray-700">Sim, tenho um cupom.</span>
                                        </label>
                                    </div>
                                    <span class="hidden text-red-600 text-sm mt-2" id="cupom-error"></span>
                                </div>

                                <!-- Payment Method -->
                                <div class="border-b border-gray-200 pb-6">
                                    <h5 class="font-bold text-gray-800 mb-2">PAGAR COM:</h5>
                                    <p class="text-gray-600 text-sm mb-4">Escolha qual método de pagamento você prefere usar.</p>

                                    <button class="inline-flex items-center space-x-3 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-bold px-6 py-3 rounded-lg transition duration-200 shadow-md"
                                            type="button"
                                            id="pagarcom-pix">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                        <span>Pix</span>
                                    </button>
                                </div>

                                <span class="hidden text-yellow-700 bg-yellow-50 px-4 py-2 rounded-lg" id="total_descontos"></span>

                                <!-- PIX Payment Section -->
                                <div id="pagamento-pix">
                                    <!-- Cart Total -->
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6 mb-6">
                                        @if(isset($serviceDescount))
                                            <div class="space-y-2">
                                                <p class="flex justify-between text-gray-500 line-through">
                                                    <span>Valor</span>
                                                    <span>R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                                </p>
                                                <p class="flex justify-between text-green-600 font-medium">
                                                    <span>Desconto</span>
                                                    <span>R$ {{ number_format($sumProducts - $pricePercent, 2, ',', '.') }}</span>
                                                </p>
                                                <div class="border-t border-gray-300 pt-2 mt-2">
                                                    <p class="flex justify-between text-xl font-bold text-gray-800">
                                                        <span>Total</span>
                                                        <span class="text-green-600">R$ {{ number_format($pricePercent, 2, ',', '.') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <p class="flex justify-between text-xl font-bold text-gray-800">
                                                <span>Total</span>
                                                <span class="text-blue-600">R$ {{ number_format($sumProducts, 2, ',', '.') }}</span>
                                            </p>
                                        @endif
                                    </div>

                                    <!-- PIX QR Code Section -->
                                    <div class="pix-generate-body hidden">
                                        <div class="bg-white border-2 border-dashed border-gray-300 rounded-lg p-6 text-center space-y-4">
                                            <h5 class="font-bold text-gray-800 mb-4">Escaneie o QR Code para pagar</h5>
                                            <img alt="QR Code PIX"
                                                 class="mx-auto rounded-lg shadow-md"
                                                 id="pixPaymentImage"
                                                 src=""
                                                 style="width: 250px;">

                                            <div class="text-left">
                                                <label for="pixPaymentCode" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Ou copie o código PIX
                                                </label>
                                                <textarea id="pixPaymentCode"
                                                          readonly
                                                          class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm font-mono resize-none"
                                                          rows="3"></textarea>
                                            </div>

                                            <button type="button"
                                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 shadow-md"
                                                    id="pixPaymentCopy">
                                                📋 Copiar Código PIX
                                            </button>
                                            <p class="message hidden text-green-600 font-medium">✓ Copiado com sucesso!</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Credit Card Section (Hidden) -->
                                <div class="hidden" id="pagamento-cartao" data-cartao="credito">
                                    <h5 class="font-bold text-gray-800 mb-4">DADOS DO CARTÃO</h5>

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
                                    <fieldset class="border border-gray-200 rounded-lg p-4 mb-6">
                                        <legend class="text-xs font-bold text-gray-700 px-2">Bandeiras aceitas</legend>
                                        <div class="flex flex-wrap gap-2 justify-center">
                                            <img src="https://media.braip.com/public/card-flag/visa.png" alt="Visa" title="Visa" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/master-card.png" alt="Master Card" title="Master Card" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/hiper-card.png" alt="Hipercard" title="Hipercard" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/american-express.png" alt="American Express" title="American Express" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/diners.png" alt="Diners Club" title="Diners Club" class="h-8">
                                            <img src="https://media.braip.com/public/card-flag/elo.png" alt="Elo" title="Elo" class="h-8">
                                        </div>
                                    </fieldset>

                                    <!-- Card Number -->
                                    <div class="mb-4">
                                        <label for="cardNumber" class="block text-sm font-medium text-gray-700 mb-2">NÚMERO DO CARTÃO</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                <i class="far fa-credit-card"></i>
                                            </span>
                                            <input type="tel"
                                                   autocomplete="cc-number"
                                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   placeholder="Digite somente números do cartão"
                                                   name="credito_numero_cartao"
                                                   data-cartao="credito"
                                                   data-name="numero_cartao"
                                                   data-iugu="number"
                                                   data-encrypted-name="number"
                                                   data-checkout="cardNumber"
                                                   onselectstart="return false"
                                                   oncopy="return false"
                                                   oncut="return false"
                                                   ondrag="return false"
                                                   ondrop="return false">
                                        </div>
                                        <span class="hidden text-red-600 text-sm mt-1" id="credito_numero_cartao-error">Informe um número válido</span>
                                        <span class="hidden text-red-600 text-sm mt-1 number-cards-duplicate">Os números de cartões não podem ser iguais.</span>
                                    </div>

                                    <!-- Cardholder Name -->
                                    <div class="mb-4">
                                        <label for="cc-name" class="block text-sm font-medium text-gray-700 mb-2">NOME DO TITULAR</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                <i class="far fa-user"></i>
                                            </span>
                                            <input type="text"
                                                   autocomplete="cc-name"
                                                   data-cartao="credito"
                                                   name="credito_full_name"
                                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   data-checkout="cardholderName"
                                                   data-iugu="full_name"
                                                   placeholder="Digite o nome completo impresso no cartão"
                                                   data-name="full_name"
                                                   data-encrypted-name="holderName"
                                                   maxlength="255">
                                        </div>
                                        <span class="hidden text-red-600 text-sm mt-1" id="credito_full_name-error">Informe um nome válido</span>
                                    </div>

                                    <!-- Expiry and CVC -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                        <!-- Expiry Date -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">VALIDADE</label>
                                            <div class="flex gap-2">
                                                <input type="text"
                                                       maxlength="2"
                                                       name="credito_mes"
                                                       class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       autocomplete="cc-exp-month"
                                                       data-cartao="credito"
                                                       data-encrypted-name="expiryMonth"
                                                       placeholder="MM"
                                                       data-name="mes"
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
                                                       class="w-1/2 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       data-cartao="credito"
                                                       placeholder="AA"
                                                       data-name="ano_exibido"
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
                                                       placeholder="Ano"
                                                       data-encrypted-name="expiryYear"
                                                       data-checkout="cardExpirationYear"
                                                       value="20">
                                            </div>
                                            <span class="hidden text-red-600 text-sm mt-1" id="credito_data-validade-error">Informe uma data de validade válida.</span>
                                        </div>

                                        <!-- CVC -->
                                        <div>
                                            <label for="cvc" class="block text-sm font-medium text-gray-700 mb-2">CVC</label>
                                            <div class="relative">
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                       name="credito_cvc"
                                                       placeholder="CVC"
                                                       autocomplete="cc-csc"
                                                       type="number"
                                                       data-cartao="credito"
                                                       data-name="codigo_seguranca"
                                                       data-iugu="verification_value"
                                                       data-encrypted-name="cvc"
                                                       data-checkout="securityCode"
                                                       onselectstart="return false"
                                                       onpaste="return false"
                                                       oncopy="return false"
                                                       oncut="return false"
                                                       ondrag="return false"
                                                       ondrop="return false">
                                                <input type="hidden"
                                                       value="2023-09-30T10:51:52-03:00"
                                                       data-encrypted-name="generationtime">
                                            </div>
                                            <span class="hidden text-red-600 text-sm mt-1" id="credito_codigo_seguranca-error">Informe um código de segurança válido</span>
                                        </div>
                                    </div>

                                    <!-- Installments -->
                                    <div class="mb-4" id="parcelamento_cartao">
                                        <label for="parcelamento" class="block text-sm font-medium text-gray-700 mb-2">PARCELAMENTO DO CARTÃO</label>
                                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                data-cartao="credito"
                                                data-name="parcelamento">
                                            <option data-vlr-parcela-original="0"
                                                    data-vlr-parcelado-sem-desconto="2500.00"
                                                    data-vlr-parcelado="2500.00"
                                                    data-valor_total="2500"
                                                    data-vlr-parcela="2500"
                                                    data-vlr-parcela-sem-desconto="2500"
                                                    selected="selected"
                                                    value="1">1x de R$ 25,00</option>
                                            <option data-vlr-parcela-original="0.00"
                                                    data-vlr-parcelado-sem-desconto="1306.00"
                                                    data-vlr-parcelado="1306.00"
                                                    data-valor_total="2500"
                                                    data-vlr-parcela="1306"
                                                    data-vlr-parcela-sem-desconto="1306"
                                                    value="2">2x de R$ 13,06</option>
                                            <option data-vlr-parcela-original="0.00"
                                                    data-vlr-parcelado-sem-desconto="884.00"
                                                    data-vlr-parcelado="884.00"
                                                    data-valor_total="2500"
                                                    data-vlr-parcela="884"
                                                    data-vlr-parcela-sem-desconto="884"
                                                    value="3">3x de R$ 8,84</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="border-t border-gray-200 pt-6">
                                    <button class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold text-lg py-4 px-8 rounded-lg transition duration-200 shadow-lg transform hover:scale-105"
                                            id="submit"
                                            type="submit">
                                        🛒 COMPRAR AGORA
                                    </button>

                                    <p class="text-center text-gray-600 text-sm mt-4 flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Ambiente criptografado e 100% seguro.</span>
                                    </p>

                                    <div class="flex justify-center mt-4">
                                        <a href="" target="_blank" rel="noopener noreferrer">
                                            <img src="https://ev.braip.com/img/checkout/compra-segura.png"
                                                 alt="SecurityMetrics Credit Card Safe"
                                                 class="h-16 object-contain opacity-75 hover:opacity-100 transition duration-200">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

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

        $('#apply-coupon').click(function () {
            var couponCode = $('#coupon-code').val();

            $.ajax({
                type: "POST",
                url: "{{ route('api.cartProducts.addCoupon', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}",
                data: {coupon: couponCode},
                dataType: "json",
                success: function (response) {
                    $('#coupon-message').removeClass('d-none');
                    $('#discountCoupon').html('<span>Desconto (Cupom)</span> R$ ' + response.discount);
                    $('.cart-total-price').html('<span>Total</span> R$ ' + response.total);
                },
                error: function (response) {
                    $('#coupon-message').addClass('d-none');
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
            $('.message').removeClass('d-none');

            setTimeout(function () {
                $('.message').addClass('d-none');
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
                        $('.pix-generate-body').removeClass('d-none')

                        $('#pixPaymentCode').val(response.qr_code);
                        $('#pixPaymentImage').attr('src', 'data:image/png;base64, ' + response.qr_code_base64);

                        verifyPayment('{{ route('api.purchases.status') }}?id=' + response.id)
                    },
                    error: function (response) {
                        form.find('.alert').html('');
                        $.each(response.responseJSON.errors, function (index, value) {
                            form.find('.alert').removeClass('d-none').append(value + '<br>');
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

        $('#possui-cupom').change(function (){
            if ($(this).is(':checked')) {
                $('#discountCupom').removeClass('d-none')
            } else {
                $('#discountCupom').addClass('d-none')
            }
        })
    </script>
@endpush
