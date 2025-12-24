@extends('templates.zinc.templates.master')
@section('content')
    <header id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h1 class="h1-large">{{ $template['header']['title'] ?? '' }}</h1>
                        <p class="p-large">{!! nl2br(e($template['header']['text'] ?? '')) !!}</p>
                        <a class="btn-solid-lg bg-default-primary border-default-primary color-default-primary-hover"
                           href="#pricing">{{ $template['header']['button_text'] ?? 'Ver Planos' }}</a>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid" src="{{ !empty($template['header']['image'])
                                ? Storage::url($template['header']['image'])
                                : asset('images/header-image.png') }}"
                            alt="alternative">
                    </div>
                </div>
            </div>
        </div>
    </header>

   <div id="services" class="cards-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @foreach($template['services'] as $index => $service)
                        <div class="card">
                            <div class="card-icon {{ ['blue', 'yellow', 'red'][$index % 3] }}"
     style="background: url('{{ !empty($service['image'])
        ? Storage::url($service['image'])
        : asset('images/service-icon.png') }}') center center no-repeat;">
</div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $service['title'] ?? '' }}</h5>
                                <p>{{ $service['text'] ?? '' }}</p>
                                <ul class="list-unstyled li-space-lg">
                                    @foreach($service['descriptions'] ?? [] as $description)
                                        <li class="d-flex">
                                            <i class="fas fa-check"></i>
                                            <div class="flex-grow-1">{{ $description }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="details" class="basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-7">
                    <div class="image-container">
                        <img class="img-fluid"
                            src="{{ (!empty($template['details']['image'] ?? null)
                                    && Storage::exists($template['details']['image']))
                                ? Storage::url($template['details']['image'])
                                : asset('images/about-image.png') }}"
                            alt="alternative">

                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="text-container">
                        <h2>{{ $template['details']['title'] ?? '' }}</h2>
                        <p>{{ $template['details']['text'] ?? '' }}</p>
                        <a href="#pricing"
                           class="btn-solid-reg bg-default-primary border-default-primary color-default-primary-hover">
                            {{ $template['details']['button_text'] ?? 'Saiba Mais' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($categories as $category)
        <div id="pricing" class="cards-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12" id="header{{ $category->id }}">
                        <h2 class="h2-heading"><span
                                style="padding: 20px;border-radius: 60px;border: 2px solid #bd4ca8;width: 100%;display: block">{{ $category->name }}</span>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    @foreach($category->services as $service)
                        <div class="col-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <span>{{ $service->quantity }}</span>
                                    </div>
                                    <div class="card-title">
                                        <span>{{ $service->name }}</span>
                                    </div>
                                    <ul class="list-unstyled li-space-lg mb-4" style="text-align: left">
                                        @foreach($service->showcaseDescriptions() as $description)
                                            <li>✔ {{ $description }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="price">R$ {{ $service->convert_price }}</div>
                                    <button href="" class="add-to-cart-button addCart"
                                            data-action="{{ route('api.systemSettings.addCart', ['domain' => $user->domain, 'service' => $service, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}">
                                        <i class="icon fas fa-shopping-cart"></i>
                                        Adicionar ao carrinho
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <div style="position: fixed; bottom: 0; z-index:999; width:100%;box-shadow: 1px 1px 12px 12px rgba(0, 0, 0, 0.05);">
        <ul class="nav nav-pills nav-fill" style="background-color: #6168ff;">
            <li class="nav-item"></li>
            <li class="nav-item">
                <a class="nav-link text-white"
                   href="{{ route('api.cartProducts.index', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"><i
                        class="fa fa-shopping-cart" style="font-size:30px;"></i> <span
                        class="position-absolute top-0 translate-middle badge rounded-pill bg-danger badge-qtd">
                        {{$cartProductsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item"></li>
        </ul>
    </div>

    <div class="basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-container">
                        <h4>{{ $configTemplate->basic_title ?? config('template.basic_title') }}</h4>
                        <p class="p-large">{{ $configTemplate->basic_description ?? config('template.basic_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contact" class="form-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="h2-heading">{{ $template['contact']['title'] ?? '' }}</h2>
                    <p class="p-heading">{{ $template['contact']['text'] ?? config('template.contact_description') }}</p>
                    <ul class="list-unstyled li-space-lg">
                        <li><i class="fab fa-whatsapp color-default-secondary"></i> &nbsp;<a
                                href="https://api.whatsapp.com/send?phone=55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}">
                                {{ $systemSetting->phone ?? config('template.phone') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Sum Total Comment
        $('#recipient-comment').keyup(function (e) {
            var quantity = $(this).val().trim().split("\n").length;
            var recipientTotal = $('#recipient-total');
            var price = recipientTotal.data('price');

            $('#recipient-quantity').val(quantity);
            recipientTotal.val((quantity * price).toLocaleString('pt-br', {style: 'currency', currency: 'BRL'}));
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
