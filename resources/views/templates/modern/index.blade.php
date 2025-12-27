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
                    <p>Comprar seguidores é uma estratégia de marketing digital amplamente utilizada:

Ajuda a impulsionar a visibilidade inicial de perfis

É legal quando feito da forma certa como nós fazemos

Deve ser combinado com estratégias de engajamento orgânico

Não viola termos de serviço quando feito corretamente

Oferece um impulso inicial para crescimento nas redes sociais</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>É seguro comprar seguidores para minha conta?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Sim, desde que você utilize um serviço confiável.
Com a nossa plataforma, você conta com:

Entrega segura e sem necessidade de senha

Métodos atualizados e compatíveis com as diretrizes das plataformas

Experiência de anos no mercado

Suporte especializado para qualquer dúvida</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Como funciona o processo de compra?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>O processo é simples:

Escolha o pacote desejado

Informe o usuário ou link do perfil

Finalize o pagamento

Nossa plataforma processa o pedido

O envio dos seguidores começa automaticamente</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Quais métodos de pagamento são aceitos? Tem Pix?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Sim! Aceitamos Pix (QR Code ou Copia e Cola).
Todas as transações são criptografadas e seguras.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Minha conta pode ser banida por comprar seguidores?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Com nosso serviço, o risco de banimento é praticamente inexistente:

Utilizamos métodos seguros de divulgação

Não violamos os termos de serviço das redes sociais

Fornecemos seguidores de qualidade

Anos de experiência sem incidentes de banimento

Não solicitamos ou usamos sua senha

Sua conta permanece segura ao usar nossos serviços.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Quanto tempo leva para começar a receber os seguidores após a compra?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Depende da rede social:

Instagram: 0–60 min

TikTok: 0–60 min

YouTube: 0–24h

Twitter: algumas horas

O envio começa automaticamente após a confirmação do pagamento.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Os seguidores comprados são permanentes?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>A maioria permanece, mas pequenas variações são naturais.
Por isso oferecemos garantia de reposição por 30 dias, caso haja queda abaixo da quantidade entregue.

Manter conteúdo ativo ajuda a aumentar a retenção.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Como escolher a melhor opção de pacote de seguidores?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Considere:

Seu objetivo (crescimento rápido ou gradual)

Seu orçamento

O tamanho atual do seu perfil

A necessidade de reposição e estabilidade

Nossa equipe também pode orientar a escolha ideal.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Se o perfil estiver privado é possível receber as seguidores?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Não. A conta precisa estar pública para que o envio funcione.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Preciso informar minha senha?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Não, jamais pediremos sua senha. Precisamos apenas que informe para qual usuário devemos enviar os seguidores.</p>
                </div>
            </div>
                        <div class="faq-item">
                <button class="faq-question" onclick="toggleFAQ(this)">
                    <span>Por que escolher o nossa site para ter mais seguidores?</span>
                    <i class="fas fa-chevron-down faq-icon"></i>
                </button>

                <div class="faq-answer">
                    <p>Somos uma equipe especializada com mais de 12 anos de experiência.
Trabalhamos continuamente em testes e melhorias, garantindo:

Entrega segura e otimizada

Velocidade adequada para cada pedido

Alta taxa de retenção

Suporte especializado

