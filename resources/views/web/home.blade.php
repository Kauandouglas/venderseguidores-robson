@extends('web.templates.master')
@section('content')
    <!-- Hero Section - Modern gradient with animated elements -->
    <section id="home" class="relative min-h-screen overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-900 to-pink-800">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left content -->
                <div class="space-y-8 text-white" data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/20">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>
                        <span class="text-sm font-medium">Sistema 100% Automatizado</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                        Crie sua Loja de
                        <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                            Seguidores
                        </span>
                    </h1>

                    <p class="text-xl lg:text-2xl text-gray-200 leading-relaxed">
                        Em poucos minutos sua loja estará online vendendo automaticamente. Seu único trabalho será divulgar!
                    </p>

                    <!-- Benefits list -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-100">Recebimento automático após aprovação do pagamento</p>
                        </div>

                        <div class="flex items-start gap-3 bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-100">Pagamento via Cartão ou Pix direto na sua conta</p>
                        </div>

                        <div class="flex items-start gap-3 bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-gray-100">Integrado com o Painel do Insta 🇧🇷 +50 mil clientes</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="#plans" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/50">
                            <span class="relative z-10">Criar minha loja</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        
                        <a href="#services" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-white/10 backdrop-blur-sm rounded-2xl border-2 border-white/20 hover:bg-white/20 transition-all duration-300">
                            Saiba mais
                        </a>
                    </div>
                </div>

                <!-- Right image -->
                <div class="relative" data-aos="fade-left">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-3xl blur-3xl"></div>
                    <img src="{{ asset('web_assets/images/group.png') }}" alt="Dashboard Preview" 
                         class="relative w-full h-auto rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section header -->
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <p class="text-purple-600 font-semibold text-sm uppercase tracking-wider mb-3">Recursos Poderosos</p>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Por que escolher nossa plataforma?
                </h2>
                <p class="text-xl text-gray-600">
                    Todas as ferramentas que você precisa para automatizar e escalar suas vendas
                </p>
            </div>

            <!-- Services grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Integração com Pixel</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Compatibilidade para integrar seus Pixels do Facebook ADS e Google ADS para otimizar campanhas
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Design & Templates</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Altere o design e template do seu site sem precisar saber programar - tudo visual
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gerenciamento de Vendas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Extratos, gráficos e relatórios completos de todas as suas vendas em tempo real
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Análise de Perfil Instagram</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Envio 100% automático com validação do perfil e postagem do Instagram
                    </p>
                </div>

                <!-- Service 5 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Painel SMM</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Site compatível com todos os painéis SMM do mercado para máxima flexibilidade
                    </p>
                </div>

                <!-- Service 6 -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-200" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Vinculação de Domínio</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Vincule o domínio da sua empresa direto em nossos painéis de forma simples
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-gradient-to-br from-purple-50 to-pink-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Left content -->
                <div class="space-y-8" data-aos="fade-right">
                    <div>
                        <p class="text-purple-600 font-semibold text-sm uppercase tracking-wider mb-3">Automação Total</p>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                            Aumente suas vendas em até 60%
                        </h2>
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Automatize completamente seu processo de vendas. Sem envio manual de pedidos, sem complicação.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-5 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Análise do perfil e postagem</h4>
                                <p class="text-gray-600">Validação automática do Instagram antes do envio</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Envio instantâneo e automático</h4>
                                <p class="text-gray-600">Processamento em tempo real para o painel</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Alta qualidade e aprovamento</h4>
                                <p class="text-gray-600">Melhor conversão em vendas do mercado</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Integração com Mercado Pago</h4>
                                <p class="text-gray-600">Receba pagamentos via Pix e Cartão</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right image -->
                <div class="relative" data-aos="fade-left">
                    <div class="absolute -inset-4 bg-gradient-to-br from-purple-400 to-pink-400 rounded-3xl blur-2xl opacity-20"></div>
                    <img src="{{ asset('web_assets/images/idea.png') }}" alt="Business Growth" 
                         class="relative w-full h-auto transform hover:scale-105 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section id="plansdx" class="py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto" data-aos="fade-up">
                <div class="text-center mb-12">
                    <p class="text-purple-600 font-semibold text-sm uppercase tracking-wider mb-3">Veja como funciona</p>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                        Monte sua Loja em minutos
                    </h2>
                    <p class="text-xl text-gray-600">
                        Assista ao vídeo e veja como é simples começar a vender
                    </p>
                </div>

                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <div class="aspect-video">
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/pp3GFpmh2dM"
                                title="Apresentação da Loja de Seguidores"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="plans" class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <p class="text-purple-600 font-semibold text-sm uppercase tracking-wider mb-3">Planos & Preços</p>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Escolha o plano ideal para você
                </h2>
                <p class="text-xl text-gray-600">
                    Os melhores planos e valores para atender suas demandas
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach($plans as $plan)
                    <div class="group relative bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border-2 border-gray-100 hover:border-purple-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <!-- Plan image/icon -->
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
                                <img src="{{ asset('web_assets/images/' . $plan->image) }}" 
                                     alt="{{ $plan->name }}"
                                     class="relative w-20 h-20 object-contain">
                            </div>
                        </div>

                        <!-- Plan name -->
                        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">{{ $plan->name }}</h3>

                        <!-- Price -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-baseline gap-2">
                                <span class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    R$ {{ $plan->price }}
                                </span>
                                <span class="text-gray-500 text-lg">/mês</span>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @foreach(explode("\n", $plan->description) as $description)
                                <li class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">{!! $description !!}</span>
                                </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <button onclick="showModal()"
                                class="w-full py-4 px-6 text-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl hover:from-purple-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Criar minha loja
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="projects" class="py-24 bg-gradient-to-br from-purple-900 to-indigo-900 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4">
                    Números que impressionam
                </h2>
                <p class="text-xl text-purple-200">
                    Resultados reais de uma plataforma confiável
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl font-bold mb-2 bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">
                        <span class="scVal">0</span>%
                    </div>
                    <p class="text-lg text-purple-200">Clientes satisfeitos</p>
                </div>

                <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl font-bold mb-2 bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                        <span class="fpVal">0</span>
                    </div>
                    <p class="text-lg text-purple-200">Sites conectados</p>
                </div>

                <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl font-bold mb-2 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        <span class="tMVal">0</span>
                    </div>
                    <p class="text-lg text-purple-200">Usuários ativos</p>
                </div>

                <div class="text-center p-8 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20 hover:bg-white/15 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-5xl font-bold mb-2 bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent">
                        <span class="bPVal">0</span>
                    </div>
                    <p class="text-lg text-purple-200">Total de ordens</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonial" class="py-24 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <p class="text-purple-600 font-semibold text-sm uppercase tracking-wider mb-3">Depoimentos</p>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Nossos clientes são nossos maiores fãs
                </h2>
                <p class="text-xl text-gray-600">
                    Veja o que dizem quem já está vendendo conosco
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Uma das minhas melhores escolhas, envio automático e sem eu precisar me preocupar com a demanda"
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('web_assets/images/testimonial/testimonial1.jpg') }}" 
                             alt="Ana" 
                             class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-900">Ana</p>
                            <p class="text-sm text-gray-500">Cliente</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Primeira vez no mercado que vejo uma plataforma tão grande e com todas as ferramentas que preciso, nota 1000!!"
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('web_assets/images/testimonial/testimonial2.jpg') }}" 
                             alt="Marcos" 
                             class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-900">Marcos</p>
                            <p class="text-sm text-gray-500">Cliente</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        "Sem palavras! Nunca mais precisei enviar ordem para painel, vai tudo 100% automático sem eu precisar colocar a mão"
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('web_assets/images/testimonial/testimonial4.jpg') }}" 
                             alt="Lucas" 
                             class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-900">Lucas</p>
                            <p class="text-sm text-gray-500">Cliente</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Modal - Adaptado para Twind CSS -->
