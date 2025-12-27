@extends('templates.modern.templates.master')
@section('content')

<!-- PÁGINA 1: Seleção de Plataforma -->
<div class="page active" id="page-platform">
    <div class="container">
        <h1>Impulsione seu perfil hoje</h1>
        <p class="subtitle">Crescimento rápido, seguro e totalmente sigiloso.</p>

        <div class="platform-container">
            <h2>Escolha a plataforma ideal</h2>
            <p class="platform-description">Escolha a rede para impulsionar seu perfil.</p>

            <div class="platforms">
                <div class="platform-item selected" data-platform="instagram">
                    <div class="popular-badge">Popular</div>
                    <div class="platform-icon"><i class="fa fa-brands fa-instagram"></i></div>
                    <div class="platform-name">Instagram</div>
                </div>

                <div class="platform-item" data-platform="tiktok">
                    <div class="platform-icon"><i class="fa fa-brands fa-tiktok"></i></div>
                    <div class="platform-name">TikTok</div>
                </div>

                <div class="platform-item" data-platform="youtube">
                    <div class="platform-icon"><i class="fa fa-brands fa-youtube"></i></div>
                    <div class="platform-name">YouTube</div>
                </div>

                <div class="platform-item" data-platform="kwai">
                    <div class="platform-icon"><i class="fa fa-solid fa-video"></i></div>
                    <div class="platform-name">Kwai</div>
                </div>
            </div>

            <button class="next-btn" id="btn-next-categories">Próximo →</button>

            <p class="footer-text">✔ Resultados reais • 100% sigiloso • Suporte humanizado</p><br>
        </div>
    </div>
</div>


<!-- PÁGINA 2: Categorias e Pacotes -->
<div class="page" id="page-categories">
    <div class="container">
        <h1>Escolha sua categoria</h1>
        <p class="subtitle">Acelere seu crescimento digital 🚀</p>

        <button id="btn-voltar" class="voltar-btn">← Voltar</button>


        <div class="tabs">
            <h3 class="categories-title">Categorias</h3>

            <div class="tab-header" id="tab-header">
                <!-- Tabs serão geradas dinamicamente aqui -->
            </div>

            <div id="tab-contents">
                <!-- Conteúdos serão gerados dinamicamente aqui -->
            </div>
            <div style="text-align: center;">
                <h2 class="titulo-servico" style="margin-top: 60px;margin-bottom: 16px;">Selecione um serviço</h2>
                <p class="texto-instrucao">Selecione uma categoria e escolha o serviço perfeito para o seu perfil. É rápido, fácil e funciona!</p>
            </div>
        </div>
    </div>
</div>

<!-- SEÇÃO DE VÍDEO -->
<section class="video-section" style="margin-top: 0px; padding: 60px 20px;">
    <div class="container">
        <div class="video-container" style="
            max-width: 900px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(147, 51, 234, 0.2);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        ">
            <div style="
                position: relative;
                padding-bottom: 56.25%;
                height: 0;
                overflow: hidden;
                border-radius: 15px;
            ">
                <iframe
                    src="https://www.youtube.com/embed/wK5tOX6GOtU"
                    style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        border: none;
                        border-radius: 15px;
                    "
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>

            <div style="margin-top: 25px; text-align: center;">
                <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #10b981;">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <span>Entrega Rápida</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; color: #10b981;">
                        <i class="fas fa-shield-alt" style="color: #10b981;"></i>
                        <span>100% Seguro</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; color: #10b981;">
                        <i class="fas fa-users" style="color: #10b981;"></i>
                        <span>Perfis Reais</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- SEÇÃO DE PERGUNTAS FREQUENTES (FAQ) -->