Processos ajustados às práticas aceitas nas plataformas</p>
                </div>
            </div>

        </div>

        <!-- Ainda tem dúvidas? -->
        <div class="faq-contact" style="
            margin-top: 50px;
            text-align: center;
            padding: 30px;
            background: var(--bg-card);
            border-radius: 15px;
            border: 1px solid var(--border-color);
        ">
            <h3 style="color: var(--text-primary); margin-bottom: 15px; font-size: 1.5rem;">
                Ainda tem dúvidas?
            </h3>
            <p style="color: var(--text-secondary); margin-bottom: 25px;">
                Nossa equipe está pronta para ajudar você!
            </p>
            <a href="https://wa.me/62981686505" target="_blank" style="
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 15px 40px;
                background: #25d366;
                color: #fff;
                text-decoration: none;
                border-radius: 30px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(37, 211, 102, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(37, 211, 102, 0.3)'">
                <i class="fab fa-whatsapp" style="font-size: 1.5rem;"></i>
                Falar com Suporte
            </a>
        </div>
    </div>
</section>

<!-- SEÇÃO DE AVALIAÇÕES -->
<section class="testimonials-section" style="margin-top: 80px;">
    <h2 style="text-align: center; font-size: 2rem; margin-bottom: 15px; color: var(--text-primary);" >O que nossos clientes dizem</h2>
    <p style="text-align: center; color: #94a3b8; margin-bottom: 40px;">Mais de 10.000 clientes satisfeitos</p>

    <div class="testimonials-grid">
        <!-- Avaliação 1 - Joana Silva -->
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="avatar-wrapper">
                    <img src="https://assets.propmark.com.br/uploads/2022/02/WhatsApp-Image-2022-02-18-at-08.52.06.jpeg" alt="Joana Silva" class="avatar-img">
                    <div class="star-badge">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="user-info">
                    <h3 class="user-name">Joana Silva</h3>
                    <p class="user-role">Influencer Digital</p>
                </div>
            </div>

            <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <div class="quote-wrapper">
                <i class="fas fa-quote-left quote-icon"></i>
                <p class="testimonial-text">
                    Estou muito satisfeita com os serviços! Comprei seguidores para o meu perfil e o crescimento foi incrível. A entrega foi rápida e os seguidores são de alta qualidade. Recomendo a todos que querem impulsionar suas redes sociais!
                </p>
            </div>

            <div class="verified-badge">
                <i class="fas fa-check-circle"></i>
                Cliente Verificado
            </div>
        </div>

<!-- Avaliação 2 - Carlos Mendes -->
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="avatar-wrapper">
                    <img src="https://i.pinimg.com/736x/bd/7d/26/bd7d26904692d8b56b363ce85e4ec3d3.jpg" alt="Carlos Mendes" class="avatar-img">
                    <div class="star-badge">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="user-info">
                    <h3 class="user-name">Carlos Mendes</h3>
                    <p class="user-role">Empreendedor</p>
                </div>
            </div>

            <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <div class="quote-wrapper">
                <i class="fas fa-quote-left quote-icon"></i>
                <p class="testimonial-text">
                    Contratei o serviço para impulsionar a página da minha empresa no Facebook e os resultados foram impressionantes. A entrega foi feita de forma gradual e os seguidores são ótimos. Isso ajudou muito a aumentar a visibilidade da minha marca.
                </p>
            </div>

            <div class="verified-badge">
                <i class="fas fa-check-circle"></i>
                Cliente Verificado
            </div>
        </div>

        <!-- Avaliação 3 - Fernanda Lima -->
        <div class="testimonial-card">
            <div class="testimonial-header">
                <div class="avatar-wrapper">
                    <img src="https://i.pinimg.com/736x/bd/7d/26/bd7d26904692d8b56b363ce85e4ec3d3.jpg" alt="Fernanda Lima" class="avatar-img">
                    <div class="star-badge">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="user-info">
                    <h3 class="user-name">Fernanda Lima</h3>
                    <p class="user-role">Social Media Manager</p>
                </div>
            </div>

            <div class="rating">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <div class="quote-wrapper">
                <i class="fas fa-quote-left quote-icon"></i>
                <p class="testimonial-text">
                    Trabalho com diversos clientes e precisava de um serviço confiável para aumentar seguidores e engajamento. Encontrei a solução perfeita aqui! A entrega é rápida, o suporte é excelente e os resultados são sempre consistentes. Recomendo!
                </p>
            </div>

            <div class="verified-badge">
                <i class="fas fa-check-circle"></i>
                Cliente Verificado
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const htmlElement = document.documentElement;

// Função para aplicar o tema
function applyTheme(theme) {
    // Salvar no localStorage
    localStorage.setItem('theme', theme);

    if (theme === 'light') {
        htmlElement.setAttribute('data-theme', 'light');
        themeIcon.className = 'fas fa-sun';
    } else {
        htmlElement.removeAttribute('data-theme');
        themeIcon.className = 'fas fa-moon';
    }

    console.log('Tema aplicado e salvo:', theme);
}

// Função para alternar o tema
function toggleTheme() {
    const currentTheme = localStorage.getItem('theme') || 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    applyTheme(newTheme);
}

// Verificar e aplicar o tema salvo ou o padrão (light)
const savedTheme = localStorage.getItem('theme') || 'light';
applyTheme(savedTheme);

// Event listener no botão
themeToggle.addEventListener('click', toggleTheme);

    // ============================================
    // ESTRUTURA DE DADOS - Fácil para PHP
    // ============================================
    const servicesData = @json($servicesData);
    const orderRoute = "https://turbinamais.com/finalizar-pedido/SLUG_PLACEHOLDER/SERVICE_ID_PLACEHOLDER";

    // ============================================
    // VARIÁVEIS GLOBAIS
    // ============================================
    let selectedPlatform = 'instagram';

    // ============================================
    // CRIAR ESTRELAS
    // ============================================
    const starsContainer = document.getElementById('stars');
    for (let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        star.style.animationDelay = Math.random() * 3 + 's';
        starsContainer.appendChild(star);
    }

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
        generateCategories(selectedPlatform);

        document.getElementById('page-platform').classList.remove('active');
        document.getElementById('page-categories').classList.add('active');

        // Adiciona ao histórico do navegador para funcionar o botão voltar nativo
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

        Object.keys(platformData.categories).forEach((categoryKey, index) => {
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
    }

    // ============================================
    // CONFIGURAR BOTÕES DE CATEGORIA
    // ============================================
    function setupCategoryButtons() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        const categoriesTitle = document.querySelector('.categories-title');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                categoriesTitle.style.display = 'none';

                this.classList.add('active');

                const contentToShow = document.getElementById(category);
                if (contentToShow) {
                    contentToShow.classList.add('active');
                }
            });
        });

        // Click nos pacotes
        document.addEventListener('click', function(e) {
            if (e.target.closest('.package-card')) {
                const card = e.target.closest('.package-card');
                const allCards = document.querySelectorAll('.package-card');
                allCards.forEach(c => c.style.border = '1px solid rgba(71, 85, 105, 0.3)');
                card.style.border = '2px solid #3b82f6';

                const serviceId = card.getAttribute('data-service-id');
                const categorySlug = card.getAttribute('data-category-slug');
                const amount = card.getAttribute('data-amount');
                const price = card.getAttribute('data-price');

                window.location.href = `/finalizar-pedido/${categorySlug}/${serviceId}`;
            }
        });
    }

    // ============================================
    // FUNÇÃO CENTRAL DE VOLTAR
    // ============================================
    function voltarPaginaInterna() {
        const pageCategories = document.getElementById('page-categories');
        const pagePlatform = document.getElementById('page-platform');

        pageCategories.classList.remove('active');
        pagePlatform.classList.add('active');
    }

    // ============================================
    // BOTÃO VOLTAR - MANUAL
    // ============================================
    document.getElementById('btn-voltar').addEventListener('click', function () {
        voltarPaginaInterna();

        if (history.length > 1) {
            history.back();
        }
    });

    // ============================================
    // VOLTAR DO NAVEGADOR / CELULAR
    // ============================================
    window.onpopstate = function (event) {
        voltarPaginaInterna();
    };

    // ============================================
