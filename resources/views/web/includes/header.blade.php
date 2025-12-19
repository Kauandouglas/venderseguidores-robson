<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('web.home') }}" class="flex items-center space-x-2 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg blur opacity-25 group-hover:opacity-50 transition-opacity"></div>
                    <img src="{{ asset('web_assets/images/logo_new.png') }}" 
                         alt="{{ config('app.name') }}" 
                         class="relative h-10 w-auto">
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#home" class="nav-link-modern group">
                    <span class="relative px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                    </span>
                </a>
                
                <a href="#services" class="nav-link-modern group">
                    <span class="relative px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        Vantagens
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                    </span>
                </a>
                
                <a href="#plans" class="nav-link-modern group">
                    <span class="relative px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        Planos
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                    </span>
                </a>
                
                <a href="#testimonial" class="nav-link-modern group">
                    <span class="relative px-4 py-2 text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        Avaliações
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:w-full transition-all duration-300"></span>
                    </span>
                </a>

                <div class="flex items-center space-x-3 ml-6">
                    <a href="{{ route('panel.auth.formLogin') }}" 
                       class="px-6 py-2.5 text-purple-600 font-semibold rounded-xl border-2 border-purple-200 hover:border-purple-300 hover:bg-purple-50 transition-all duration-300">
                        Entrar
                    </a>
                    
                    <a href="#" 
                        onclick="showModal()"
                        class="group relative px-6 py-2.5 text-white font-semibold rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Criar minha loja
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button type="button" 
                    class="lg:hidden relative w-10 h-10 text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500 rounded-lg transition-colors"
                    id="mobile-menu-button"
                    aria-label="Toggle navigation">
                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-200">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="#home" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-all mobile-nav-link">
                Home
            </a>
            
            <a href="#services" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-all mobile-nav-link">
                Vantagens
            </a>
            
            <a href="#plans" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-all mobile-nav-link">
                Planos
            </a>
            
            <a href="#testimonial" class="block px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg font-medium transition-all mobile-nav-link">
                Avaliações
            </a>

            <div class="pt-4 space-y-3 border-t border-gray-200 mt-4">
                <a href="{{ route('panel.auth.formLogin') }}" 
                   class="block px-4 py-3 text-center text-purple-600 font-semibold rounded-xl border-2 border-purple-200 hover:bg-purple-50 transition-all">
                    Entrar
                </a>
                
                <a href="#" 
                   onclick="showModal()"
                   class="mobile-nav-link block px-4 py-3 text-center text-white font-semibold rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 shadow-lg transition-all">
                    Criar minha loja
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Add spacing below fixed nav -->
<div class="h-20"></div>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking on a link
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    mobileMenu.classList.add('hidden');
                });
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnButton && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Add active state on scroll
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 20) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    });
</script>

<style>
    /* Smooth scrolling offset for fixed header */
    html {
        scroll-padding-top: 80px;
    }

    /* Prevent body scroll when mobile menu is open */
    body.mobile-menu-open {
        overflow: hidden;
    }
</style>