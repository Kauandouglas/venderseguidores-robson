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
        [x-cloak] { display: block !important; }
        
        .sidebar-link {
            @apply flex items-center px-4 py-3 text-gray-300 hover:bg-indigo-700 transition-colors duration-200;
        }
        
        .sidebar-link.active {
            @apply bg-indigo-700 text-white border-l-4 border-indigo-400;
        }
        
        .btn-primary {
            @apply px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200;
        }
        
        .btn-secondary {
            @apply px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200;
        }
        
        .btn-danger {
            @apply px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200;
        }
        
        .btn-success {
            @apply px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200;
        }
        
        .badge-success {
            @apply px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium;
        }
        
        .badge-danger {
            @apply px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium;
        }
        
        .badge-warning {
            @apply px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium;
        }
        
        .badge-info {
            @apply px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium;
        }
        
        .table-striped tbody tr:nth-child(odd) {
            @apply bg-gray-50;
        }
        
        .card {
            @apply bg-white rounded-lg shadow-md p-6;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-700 to-indigo-900 text-white overflow-y-auto transition-all duration-300" :class="{ 'w-20': !sidebarOpen }">
            <!-- Logo -->
            <div class="px-6 py-6 border-b border-indigo-600">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3" x-show="sidebarOpen">
                        <div class="w-10 h-10 bg-indigo-400 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Admin</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-indigo-300 hover:text-white">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 flex flex-col space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Usuários</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Pedidos</span>
                </a>
                
                <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Serviços</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Categorias</span>
                </a>
                
                <a href="{{ route('admin.plans.index') }}" class="sidebar-link {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <i class="fas fa-crown w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Planos</span>
                </a>
                
                <a href="{{ route('admin.domains.index') }}" class="sidebar-link {{ request()->routeIs('admin.domains.*') ? 'active' : '' }}">
                    <i class="fas fa-globe w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Domínios</span>
                </a>
                
                <a href="{{ route('admin.whatsapp.index') }}" class="sidebar-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
                    <i class="fas fa-comments w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">WhatsApp</span>
                </a>
                
                <a href="{{ route('admin.themes.index') }}" class="sidebar-link {{ request()->routeIs('admin.themes.*') ? 'active' : '' }}">
                    <i class="fas fa-palette w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Temas</span>
                </a>
                
                <a href="{{ route('admin.payment-gateways.index') }}" class="sidebar-link {{ request()->routeIs('admin.payment-gateways.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Pagamentos</span>
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-6"></i>
                    <span x-show="sidebarOpen" class="ml-3">Configurações</span>
                </a>
            </nav>

            <!-- User Menu -->
            <div class="absolute bottom-0 left-0 right-0 border-t border-indigo-600 p-4">
                <div class="flex items-center justify-between">
                    <div x-show="sidebarOpen" class="flex items-center space-x-3">
                        <img src="https://via.placeholder.com/40" alt="User" class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-indigo-300">Administrador</p>
                        </div>
                    </div>
                    <button @click="$dispatch('logout')" class="text-indigo-300 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-600">@yield('page-subtitle', 'Bem-vindo ao painel administrativo')</p>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- Messages -->
                        <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-envelope text-lg"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <img src="https://via.placeholder.com/32" alt="User" class="w-8 h-8 rounded-full">
                                <span class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            
                            <div @click.outside="open = false" x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i> Meu Perfil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i> Configurações
                                </a>
                                <hr class="my-2">
                                <form action="{{ url('/logout') }}" method="POST" class="block" onsubmit="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                                    </button>
                                </form>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    @csrf
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
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                <span>{{ $message }}</span>
                            </div>
                            <button class="text-green-700 hover:text-green-900">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3"></i>
                                <span>{{ $message }}</span>
                            </div>
                            <button class="text-red-700 hover:text-red-900">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($message = Session::get('warning'))
                        <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3"></i>
                                <span>{{ $message }}</span>
                            </div>
                            <button class="text-yellow-700 hover:text-yellow-900">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <h3 class="font-bold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Erros de Validação</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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