<div style="background-color: #0000008f;" id="createUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-opacity-50 transition-opacity duration-300 ease-out" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen">
        <div class="relative mx-auto my-6 w-full max-w-4xl transition-all duration-300 ease-out sm:max-w-lg md:max-w-xl lg:max-w-3xl xl:max-w-4xl">
            <div class="relative flex flex-col w-full bg-white pointer-events-auto bg-clip-padding outline-none rounded-3xl border-none overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-8 border-none rounded-t-3xl bg-gradient-to-br from-indigo-500 to-purple-600">
                    <div>
                        <h5 id="createUserModalLabel" class="text-white font-bold mb-1 text-2xl">
                            🚀 Criar minha loja
                        </h5>
                        <p class="text-white mb-0 opacity-90 text-sm">
                            Preencha os dados abaixo para começar
                        </p>
                    </div>
                    <button type="button" class="text-white opacity-100 text-3xl leading-none font-semibold outline-none focus:outline-none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form method="POST" class="form-login" id="sendUserForm" autocomplete="off">
                    @csrf
                    <div class="p-8">
                        <!-- Alert -->
                        <div class="alert alert-danger hidden rounded-xl p-4 mb-4 bg-red-100 text-red-700 border border-red-300"></div>
                        
                        <div class="flex flex-wrap -mx-3">
                            <!-- Nome -->
                            <div class="w-full md:w-1/2 px-3 mb-6">
                                <label for="name" class="font-semibold text-gray-800 mb-2 block text-sm">
                                    Nome <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-stretch w-full relative">
                                    <span class="flex items-center whitespace-no-wrap bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl px-4 py-2 text-base font-normal text-gray-700">
                                        <i class="mdi mdi-account text-indigo-500"></i>
                                    </span>
                                    <input type="text" 
                                           class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-l-0 border-gray-300 rounded-r-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Digite seu nome" 
                                           required>
                                </div>
                            </div>

                            <!-- E-mail -->
                            <div class="w-full md:w-1/2 px-3 mb-6">
                                <label for="email" class="font-semibold text-gray-800 mb-2 block text-sm">
                                    E-mail <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-stretch w-full relative">
                                    <span class="flex items-center whitespace-no-wrap bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl px-4 py-2 text-base font-normal text-gray-700">
                                        <i class="mdi mdi-email text-indigo-500"></i>
                                    </span>
                                    <input type="email" 
                                           class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-l-0 border-gray-300 rounded-r-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Digite seu e-mail" 
                                           required>
                                </div>
                                <div class="text-red-500 text-xs mt-1" style="font-size: 0.8rem;"></div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="w-full md:w-1/2 px-3 mb-6">
                                <label for="phone" class="font-semibold text-gray-800 mb-2 block text-sm">
                                    WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-stretch w-full relative">
                                    <span class="flex items-center whitespace-no-wrap bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl px-4 py-2 text-base font-normal text-gray-700">
                                        <i class="mdi mdi-whatsapp text-green-500"></i>
                                    </span>
                                    <input type="text" 
                                           class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-l-0 border-gray-300 rounded-r-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="phone" 
                                           name="phone" 
                                           placeholder="(00) 00000-0000" 
                                           required>
                                </div>
                            </div>

                            <!-- Senha -->
                            <div class="w-full md:w-1/2 px-3 mb-6">
                                <label for="password" class="font-semibold text-gray-800 mb-2 block text-sm">
                                    Senha <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-stretch w-full relative">
                                    <span class="flex items-center whitespace-no-wrap bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl px-4 py-2 text-base font-normal text-gray-700">
                                        <i class="mdi mdi-lock text-indigo-500"></i>
                                    </span>
                                    <input type="password" 
                                           class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-l-0 border-gray-300 rounded-r-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Digite sua senha" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Subdomínio -->
                        <div class="mb-8">
                            <label for="domain" class="font-semibold text-gray-800 mb-2 block text-sm">
                                Subdomínio <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-stretch w-full relative rounded-xl overflow-hidden border border-gray-300">
                                <span class="flex items-center whitespace-no-wrap text-white bg-gradient-to-br from-indigo-500 to-purple-600 px-4 py-3 text-base font-medium">
                                    {{ config('app.url') }}/
                                </span>
                                <input type="text" 
                                       class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 border-none" 
                                       id="domain" 
                                       name="domain" 
                                       placeholder="minha-loja" 
                                       required>
                            </div>
                            <p id="domainMessage" class="mt-2 mb-0 text-sm"></p>
                            <p class="text-gray-500 mt-1 mb-0 text-sm">
                                Sua loja será: <strong>{{ config('app.url') }}/<span id="domainPerson">minha-loja</span></strong>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full text-white font-bold py-4 px-6 rounded-xl text-lg transition duration-300 ease-in-out bg-gradient-to-br from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-300" 
                                style="box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.4);">
                            <i class="mdi mdi-rocket-launch mr-2"></i>
                            CADASTRAR AGORA
                        </button>

                        <!-- Login Link -->
                        <div class="text-center mt-6">
                            <a href="{{ route('panel.auth.login') }}" class="text-indigo-500 hover:text-indigo-600 font-medium text-base transition duration-150 ease-in-out">
                                <i class="mdi mdi-login mr-1"></i>
                                Já tenho cadastro
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Script de Exemplo para Abrir/Fechar (Necessário para Twind/Tailwind) -->
<script>
   const modal = document.getElementById('createUserModal');
        const dismissButtons = modal.querySelectorAll('[data-dismiss="modal"]');

        // Função para mostrar o modal
        function showModal() {
            modal.classList.remove('hidden');
            // Adiciona a classe para a transição de opacidade (opcional, mas recomendado)
            setTimeout(() => {
                modal.classList.add('opacity-100');
            }, 10);
        }

        // Função para esconder o modal
        function hideModal() {
            modal.classList.remove('opacity-100');
            // Espera a transição de opacidade terminar antes de esconder
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // 300ms é a duração da transição definida no CSS
        }

        // Adiciona evento de clique para fechar o modal
        dismissButtons.forEach(button => {
            button.addEventListener('click', hideModal);
        });

        // Adiciona evento de clique no backdrop para fechar o modal
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });

        // Adiciona evento de tecla ESC para fechar o modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                hideModal();
            }
        });
