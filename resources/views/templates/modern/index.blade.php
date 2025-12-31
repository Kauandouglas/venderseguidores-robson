@extends('templates.modern.templates.master')

@section('content')
<div class="stars" id="stars"></div>

<button class="theme-toggle" id="theme-toggle" title="Alternar Tema">
    <i class="fas fa-moon"></i>
</button>

<!-- PÁGINA 1: Seleção de Plataforma -->
<div class="page active" id="page-platform">
    <div class="container">
        <h1>Impulsione seu perfil hoje</h1>
        <p class="subtitle">Crescimento rápido, seguro e totalmente sigiloso.</p>

        <div class="platform-container">
            <h2>Escolha a plataforma ideal</h2>
            <p class="platform-description">Escolha a rede para impulsionar seu perfil.</p>

            <div class="platforms">
                @foreach ($sociais as $network => $categorias)
                    <div class="platform-item {{ $loop->first ? 'selected' : '' }}" data-platform="{{ $network }}">
                        <div class="platform-icon"><i class="fa-brands fa-{{ $network }}"></i></div>
                        <div class="platform-name">{{ ucfirst($network) }}</div>
                    </div>
                @endforeach
            </div>

            <button class="next-btn" id="btn-next-categories">Próximo →</button>
            <p class="footer-text" style="text-align: center; margin-top: 20px; color: var(--text-muted);">
                ✔ Resultados reais • 100% sigiloso • Suporte humanizado
            </p>
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
            <div class="tab-header" id="tab-header"></div>
            <div id="tab-contents"></div>
            
            <div style="text-align: center; margin-top: 60px;">
                <h2 class="titulo-servico">Selecione um serviço</h2>
                <p class="texto-instrucao">Selecione uma categoria e escolha o serviço perfeito para o seu perfil.</p>
            </div>
        </div>
    </div>
</div>

<!-- SEÇÃO DE VÍDEO -->
<section class="video-section" style="padding: 60px 20px;">
    <div class="container">
        <div class="video-container" style="max-width: 900px; margin: 0 auto; background: var(--bg-card); border-radius: 20px; padding: 30px; border: 1px solid var(--border-color);">
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px;">
                <iframe src="https://www.youtube.com/embed/wK5tOX6GOtU" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" allowfullscreen></iframe>
            </div>
            <div style="margin-top: 25px; display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; color: #10b981;">
                <span><i class="fas fa-check-circle"></i> Entrega Rápida</span>
                <span><i class="fas fa-shield-alt"></i> 100% Seguro</span>
                <span><i class="fas fa-users"></i> Perfis Reais</span>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO FAQ -->