// NOTIFICAÇÕES DE COMPRAS EM TEMPO REAL
// ============================================
const nomesBrasileiros = [
    'João Costa', 'Maria Silva', 'Pedro Santos', 'Ana Oliveira', 'Lucas Almeida',
    'Juliana Souza', 'Rafael Lima', 'Camila Rocha', 'Bruno Ferreira', 'Beatriz Martins',
    'Felipe Ribeiro', 'Larissa Costa', 'Gustavo Pereira', 'Amanda Cardoso', 'Rodrigo Dias',
    'Fernanda Gomes', 'Thiago Barbosa', 'Mariana Freitas', 'Diego Araújo', 'Carolina Mendes',
    'Vinicius Teixeira', 'Gabriela Monteiro', 'Matheus Carvalho', 'Isabela Correia', 'Leonardo Pinto'
];

const servicos = [
    { tipo: 'seguidores', plataforma: 'Instagram', quantidades: [500, 1000, 2000, 5000, 10000] },
    { tipo: 'curtidas', plataforma: 'Instagram', quantidades: [100, 500, 1000, 2000, 5000] },
    { tipo: 'visualizações', plataforma: 'TikTok', quantidades: [1000, 5000, 10000, 50000] },
    { tipo: 'seguidores', plataforma: 'TikTok', quantidades: [500, 1000, 2000, 5000] },
    { tipo: 'inscritos', plataforma: 'YouTube', quantidades: [100, 500, 1000, 2000] },
    { tipo: 'visualizações', plataforma: 'YouTube', quantidades: [1000, 5000, 10000, 50000] }
];

function formatarNumero(num) {
    return num.toLocaleString('pt-BR');
}

function getRandomItem(array) {
    return array[Math.floor(Math.random() * array.length)];
}

function getInitials(name) {
    return name.split(' ').map(n => n[0]).join('').substring(0, 2);
}

function createNotification() {
    const nome = getRandomItem(nomesBrasileiros);
    const servico = getRandomItem(servicos);
    const quantidade = getRandomItem(servico.quantidades);

    const container = document.getElementById('notificationsContainer');

    const notification = document.createElement('div');
    notification.className = 'notification-popup';

    notification.innerHTML = `
        <div class="notification-avatar">
            ${getInitials(nome)}
        </div>
        <div class="notification-content">
            <div class="notification-name">${nome}</div>
            <div class="notification-action">
                Comprou ${formatarNumero(quantidade)} ${servico.tipo} para seu ${servico.plataforma}
            </div>
        </div>
        <div class="notification-time">agora</div>
        <button class="notification-close" onclick="this.closest('.notification-popup').remove()">
            ✕
        </button>
    `;

    container.appendChild(notification);

    // Remover após 6 segundos
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 500);
    }, 6000);

    // Limitar a 3 notificações visíveis
    const notifications = container.querySelectorAll('.notification-popup');
    if (notifications.length > 3) {
        notifications[0].remove();
    }
}

// Mostrar primeira notificação após 3 segundos
setTimeout(() => {
    createNotification();
    // Depois continuar mostrando a cada 8-15 segundos
    setInterval(() => {
        createNotification();
    }, Math.random() * 7000 + 8000); // Entre 8 e 15 segundos
}, 3000);
</script>

<script>
// ============================================
// FUNÇÃO PARA TOGGLE FAQ
// ============================================
function toggleFAQ(button) {
    const faqItem = button.parentElement;
    const wasActive = faqItem.classList.contains('active');

    // Fechar todos os outros itens
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });

    // Se não estava ativo, ativar
    if (!wasActive) {
        faqItem.classList.add('active');
    }
}

// Fechar FAQ ao clicar fora
document.addEventListener('click', function(e) {
    if (!e.target.closest('.faq-item')) {
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
    }
});
</script>
@endpush
