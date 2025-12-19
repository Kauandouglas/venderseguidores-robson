@extends('templates.modern.templates.master')
@section('content')
    @php
        if (empty($_SERVER['HTTPS'])){
            header("location: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        }
    @endphp
    <link rel="stylesheet" type="text/css" href="https://ev.braip.com/css/checkout.css?id=d6820ec9bcc88a23ba10">
    <link href="https://ev.braip.com/css/intlTelInput.min.css?v=1696005736" rel="stylesheet">

    <div class="cart">
        <div class="container">
            <div class="section-header mt-3">
                <p>✅ Para seguidores e visualizações no story, use o nome de usuário ou o link do perfil.</p>
                <p>✅ Para curtidas, visualizações e comentários, use o link do post.</p>
                <p>🚫 O perfil não pode estar privado, nem com restrição de idade ou país.</p>
                <p>🚫 Nunca faça dois pedidos da mesma função da rede social para o mesmo link ao mesmo tempo.</p>
            </div>

            <div id="show-cart"></div>
        </div>
    </div>

    <section class="container-fluid">
        <div class="container paddingless">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <form class="pix-body" method="post" action="" style="margin-top: 60px">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="painel v2">
                                    <div class="label-painel">
                                        <span class="font-black">1</span>
                                        <h6 class="font-bold marginless paddingless">DADOS PESSOAIS</h6>
                                    </div>
                                    <div class="row" style="margin-top: 24px;">
                                        <div class="alert alert-danger d-none"></div>

                                        <input type="hidden" name="type" value="pix">
                                        <div class="form-group">
                                            <label for="name" class="small text-muted mb-1">NOME</label>
                                            <input type="text" class="form-control form-control-sm" name="name"
                                                   id="name"
                                                   aria-describedby="helpId" placeholder="Seu nome">
                                        </div>
                                        <div class="form-group">
                                            <label for="whatsapp" class="small text-muted mb-1">WHATSAPP</label>
                                            <input type="text" class="form-control form-control-sm" name="whatsapp"
                                                   id="whatsapp" aria-describedby="helpId"
                                                   placeholder="(00) 0000-0000">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="small text-muted mb-1">EMAIL</label>
                                            <input type="text" class="form-control form-control-sm" name="email"
                                                   id="email"
                                                   aria-describedby="helpId" placeholder="seuemail@mail.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="painel v2">
                                    <div class="label-painel">
                                        <span class="font-black">2</span>
                                        <h6 class="font-bold marginless paddingless"> DADOS DE PAGAMENTO </h6>
                                    </div>
                                    <!-- CUPOM DE DESCONTO -->
                                    <div class="row row-forma-pagamento" style="margin-top: 24px;">
                                        <div class="col-md-12">
                                            <h5 class="font-bold">
                                                POSSUI CUPOM DE DESCONTO?
                                            </h5>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <!-- CUPOM DE DESCONTO -->
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group d-none" id="discountCupom">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="coupon-code"
                                                                       name="coupon" placeholder="Digite seu cupom">
                                                                <div class="input-group-append">
                                                                    <button
                                                                        class="btn bg-secondary border-secondary color-default-secondary-hover"
                                                                        type="button" id="apply-coupon"
                                                                        style="color: #fff; padding: 0.375rem 1rem; height: 100%;">
                                                                        Aplicar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 d-none" id="coupon-message">
                                                                <small class="text-success">Cupom aplicado com
                                                                    sucesso!</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="checkbox" id="ativa_cupom">
                                                    <label>
                                                        <input type="checkbox" id="possui-cupom" value="cupom"
                                                               placeholder="INSIRA O CUPOM DE DESCONTO"> Sim, tenho um
                                                        cupom.
                                                    </label>
                                                </div>
                                            </div>
                                            <span class="esconder text-danger" id="cupom-error"></span>
                                        </div>
                                    </div>

                                    <!-- MENU MEIO DE PAGAMENTO -->
                                    <div class="row row-forma-pagamento">
                                        <div class="col-md-12">
                                            <h5 class="font-bold marginless paddingless">
                                                PAGAR COM:
                                            </h5>
                                            <p class="marginless margin-text-select-pagamento">Escolha qual método de
                                                pagamento você prefere usar.</p>
                                            <button class="btn btn-default btn-pagamento active" type="button"
                                                    id="pagarcom-pix">
                                                <i class="pix-icon"></i>
                                                <span>Pix</span>
                                            </button>
                                        </div>
                                    </div>

                                    <span class="aviso-descontos esconder" id="total_descontos"></span>

                                    <div class="pagamento" id="pagamento-pix">
                                        <div class="cart-total">
                                            <div class="base">
                                                @if(isset($serviceDescount))
                                                    <p style="text-decoration: line-through;">
                                                        <span>Valor</span>
                                                        R$ {{ number_format($sumProducts, 2, ',', '.') }}
                                                    </p>
                                                    <p class="text-success">
                                                        <span>Desconto</span>
                                                        R$ {{ number_format($sumProducts - $pricePercent, 2, ',', '.') }}
                                                    </p>
                                                    <b class="cart-total-price">
                                                        <span>Total</span>
                                                        R$ {{ number_format($pricePercent, 2, ',', '.') }}
                                                    </b>
                                                @else
                                                    <b class="cart-total-price">
                                                        <span>Total</span>
                                                        R$ {{ number_format($sumProducts, 2, ',', '.') }}
                                                    </b>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="pix-generate-body d-none">
                                            <div class="text-center">
                                                <img alt="" class="img-responsive center-block m-auto"
                                                     id="pixPaymentImage"
                                                     src="" style="width: 250px;">
                                            </div>
                                            <div>
                                                <label for="pixPaymentCode" class="control-label text-white">Pix
                                                    code</label>
                                                <textarea id="pixPaymentCode" readonly="" class="form-control"
                                                          style="border: none;outline: none;font-size: 15px;font-weight: 400;min-height: 52px;overflow: hidden;padding: 10px 18px;border-radius: 0;margin-bottom: 13px;"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary" id="pixPaymentCopy">
                                                Copiar
                                            </button>
                                            <p class="message d-none text-success">Copiado com sucesso</p>
                                        </div>
                                    </div>

                                    <div class="pagamento d-none" id="pagamento-cartao" data-cartao="credito">
                                        <h5 class="font-bold">
                                            DADOS DO CARTÃO
                                        </h5>
                                        <div class="card-cred" id="credito" data-jp-card-initialized="true">
                                            <div class="jp-card-container">
                                                <div class="jp-card">
                                                    <div class="jp-card-front">
                                                        <div class="jp-card-logo jp-card-elo">
                                                            <div class="e">e</div>
                                                            <div class="l">l</div>
                                                            <div class="o">o</div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-visa">Visa</div>
                                                        <div class="jp-card-logo jp-card-visaelectron">Visa
                                                            <div class="elec">Electron</div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-mastercard">Mastercard</div>
                                                        <div class="jp-card-logo jp-card-maestro">Maestro</div>
                                                        <div class="jp-card-logo jp-card-amex"></div>
                                                        <div class="jp-card-logo jp-card-discover">discover</div>
                                                        <div class="jp-card-logo jp-card-dinersclub"></div>
                                                        <div class="jp-card-logo jp-card-dankort">
                                                            <div class="dk">
                                                                <div class="d"></div>
                                                                <div class="k"></div>
                                                            </div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-jcb">
                                                            <div class="j">J</div>
                                                            <div class="c">C</div>
                                                            <div class="b">B</div>
                                                        </div>
                                                        <div class="jp-card-lower">
                                                            <div class="jp-card-shiny"></div>
                                                            <div class="jp-card-cvc jp-card-display">•••</div>
                                                            <div class="jp-card-number jp-card-display">•••• •••• ••••
                                                                ••••
                                                            </div>
                                                            <div class="jp-card-name jp-card-display">Full Name</div>
                                                            <div class="jp-card-expiry jp-card-display"
                                                                 data-before="month/year" data-after="valid
thru">••/••
                                                            </div>
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

                                        <fieldset class="form-group control-fieldset">
                                            <legend style="font-size: 11.5px;"><b>Bandeiras aceitas</b></legend>
                                            <div class="img_bandeiras">
                                                <img src="https://media.braip.com/public/card-flag/visa.png" alt="Visa"
                                                     title="Visa">
                                                <img src="https://media.braip.com/public/card-flag/master-card.png"
                                                     alt="Master Card" title="Master Card">
                                                <img src="https://media.braip.com/public/card-flag/hiper-card.png"
                                                     alt="Hipercard" title="Hipercard">
                                                <img src="https://media.braip.com/public/card-flag/american-express.png"
                                                     alt="American Express" title="American Express">
                                                <img src="https://media.braip.com/public/card-flag/diners.png"
                                                     alt="Diners Club" title="Diners Club">
                                                <img src="https://media.braip.com/public/card-flag/elo.png" alt="Elo"
                                                     title="Elo">
                                            </div>
                                        </fieldset>
                                        <div class="form-group">
                                            <label for="cardNumber">NÚMERO DO CARTÃO</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i
                                                        class="far fa-credit-card"></i></span>
                                                <input type="tel" autocomplete="cc-number" class="form-control"
                                                       placeholder="Digite somente números do cartão"
                                                       name="credito_numero_cartao" data-cartao="credito"
                                                       data-name="numero_cartao" data-iugu="number"
                                                       data-encrypted-name="number" value="" data-checkout="cardNumber"
                                                       onselectstart="return false" oncopy="return false"
                                                       oncut="return false" ondrag="return false" ondrop="return false">
                                            </div>
                                            <span class="esconder text-danger" id="credito_numero_cartao-error">Informe um número válido</span>
                                            <span class="esconder text-danger number-cards-duplicate">Os números de cartōes não podem ser iguais.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-name">NOME DO TITULAR</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="far fa-user"></i></span>
                                                <input type="text" autocomplete="cc-name" data-cartao="credito"
                                                       name="credito_full_name" class="form-control"
                                                       data-checkout="cardholderName" data-iugu="full_name"
                                                       placeholder="Digite o nome completo impresso no cartão"
                                                       data-name="full_name" data-encrypted-name="holderName"
                                                       maxlength="255" value="">
                                            </div>
                                            <span class="esconder text-danger" id="credito_full_name-error">Informe um nome válido</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="mes" for="mes">VALIDADE</label>
                                                    <div class="expiry-date-group form-group">
                                                        <div class="input-container is-flex">
                                                            <input type="text" maxlength="2" name="credito_mes"
                                                                   class="form-control" autocomplete="cc-exp-month"
                                                                   data-cartao="credito"
                                                                   data-encrypted-name="expiryMonth" placeholder="Mês"
                                                                   data-name="mes" style="margin-right: 10px;"
                                                                   data-checkout="cardExpirationMonth"
                                                                   onselectstart="return false" onpaste="return false"
                                                                   oncopy="return false" oncut="return false"
                                                                   ondrag="return false" ondrop="return false">
                                                            <input type="text" maxlength="2" name="credito_ano"
                                                                   autocomplete="cc-exp-year"
                                                                   class="form-control cartao" data-cartao="credito"
                                                                   placeholder="Ano" data-name="ano_exibido"
                                                                   onselectstart="return false" onpaste="return false"
                                                                   oncopy="return false" oncut="return false"
                                                                   ondrag="return false" ondrop="return false">
                                                            <input type="hidden" data-cartao="credito" data-name="ano"
                                                                   autocomplete="cc-exp" class="form-control cartao"
                                                                   placeholder="Ano" data-encrypted-name="expiryYear"
                                                                   data-checkout="cardExpirationYear"
                                                                   onselectstart="return false" onpaste="return false"
                                                                   oncopy="return false" oncut="return false"
                                                                   ondrag="return false" ondrop="return false"
                                                                   value="20">
                                                        </div>
                                                        <span class="esconder text-danger"
                                                              id="credito_data-validade-error">Informe uma data de validade válida. (mês e ano completo)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="cvc">CVC</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fas fa-lock"></i></span>
                                                        <input class="form-control" name="credito_cvc"
                                                               placeholder="Digite o CVC do cartão"
                                                               autocomplete="cc-csc" type="number" data-cartao="credito"
                                                               data-name="codigo_seguranca"
                                                               data-iugu="verification_value" data-encrypted-name="cvc"
                                                               value="" data-checkout="securityCode"
                                                               onselectstart="return false" onpaste="return false"
                                                               oncopy="return false" oncut="return false"
                                                               ondrag="return false" ondrop="return false">
                                                        <input type="hidden" value="2023-09-30T10:51:52-03:00"
                                                               data-encrypted-name="generationtime">
                                                    </div>
                                                    <span class="esconder text-danger"
                                                          id="credito_codigo_seguranca-error">Informe um código de segurança válido</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="parcelamento_cartao">
                                            <label for="parcelamento">PARCELAMENTO DO CARTÃO</label>
                                            <select class="form-control" data-cartao="credito" data-name="parcelamento">
                                                <option data-vlr-parcela-original="0"
                                                        data-vlr-parcelado-sem-desconto="2500.00"
                                                        data-vlr-parcelado="2500.00" data-valor_total="2500"
                                                        data-vlr-parcela="2500" data-vlr-parcela-sem-desconto="2500"
                                                        selected="selected" value="1">1x de R$&nbsp;25,00
                                                </option>
                                                <option data-vlr-parcela-original="0.00"
                                                        data-vlr-parcelado-sem-desconto="1306.00"
                                                        data-vlr-parcelado="1306.00" data-valor_total="2500"
                                                        data-vlr-parcela="1306" data-vlr-parcela-sem-desconto="1306"
                                                        value="2">2x de R$&nbsp;13,06
                                                </option>
                                                <option data-vlr-parcela-original="0.00"
                                                        data-vlr-parcelado-sem-desconto="884.00"
                                                        data-vlr-parcelado="884.00" data-valor_total="2500"
                                                        data-vlr-parcela="884" data-vlr-parcela-sem-desconto="884"
                                                        value="3">3x de R$&nbsp;8,84
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- BTN FINALIZAR COMPRA -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <hr>
                                            <button class="btn btn-comprar" id="submit" type="submit" value="Pay">
                                                COMPRAR AGORA
                                            </button>

                                            <p class="text-compra-segura">Ambiente criptografado e 100% seguro.</p>
                                            <div class="wrapper-selos">
                                                <a href="" target="_blank" rel="noopener noreferrer">
                                                    <img src="https://ev.braip.com/img/checkout/compra-segura.png"
                                                         alt="SecurityMetrics Credit Card Safe"
                                                         class="lazy img-responsive pci" style="width: 280px;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
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
