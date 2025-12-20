<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Administrativo')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Animações personalizadas */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        
        /* Links da sidebar */
        .sidebar-link {
            @apply flex items-center px-4 py-3 mx-2 text-gray-300 rounded-xl transition-all duration-300 group relative overflow-hidden;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, #6366f1, #8b5cf6);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .sidebar-link:hover {
            @apply bg-white/10 text-white;
        }
        
        .sidebar-link.active {
            @apply bg-white text-indigo-600 shadow-lg;
        }
        
        .sidebar-link.active::before {
            transform: scaleY(1);
        }
        
        .sidebar-link i {
            @apply transition-transform duration-300;
        }
        
        .sidebar-link:hover i {
            @apply scale-110;
        }
        
        /* Botões */
        .btn-primary {
            @apply px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300;
        }
        
        .btn-secondary {
            @apply px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 hover:shadow-md transition-all duration-300;
        }
        
        .btn-danger {
            @apply px-6 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300;
        }
        
        .btn-success {
            @apply px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all duration-300;
        }
        
        /* Badges */
        .badge-success {
            @apply inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold;
        }
        
        .badge-danger {
            @apply inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold;
        }
        
        .badge-warning {
            @apply inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold;
        }
        
        .badge-info {
            @apply inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold;
        }
        
        /* Tabelas */
        .table-striped tbody tr:nth-child(odd) {
            @apply bg-gray-50/50;
        }
        
        .table-striped tbody tr {
            @apply transition-colors duration-200;
        }
        
        .table-striped tbody tr:hover {
            @apply bg-indigo-50;
        }
        
        /* Cards */
        .card {
            @apply bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition-shadow duration-300;
        }
        
        /* Notificações */
        .notification-badge {
            @apply absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center text-xs font-bold text-white shadow-lg;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true, userDropdown: false }">
        <!-- Sidebar -->
        <aside 
            class="bg-gradient-to-b from-indigo-600 via-indigo-700 to-indigo-900 text-white overflow-y-auto transition-all duration-300 shadow-2xl" 
            :class="sidebarOpen ? 'w-72' : 'w-20'"
        >
            <!-- Logo -->
            <div class="px-6 py-6 border-b border-indigo-500/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3" x-show="sidebarOpen" x-transition>
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-rocket text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold block">AdminPanel</span>
                            <span class="text-xs text-indigo-300">v2.0</span>
                        </div>
                    </div>
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 text-indigo-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300"
                    >
                        <i class="fas" :class="sidebarOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 pb-32 flex flex-col space-y-2 px-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Usuários</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Pedidos</span>
                </a>
                
                <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Serviços</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Categorias</span>
                </a>
                
                <a href="{{ route('admin.plans.index') }}" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <i class="fas fa-crown w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Planos</span>
                </a>
                
                <a href="{{ route('admin.domains.index') }}" class="sidebar-link {{ request()->routeIs('admin.domains.*') ? 'active' : '' }}">
                    <i class="fas fa-globe w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">Domínios</span>
                </a>
                
                <a href="{{ route('admin.whatsapp.index') }}" class="sidebar-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
                    <i class="fab fa-whatsapp w-6 text-lg"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium">WhatsApp</span>
                </a>
            </nav>

            <!-- User Menu -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-indigo-900 to-transparent p-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3">
                    <div class="flex items-center justify-between">
                        <div x-show="sidebarOpen" class="flex items-center space-x-3 flex-1">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-xs text-indigo-300 truncate">Administrador</p>
                            </div>
                        </div>
                        <form action="{{ url('/logout') }}" method="POST" class="inline">
                            @csrf
                            <button 
                                type="submit" 
                                class="p-2 text-indigo-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300"
                                title="Sair"
                            >
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            @yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">@yield('page-subtitle', 'Bem-vindo ao painel administrativo')</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="hidden md:flex items-center bg-gray-100 rounded-xl px-4 py-2 space-x-2">
                            <i class="fas fa-search text-gray-400"></i>
                            <input 
                                type="text" 
                                placeholder="Buscar..." 
                                class="bg-transparent border-none outline-none text-sm w-64"
                            >
                        </div>
                        
                        <!-- Notifications -->
                        <button class="relative p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-bell text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        
                        <!-- Messages -->
                        <button class="relative p-3 text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-envelope text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="notification-badge">5</span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button 
                                @click="open = !open" 
                                class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-xl transition-all duration-300"
                            >
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <p class="text-sm font-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div 
                                @click.outside="open = false" 
                                x-show="open" 
                                x-transition
                                class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-gray-100"
                            >
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                                </div>
                                
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user w-5 mr-3 text-indigo-600"></i>
                                    <span>Meu Perfil</span>
                                </a>
                                
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-cog w-5 mr-3 text-indigo-600"></i>
                                    <span>Configurações</span>
                                </a>
                                
                                <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-question-circle w-5 mr-3 text-indigo-600"></i>
                                    <span>Ajuda & Suporte</span>
                                </a>
                                
                                <div class="border-t border-gray-100 my-2"></div>
                                
                                <form action="{{ url('/logout') }}" method="POST" class="block">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                        <span class="font-semibold">Sair</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="p-8">
                    <!-- Flash Messages -->
                    @if ($message = Session::get('success'))
                        <div class="mb-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl flex items-center justify-between shadow-sm animate-slide-in">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-green-900">Sucesso!</p>
                                    <p class="text-sm text-green-700">{{ $message }}</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 p-2 hover:bg-green-100 rounded-lg transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="mb-6 p-5 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl flex items-center justify-between shadow-sm animate-slide-in">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-times text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-red-900">Erro!</p>
                                    <p class="text-sm text-red-700">{{ $message }}</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 p-2 hover:bg-red-100 rounded-lg transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('warning'))
                        <div class="mb-6 p-5 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-xl flex items-center justify-between shadow-sm animate-slide-in">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-yellow-900">Atenção!</p>
                                    <p class="text-sm text-yellow-700">{{ $message }}</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900 p-2 hover:bg-yellow-100 rounded-lg transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-5 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl shadow-sm animate-slide-in">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-red-900 mb-2">Erros de Validação</h3>
                                    <ul class="space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="flex items-center text-sm text-red-700">
                                                <i class="fas fa-circle text-xs mr-2"></i>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>