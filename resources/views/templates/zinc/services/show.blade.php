@extends('templates.zinc.templates.master')
@section('content')
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
        }

        .product-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 85px !important;
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .product-ref {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 0.5rem;
        }

        .payment-btn {
            background-color: #00C853;
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(0, 200, 83, 0.2);
        }

        .payment-btn:hover {
            background-color: #00B046;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 200, 83, 0.3);
        }

        .payment-btn:active {
            transform: translateY(0);
        }

        .cart-btn {
            background-color: #fff;
            color: #333;
            border: 2px solid #333;
            padding: 15px;
            font-weight: 600;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .cart-btn:hover {
            background-color: #333;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .cart-btn:active {
            transform: translateY(0);
        }

        .buttons-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Quantity selector styling */
        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            max-width: 350px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: #f0f0f0;
            color: #333;
            font-size: 1.2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-display {
            flex: 1;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 500;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 0 15px;
            width: 100px;
        }

        .quantity-presets {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .preset-btn {
            padding: 8px 15px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .preset-btn:hover {
            background-color: #e0e0e0;
        }

        .preset-btn.active {
            background-color: #333;
            color: white;
            border-color: #333;
        }

        .product-image {
            width: 100%;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .product-image:hover {
            transform: scale(1.02);
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .quantity-hint {
            color: #666;
            font-size: 0.85rem;
            margin-top: 5px;
            font-style: italic;
        }

        /* Cart Icon */
        .cart-icon {
            width: 20px;
            height: 20px;
            position: relative;
        }

        /* Success animation */
        @keyframes success-pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-success-animation {
            animation: success-pulse 0.5s ease-in-out;
        }

        /* Customer Info Modal Styles */
        .customer-modal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .customer-modal .modal-header {
            border-bottom: none;
            padding: 20px 25px 0;
        }

        .customer-modal .modal-body {
            padding: 20px 25px;
        }

        .customer-modal .modal-footer {
            border-top: none;
            padding: 0 25px 20px;
            justify-content: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #00C853;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 200, 83, 0.1);
        }

        .submit-btn {
            background-color: #00C853;
            color: white;
            border: none;
            padding: 12px 20px;
            font-weight: 600;
            width: 100%;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .submit-btn:hover {
            background-color: #00B046;
        }

        /* PIX Modal Styles */
        .pix-modal .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .pix-modal .modal-header {
            border-bottom: none;
            padding: 20px 25px 0;
        }

        .pix-modal .modal-body {
            padding: 20px 25px;
            text-align: center;
        }

        .pix-modal .modal-footer {
            border-top: none;
            padding: 0 25px 20px;
            justify-content: center;
        }

        .pix-qrcode-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 25px;
            margin: 15px 0;
            position: relative;
        }

        .pix-qrcode {
            width: 200px;
            height: 200px;
            margin: 0 auto;
        }

        .pix-copy-btn {
            background-color: #333;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 15px;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .pix-copy-btn:hover {
            background-color: #555;
        }

        .pix-code {
            font-family: monospace;
            font-size: 0.9rem;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 6px;
            margin: 15px 0;
            word-break: break-all;
            text-align: left;
        }

        .pix-amount {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 15px 0;
            color: #222;
        }

        .pix-instructions {
            color: #666;
            font-size: 0.9rem;
            margin: 15px 0;
        }

        .pix-status {
            padding: 8px 16px;
            background-color: #ffd54f;
            color: #333;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin: 10px 0;
        }

        .pix-verification-timer {
            color: #666;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .product-container {
                padding: 20px;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .product-price {
                font-size: 1.6rem;
            }

            .buttons-container {
                grid-template-columns: 1fr;
            }

            .pix-qrcode {
                width: 180px;
                height: 180px;
            }
        }
    </style>

    <div class="container product-container">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-4 mb-4">
                <div class="image-container">
                    <img src="https://freelaweb.com.br/wp-content/uploads/2023/04/Screenshot_11-465x405.png"
                         class="product-image">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-8">
                <h1 class="product-title">{{ $service->name }}</h1>
                <p class="product-ref">Ref: CYO540</p>

                <p class="product-price">R$ {{ number_format($service->price, 2, ',', '.') }}</p>

                <!-- Quantity Selector -->
                <h3 class="section-title p-0 text-primary">Quantidade</h3>

                <div class="quantity-selector">
                    <button class="quantity-btn" id="decrease">-</button>
                    <input type="number" class="quantity-display" id="quantity" name="quantity" min="100"
                           value="{{ request()->quantity ?? 100 }}">
                    <button class="quantity-btn" id="increase">+</button>
                </div>
                <p class="quantity-hint">Escolha qualquer quantidade a partir de 100 unidades</p>

                <!-- Buttons Container -->
                <div class="buttons-container">
                    <button class="payment-btn" id="payNowBtn">PAGAR AGORA</button>
                    <button class="cart-btn addCart" id="addToCart" data-action="{{ route('api.systemSettings.addCart', ['domain' => $user->domain, 'service' => $service, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}">
                        <svg class="cart-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        ADICIONAR
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Info Modal -->
    <div class="modal fade customer-modal" id="customerInfoModal" tabindex="-1" aria-labelledby="customerInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerInfoModalLabel">Informações para pagamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customerInfoForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customerLink" class="form-label">Link</label>
                            <input type="text" class="form-control" id="customerLink" name="link" required>
                        </div>

                        <div class="form-group">
                            <label for="customerName" class="form-label">Nome completo</label>
                            <input type="text" class="form-control" id="customerName" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="customerWhatsapp" class="form-label">WhatsApp</label>
                            <input type="tel" class="form-control" id="customerWhatsapp" name="whatsapp" required>
                        </div>

                        <div class="form-group">
                            <label for="customerEmail" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="customerEmail" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="submit-btn" id="submitCustomerInfo">
                            GERAR PIX
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PIX Payment Modal -->
    <div class="modal fade pix-modal" id="pixPaymentModal" tabindex="-1" aria-labelledby="pixPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pixPaymentModalLabel">Pagamento via PIX</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pix-status">Aguardando pagamento</div>

                    <div class="pix-instructions">
                        Escaneie o QR Code abaixo com o aplicativo do seu banco ou copie o código PIX
                    </div>

                    <div class="pix-qrcode-container">
                        <img src="/api/placeholder/200/200" alt="QR Code PIX" class="pix-qrcode" id="pixQrCode">
                    </div>

                    <div class="pix-code" id="pixCodeText">
                        00020126580014BR.GOV.BCB.PIX0136123e4567-e89b-12d3-a456-426655440000...
                    </div>

                    <button class="pix-copy-btn" id="pixCopyBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        Copiar código PIX
                    </button>

                    <div class="pix-verification-timer" id="pixVerificationTimer">
                        Verificando pagamento... (60s)
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const quantityInput = document.getElementById('quantity');
                const decreaseBtn = document.getElementById('decrease');
                const increaseBtn = document.getElementById('increase');
                const presetBtns = document.querySelectorAll('.preset-btn');
                const pixCopyBtn = document.getElementById('pixCopyBtn');

                // Initialize modals
                const customerModal = new bootstrap.Modal(document.getElementById('customerInfoModal'));
                const pixModal = new bootstrap.Modal(document.getElementById('pixPaymentModal'));

                // Add event listeners for the + and - buttons
                decreaseBtn.addEventListener('click', function () {
                    let currentValue = parseInt(quantityInput.value);
                    if (currentValue > 100) {
                        quantityInput.value = currentValue - 10;
                        updateActivePreset();
                    }
                });

                increaseBtn.addEventListener('click', function () {
                    let currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 10;
                    updateActivePreset();
                });

                // Add event listeners for preset buttons
                presetBtns.forEach(btn => {
                    btn.addEventListener('click', function () {
                        quantityInput.value = this.dataset.value;
                        updateActivePreset();
                    });
                });

                // Update active preset when input changes
                quantityInput.addEventListener('input', updateActivePreset);

                // Initial update
                updateActivePreset();

                function updateActivePreset() {
                    let currentValue = parseInt(quantityInput.value);

                    // Remove active class from all presets
                    presetBtns.forEach(btn => {
                        btn.classList.remove('active');

                        // Add active class to matching preset
                        if (parseInt(btn.dataset.value) === currentValue) {
                            btn.classList.add('active');
                        }
                    });

                    // Validate minimum quantity
                    if (currentValue < 100) {
                        quantityInput.value = 100;
                    }
                }

                // Copy PIX code to clipboard
                pixCopyBtn.addEventListener('click', function() {
                    const pixCode = document.getElementById('pixCodeText').innerText;
                    navigator.clipboard.writeText(pixCode).then(() => {
                        // Change button text temporarily
                        const originalText = pixCopyBtn.innerHTML;
                        pixCopyBtn.innerHTML = `
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Código copiado!
                        `;

                        setTimeout(() => {
                            pixCopyBtn.innerHTML = originalText;
                        }, 2000);
                    });
                });

                // Pay Now button click handler - opens customer info modal
                $('#payNowBtn').click(function (e) {
                    e.preventDefault();
                    customerModal.show();
                });

                // Customer info form submission
                $('#customerInfoForm').submit(function(e) {
                    e.preventDefault();

                    // Disable submit button
                    $('#submitCustomerInfo').attr('disabled', true).text('Processando...');

                    // Get form data
                    const formData = {
                        link: $('#customerLink').val(),
                        name: $('#customerName').val(),
                        whatsapp: $('#customerWhatsapp').val(),
                        email: $('#customerEmail').val(),
                        quantity: $('#quantity').val(),
                        type: 'pix_direct',
                        service: '{{ request()->service }}',
                        _token: "{{ csrf_token() }}",
                    };


                    // Make the AJAX request to generate PIX data
                    $.ajax({
                        url: "{{ route('api.purchases.store', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}", // Your endpoint to generate PIX
                        method: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // Enable the button again
                            $('#submitCustomerInfo').attr('disabled', false).text('GERAR PIX');

                            // Check if response is successful
                            if (response.success) {

                                // Update PIX code and QR code
                                $('#pixCodeText').text(response.qr_code || $('#pixCodeText').text());

                                // If there's a QR code image URL in the response
                                if (response.qr_code_base64) {
                                    $('#pixQrCode').attr('src', 'data:image/png;base64, ' + response.qr_code_base64);
                                }

                                // Close customer modal and open PIX modal
                                customerModal.hide();
                                pixModal.show();
                            } else {
                                // Show error message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: response.message || 'Não foi possível gerar o PIX. Tente novamente.',
                                });
                            }
                        },
                        error: function() {
                            $('#submitCustomerInfo').attr('disabled', false).text('GERAR PIX');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Não foi possível processar sua solicitação. Tente novamente mais tarde.',
                            });
                        }
                    });
                });
            });

            $('.addCart').click(function (e) {
                e.preventDefault()
                $(this).attr('disabled', true)

                var badge_qtd = $('.badge-qtd').html()
                $('.badge-qtd').html(parseInt(badge_qtd) + 1)
                Swal.fire({
                    icon: 'success',
                    title: 'Adicionado ao carrinho',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Ir para o carrinho <i class="fa fa-shopping-cart"></i>',
                    confirmButtonColor: "{{ $systemSetting->primary_color ?? '' }}",
                    cancelButtonText: 'Continuar comprando',
                }).then(function (response) {
                    if (response.isConfirmed) {
                        window.location.href = "{{ route('api.cartProducts.index', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}";
                    }
                });

                var action = $(this).data('action')
                $.post(action, function (response) {
                    $('.addCart').attr('disabled', false)
                }, 'json')
            })
        </script>
    @endpush
@endsection