<section class="faq-section" style="padding: 80px 20px;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 40px;">Perguntas Frequentes</h2>
        <div class="faq-container">
            @php
                $faqs = [
                    ['q' => 'É seguro e correto contratar os serviços?', 'a' => 'Sim, comprar seguidores é uma estratégia de marketing digital amplamente utilizada para impulsionar a visibilidade inicial.'],
                    ['q' => 'Como funciona o processo de compra?', 'a' => 'Escolha o pacote, informe o link do perfil e finalize o pagamento. O envio começa automaticamente.'],
                    ['q' => 'Quais métodos de pagamento são aceitos?', 'a' => 'Aceitamos Pix (QR Code ou Copia e Cola) e outras formas seguras.'],
                    ['q' => 'Minha conta pode ser banida?', 'a' => 'Não, utilizamos métodos seguros que não violam os termos das redes sociais.'],
                ];
            @endphp
            @foreach($faqs as $faq)
                <div class="faq-item">
                    <button class="faq-question">
                        <span>{{ $faq['q'] }}</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </button>
                    <div class="faq-answer">
                        <p>{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div id="notificationsContainer"></div>
@endsection

@push('scripts')
<script>
    const servicesData = @json($servicesData);
    const orderRouteBase = "{{ route('api.systemSettings.addCart', ['domain' => $user->domain, 'service' => 'ID', 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}";
    const cartRoute = "{{ route('api.cartProducts.index', ['domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}";

    // --- Inicialização ---
    document.addEventListener('DOMContentLoaded', () => {
        initStars();
        initTheme();
        initPlatformSelection();
        initFAQ();
        initNotifications();
    });

    // --- Estrelas ---
    function initStars() {
        const container = document.getElementById('stars');
        for (let i = 0; i < 100; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = `${Math.random() * 100}%`;
            star.style.top = `${Math.random() * 100}%`;
            star.style.animationDelay = `${Math.random() * 3}s`;
            container.appendChild(star);
        }
    }

    // --- Tema ---
    function initTheme() {
        const toggle = document.getElementById('theme-toggle');
        const icon = toggle.querySelector('i');
        
        toggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') !== 'light';
            document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
            icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
        });
    }

    // --- Navegação e Plataformas ---
    let selectedPlatform = 'instagram';

    function initPlatformSelection() {
        const items = document.querySelectorAll('.platform-item');
        items.forEach(item => {
            item.addEventListener('click', () => {
                items.forEach(i => i.classList.remove('selected'));
                item.classList.add('selected');
                selectedPlatform = item.dataset.platform;
            });
        });

        document.getElementById('btn-next-categories').addEventListener('click', () => {
            renderCategories(selectedPlatform);
            switchPage('page-categories');
        });

        document.getElementById('btn-voltar').addEventListener('click', () => switchPage('page-platform'));
    }

    function switchPage(pageId) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById(pageId).classList.add('active');
    }

    function renderCategories(platform) {
        const data = servicesData[platform];
        const header = document.getElementById('tab-header');
        const contents = document.getElementById('tab-contents');
        
        header.innerHTML = '';
        contents.innerHTML = '';

        Object.entries(data.categories).forEach(([key, cat], index) => {
            const btn = document.createElement('button');
            btn.className = `tab-btn ${index === 0 ? 'active' : ''}`;
            btn.textContent = cat.name;
            btn.onclick = () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(`cat-${key}`).classList.add('active');
            };
            header.appendChild(btn);

            const content = document.createElement('div');
            content.className = `tab-content ${index === 0 ? 'active' : ''}`;
            content.id = `cat-${key}`;
            content.innerHTML = `
                <h2>${cat.name}</h2>
                <p class="tab-description">✅ ${cat.description}</p>
                <div class="packages">
                    ${cat.packages.map(pkg => `
                        <div class="package-card ${pkg.highlighted ? 'highlighted' : ''}" onclick="addToCart('${pkg.id}')">
                            ${pkg.highlighted ? '<div class="highlight-badge">MAIS POPULAR</div>' : ''}
                            <div class="package-amount">${pkg.amount}</div>
                            <div class="package-price">${pkg.price}</div>
                        </div>
                    `).join('')}
                </div>
            `;
            contents.appendChild(content);
        });
    }

    function addToCart(serviceId) {
        const url = orderRouteBase.replace('ID', serviceId);
        $.post(url, (res) => {
            if (res.success) window.location.href = cartRoute;
            else alert('Erro ao adicionar ao carrinho.');
        }, 'json');
    }

    // --- FAQ ---
    function initFAQ() {
        document.querySelectorAll('.faq-question').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.parentElement;
                const isActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!isActive) item.classList.add('active');
            });
        });
    }

    // --- Notificações ---
    function initNotifications() {
        const names = ['João C.', 'Maria S.', 'Pedro A.', 'Ana L.', 'Lucas M.'];
        const types = ['seguidores', 'curtidas', 'visualizações'];
        
        setInterval(() => {
            const name = names[Math.floor(Math.random() * names.length)];
            const type = types[Math.floor(Math.random() * types.length)];
            showNotification(`${name} comprou ${type} agora!`);
        }, 10000);
    }

    function showNotification(text) {
        const container = document.getElementById('notificationsContainer');
        const el = document.createElement('div');
        el.className = 'notification-popup';
        el.innerHTML = `<span>${text}</span>`;
        container.appendChild(el);
        setTimeout(() => el.remove(), 5000);
    }
</script>
@endpush