</script>

    <script>
        let timeoutId;

        function verifyDomain() {
            $.get('{{ route('panel.users.verifyDomain') }}', {'domain': slugify($('#domain').val())},
                function (response) {
                    if (response.count == 0) {
                        $('#domainMessage')
                            .removeClass('text-danger')
                            .addClass('text-success')
                            .html('<i class="mdi mdi-check-circle"></i> Subdomínio disponível! ✓');
                    } else {
                        $('#domainMessage')
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .html('<i class="mdi mdi-close-circle"></i> Este subdomínio já está cadastrado');
                    }
                }, 'json')
        }

        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .trim()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        $(document).ready(function () {
            // Domain validation
            $('#domain').on('keyup blur', function () {
                $(this).val(slugify($(this).val()));
                $('#domainPerson').html(slugify($(this).val()) || 'minha-loja');

                clearTimeout(timeoutId);
                if ($(this).val().length > 0) {
                    timeoutId = setTimeout(verifyDomain, 500);
                } else {
                    $('#domainMessage').html('');
                }
            });

            // Form submission
            $('#sendUserForm').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.users.store') }}",
                    data: data,
                    dataType: "json",
                    beforeSend: function () {
                        form.find('button[type="submit"]')
                            .prop('disabled', true)
                            .html('<i class="mdi mdi-loading mdi-spin mr-2"></i>Cadastrando...');
                    },
                    success: function (response) {
                        location.href = response.redirect;
                    },
                    error: function (response) {
                        form.find('.alert').html('').removeClass('hidden');
                        $.each(response.responseJSON.errors, function (index, value) {
                            form.find('.alert').append('<i class="mdi mdi-alert-circle mr-1"></i>' + value + '<br>');
                        });
                        // Scroll to top of modal to show errors
                        $('.modal-body').animate({ scrollTop: 0 }, 'fast');
                    },
                    complete: function () {
                        form.find('button[type="submit"]')
                            .prop('disabled', false)
                            .html('<i class="mdi mdi-rocket-launch mr-2"></i>CADASTRAR AGORA');
                    }
                });
            });

            // Phone mask
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

            // Clear form when modal is hidden
            $('#createUserModal').on('hidden.bs.modal', function () {
                $('#sendUserForm')[0].reset();
                $('#domainMessage').html('');
                $('#domainPerson').html('minha-loja');
                $('.alert').addClass('hidden').html('');
            });
        });

        // Set plan ID when modal opens
        $('#createUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var plan = button.data('plan');
            var modal = $(this);
            modal.find('#plan_id').val(plan);
        });
    </script>
@endpush