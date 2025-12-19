@extends('templates.modern.templates.master')
@section('content')
    {{-- Hero Section - Boom Social Style --}}
    <section class="relative min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 pt-32 pb-20 overflow-hidden">
        {{-- Subtle Background Pattern --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #9333ea 1px, transparent 0); background-size: 32px 32px;"></div>
        </div>

        {{-- Floating Notification Card --}}
        {{-- <div class="absolute top-28 left-8 bg-white rounded-2xl shadow-lg p-4 max-w-xs animate-fade-in-left z-10 hidden lg:flex items-start gap-3">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-900 text-sm">Maria Silva</p>
                <p class="text-gray-600 text-xs">Comprou 500 visualizações para seu Instagram</p>
                <p class="text-gray-400 text-xs mt-1">agora</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div> --}}

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center space-y-10">
                {{-- Limited Time Badge --}}
                <div class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-purple-100 to-pink-100 rounded-full border-2 border-purple-200 animate-pulse-slow">
                    <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-bold text-purple-700">{{ $configTemplate->header_badge ?? 'Oferta Relâmpago • Tempo Limitado' }}</span>
                </div>

                {{-- Main Heading --}}
                <div class="space-y-4">
                    <h1 class="text-5xl lg:text-7xl font-black text-gray-900 leading-tight">
                        {{ $configTemplate->header_title ?? 'Alcance o' }}
                    </h1>
                    <h2 class="text-5xl lg:text-7xl font-black leading-tight">
                        <span class="bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 bg-clip-text text-transparent">
                            {{ $configTemplate->header_subtitle ?? 'Sucesso no Instagram' }}
                        </span>
                    </h2>
                </div>

                {{-- Main Price Card --}}
                <div class="relative max-w-2xl mx-auto">
                    {{-- Discount Badge --}}
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-full font-black text-sm shadow-xl transform rotate-12 z-20">
                        50% OFF
                    </div>

                    {{-- Card --}}
                    <div class="relative bg-white rounded-3xl shadow-2xl border-4 border-transparent bg-gradient-to-br from-purple-200 via-pink-200 to-rose-200 p-1">
                        <div class="bg-white rounded-3xl p-8 lg:p-12 space-y-8">
                            {{-- Features Grid --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 font-medium">100% Seguro e Sigiloso</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 font-medium">Perfis Ativos</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 font-medium">Suporte 24/7</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-700 font-medium">Garantia vitalícia</span>
                                </div>
                            </div>

                            {{-- CTA Button --}}
                            <a href="#pricing" class="block">
                                <button class="group relative w-full bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 text-white font-black text-xl py-6 rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl overflow-hidden">
                                    <span class="relative z-10 flex items-center justify-center gap-3">
                                        GARANTIR MEU PACOTE AGORA
                                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-pink-700 to-rose-700 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </button>
                            </a>

                            {{-- Small Text --}}
                            <p class="text-center text-sm text-gray-500">
                                Oferta por tempo limitado • Últimas vagas disponíveis hoje
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="flex flex-wrap items-center justify-center gap-8 pt-8">
                    <div class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Não Pedimos sua Senha</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">100% Seguro e Sigiloso</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Não Precisa Seguir Ninguém</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section - Card Style --}}
    <section id="services" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900">
                    Nossos <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Serviços</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Escolha o serviço ideal para impulsionar suas redes sociais
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto">
                {{-- Service Card 1 --}}
                <div class="group bg-gradient-to-br from-blue-50 to-cyan-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-blue-100 hover:border-blue-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        {{ $configTemplate->service_title_1 ?? 'Visualizações' }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ $configTemplate->service_sub_title_1 ?? 'Aumente o alcance dos seus vídeos' }}
                    </p>
                    @isset($configTemplate->service_description_1)
                        <ul class="space-y-2">
                            @foreach($configTemplate->serviceDescriptions1() as $description)
                                <li class="flex items-start gap-2 text-sm text-gray-700">
                                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $description }}
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                </div>

                {{-- Service Card 2 --}}
                <div class="group bg-gradient-to-br from-pink-50 to-rose-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-pink-100 hover:border-pink-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        {{ $configTemplate->service_title_2 ?? 'Curtidas' }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ $configTemplate->service_sub_title_2 ?? 'Mais engajamento nas suas publicações' }}
                    </p>
                    @isset($configTemplate->service_description_2)
                        <ul class="space-y-2">
                            @foreach($configTemplate->serviceDescriptions2() as $description)
                                <li class="flex items-start gap-2 text-sm text-gray-700">
                                    <svg class="w-5 h-5 text-pink-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $description }}
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                </div>

                {{-- Service Card 3 --}}
                <div class="group bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        {{ $configTemplate->service_title_3 ?? 'Seguidores' }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ $configTemplate->service_sub_title_3 ?? 'Cresça sua audiência rapidamente' }}
                    </p>
                    @isset($configTemplate->service_description_3)
                        <ul class="space-y-2">
                            @foreach($configTemplate->serviceDescriptions3() as $description)
                                <li class="flex items-start gap-2 text-sm text-gray-700">
                                    <svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $description }}
                                </li>
                            @endforeach
                        </ul>
                    @endisset
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing Section - Clean Card Style --}}
    @foreach($categories as $category)
        <section id="pricing" class="py-20 bg-gradient-to-br from-gray-50 to-purple-50">
            <div class="container mx-auto px-4">
                {{-- Category Title --}}
                <div class="text-center mb-16" id="header{{ $category->id }}">
                    <h2 class="inline-block text-4xl lg:text-5xl font-black text-gray-900 px-8 py-4 bg-white rounded-full shadow-lg border-4 border-purple-200">
                        {{ $category->name }}
                    </h2>
                </div>

                {{-- Products Grid --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
                    @foreach($category->services as $service)
                        <div class="group relative bg-white rounded-3xl p-6 hover:shadow-2xl transition-all duration-300 border-2 border-gray-100 hover:border-purple-300 hover:-translate-y-2">
                            {{-- Popular Badge --}}
                            @if($loop->index === 1)
                                <div class="absolute -top-3 -right-3 bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-1 rounded-full text-xs font-bold shadow-lg">
                                    🔥 POPULAR
                                </div>
                            @endif

                            {{-- Quantity Badge --}}
                            <div class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 font-bold rounded-full text-sm mb-4">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ $service->quantity }}
                            </div>

                            {{-- Service Name --}}
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight">
                                {{ $service->name }}
                            </h3>

                            {{-- Features --}}
                            <ul class="space-y-2 mb-6">
                                @foreach($service->showcaseDescriptions() as $description)
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $description }}
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Price --}}
                            <div class="mb-6">
                                <div class="text-3xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    R$ {{ $service->convert_price }}
                                </div>
                            </div>

                            {{-- Action Button --}}
                            @if($service->dynamic_pricing)
                                <a href="{{ route('web.services.show', ['domain' => $user->domain, 'service' => $service, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}" class="block">
                                    <button class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg">
                                        Comprar Agora
                                    </button>
                                </a>
                            @else
                                <button class="addCart w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold py-3 rounded-xl hover:scale-105 transition-all duration-300 shadow-lg"
                                        data-action="{{ route('api.systemSettings.addCart', ['domain' => $user->domain, 'service' => $service, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}">
                                    Adicionar ao Carrinho
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach

    {{-- About Section --}}
    <section id="details" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    {{-- Images --}}
                    <div class="relative">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ $configTemplate->url_about_image ?? 'https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=800&h=600&fit=crop' }}"
                                 alt="About"
                                 class="w-full h-96 object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=800&h=600&fit=crop'">
                        </div>
                        {{-- Stats Badge --}}
                        <div class="absolute -bottom-6 -right-6 bg-gradient-to-br from-purple-600 to-pink-600 text-white p-6 rounded-3xl shadow-2xl">
                            <div class="text-4xl font-black">50k+</div>
                            <div class="text-sm font-semibold">Clientes Felizes</div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 rounded-full text-purple-700 font-semibold text-sm">
                            Sobre Nós
                        </div>

                        <h2 class="text-4xl lg:text-5xl font-black text-gray-900">
                            {{ $configTemplate->about_title ?? 'Por que nos escolher?' }}
                        </h2>

                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $configTemplate->about_description ?? 'Somos especialistas em impulsionar perfis nas redes sociais com qualidade e segurança garantidas.' }}
                        </p>

                        {{-- Feature List --}}
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">Entrega Rápida</div>
                                    <div class="text-sm text-gray-600">Receba em minutos</div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">100% Seguro</div>
                                    <div class="text-sm text-gray-600">Suas informações protegidas</div>
                                </div>
                            </div>
                        </div>

                        <a href="#pricing" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold rounded-2xl hover:scale-105 transition-all duration-300 shadow-xl">
                            {{ $configTemplate->about_button ?? 'Ver Planos' }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Floating Cart - Bottom Bar Style --}}
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-gradient-to-r from-indigo-900 via-purple-900 to-pink-900 py-4 shadow-2xl">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between max-w-4xl mx-auto">
                <div class="text-white hidden sm:block">
                    <div class="font-bold text-lg">Tem dúvidas?</div>
                    <div class="text-sm text-purple-200">Nossa equipe está pronta para ajudar!</div>
                </div>

                <div class="flex items-center gap-4">
                    {{-- WhatsApp Button --}}
                    <a href="https://api.whatsapp.com/send?phone=55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}"
                       target="_blank"
                       class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl hover:scale-105 transition-all duration-300 shadow-xl">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span class="hidden sm:inline">Falar no WhatsApp</span>
                    </a>

                    {{-- Cart Button --}}
                    <a href="{{ route('api.cartProducts.index', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                       class="relative flex items-center gap-2 px-6 py-3 bg-white text-purple-600 font-bold rounded-xl hover:scale-105 transition-all duration-300 shadow-xl">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        <span class="hidden sm:inline">Carrinho</span>
                        <span class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 bg-gradient-to-r from-red-500 to-pink-600 text-white text-xs font-bold rounded-full animate-pulse badge-qtd">
                            {{$cartProductsCount}}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Section --}}
    <section id="contact" class="py-20 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center space-y-8">
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900">
                    {{ $configTemplate->contact_title ?? 'Entre em Contato' }}
                </h2>
                <p class="text-xl text-gray-600">
                    {{ $configTemplate->contact_description ?? 'Nossa equipe está pronta para ajudar você a alcançar seus objetivos' }}
                </p>

                <a href="https://api.whatsapp.com/send?phone=55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}"
                   target="_blank"
                   class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold text-xl rounded-2xl hover:scale-110 transition-all duration-300 shadow-2xl">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    {{ $systemSetting->phone ?? config('template.phone') }}
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        @keyframes fade-in-left {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in-left {
            animation: fade-in-left 1s ease-out;
        }

        @keyframes pulse-slow {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.9;
                transform: scale(1.02);
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar to match design */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #9333ea, #ec4899);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #7e22ce, #db2777);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Add to Cart
        $('.addCart').click(function (e) {
            e.preventDefault()
            $(this).attr('disabled', true)

            var badge_qtd = $('.badge-qtd').html()
            $('.badge-qtd').html(parseInt(badge_qtd) + 1)
            
            Swal.fire({
                icon: 'success',
                title: '<span class="text-3xl font-bold">✅ Adicionado!</span>',
                html: '<p class="text-lg text-gray-600">Produto adicionado ao carrinho com sucesso</p>',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '🛒 Ver Carrinho',
                confirmButtonColor: "#9333ea",
                cancelButtonText: '← Continuar Comprando',
                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    title: 'font-black',
                    confirmButton: 'rounded-2xl px-8 py-3 font-bold',
                    cancelButton: 'rounded-2xl px-8 py-3 font-bold bg-gray-100 text-gray-800 hover:bg-gray-200'
                }
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

        // Smooth scroll with offset
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endpush