<section class="faq-section" style="margin-top: 80px; padding: 0 20px;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2rem; margin-bottom: 15px; color: var(--text-primary);">
            Perguntas Frequentes
        </h2>
        <p style="text-align: center; color: var(--text-secondary); margin-bottom: 40px;">
            Tire suas dúvidas sobre nossos serviços
        </p>

        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>É seguro e correto contratar os serviços ?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>
                <div class="faq-answer">
                    <p>Comprar seguidores é uma estratégia de marketing digital amplamente utilizada. Ajuda a impulsionar a visibilidade inicial de perfis, é legal quando feito da forma certa e não viola termos de serviço quando feito corretamente.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>É seguro comprar seguidores para minha conta?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>
                <div class="faq-answer">
                    <p>Sim, desde que você utilize um serviço confiável. Com a nossa plataforma, você conta com entrega segura, sem necessidade de senha e suporte especializado.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Como funciona o processo de compra?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>
                <div class="faq-answer">
                    <p>O processo é simples: Escolha o pacote, informe o link do perfil, finalize o pagamento e o envio começa automaticamente.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // ============================================
    // ESTRUTURA DE DADOS VINDA DO PHP
    // ============================================
    const servicesData = @json($servicesData);
    let selectedPlatform = 'instagram';

    // ============================================
    // SELEÇÃO DE PLATAFORMA (PÁGINA 1)
    // ============================================
    const platformItems = document.querySelectorAll('.platform-item');
    platformItems.forEach(item => {
        item.addEventListener('click', function() {
            platformItems.forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            selectedPlatform = this.getAttribute('data-platform');
        });
    });

    // ============================================
    // BOTÃO PRÓXIMO → ABRIR CATEGORIAS
    // ============================================
    document.getElementById('btn-next-categories').addEventListener('click', function() {
        if (!servicesData[selectedPlatform]) {
            alert('Nenhum serviço disponível para esta plataforma no momento.');
            return;
        }

        generateCategories(selectedPlatform);
        document.getElementById('page-platform').classList.remove('active');
        document.getElementById('page-categories').classList.add('active');
        history.pushState({ page: "categories" }, "");
    });

    // ============================================
    // FUNÇÃO PARA GERAR CATEGORIAS E PACOTES
    // ============================================
    function generateCategories(platform) {
        const platformData = servicesData[platform];
        const tabHeader = document.getElementById('tab-header');
        const tabContents = document.getElementById('tab-contents');

        tabHeader.innerHTML = '';
        tabContents.innerHTML = '';

        const categoryKeys = Object.keys(platformData.categories);

        categoryKeys.forEach((categoryKey, index) => {
            const category = platformData.categories[categoryKey];

            // Botão da categoria
            const btnCategory = document.createElement('button');
            btnCategory.className = 'tab-btn';
            btnCategory.setAttribute('data-category', categoryKey);
            btnCategory.textContent = category.name;
            tabHeader.appendChild(btnCategory);

            // Conteúdo da categoria
            const contentDiv = document.createElement('div');
            contentDiv.className = 'tab-content';
            contentDiv.id = categoryKey;

            contentDiv.innerHTML = `
                <h2>${category.name}</h2>
                <p class="tab-description">
                    <span class="check">✅</span>
                    ${category.description}
                </p>

                <div class="packages">
                    ${category.packages.map(pkg => `
                        <div class="package-card ${pkg.highlighted ? 'highlighted' : ''}"
                            data-service-id="${pkg.id}"
                            data-category-slug="${category.slug}"
                            data-amount="${pkg.quantity}"
                            data-price="${pkg.price}">

                            ${pkg.highlighted ? `<div class="highlight-badge">MAIS POPULAR</div>` : ''}
                            ${pkg.discount ? `<div class="badge">${pkg.discount}</div>` : ''}
                            <div class="package-amount">${pkg.amount}</div>
                            <div class="package-label">${category.name}</div>
                            <div class="package-price">${pkg.price}</div>
                        </div>
                    `).join('')}
                </div>
            `;

            tabContents.appendChild(contentDiv);
        });

        setupCategoryButtons();

        // Selecionar a primeira categoria automaticamente
        if (categoryKeys.length > 0) {
            const firstBtn = tabHeader.querySelector('.tab-btn');
            if (firstBtn) firstBtn.click();
        }
    }

    function setupCategoryButtons() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        const categoriesTitle = document.querySelector('.categories-title');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                if (categoriesTitle) categoriesTitle.style.display = 'none';
                this.classList.add('active');

                const contentToShow = document.getElementById(category);
                if (contentToShow) contentToShow.classList.add('active');
            });
        });
    }

    // Click nos pacotes
    document.addEventListener('click', function(e) {
        const card = e.target.closest('.package-card');
        if (card) {
            const serviceId = card.getAttribute('data-service-id');
            const categorySlug = card.getAttribute('data-category-slug');
            window.location.href = `/finalizar-pedido/${categorySlug}/${serviceId}`;
        }
    });

    // Funções de navegação
    function voltarPaginaInterna() {
        document.getElementById('page-categories').classList.remove('active');
        document.getElementById('page-platform').classList.add('active');
    }

    document.getElementById('btn-voltar').addEventListener('click', function () {
        voltarPaginaInterna();
        if (history.length > 1) history.back();
    });

    window.onpopstate = function (event) {
        voltarPaginaInterna();
    };

    function toggleFAQ(button) {
        const faqItem = button.parentElement;
        const wasActive = faqItem.classList.contains('active');
        document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));
        if (!wasActive) faqItem.classList.add('active');
    }
</script>
@endpush
