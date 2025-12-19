<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="flex min-h-screen bg-gray-100">
    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 w-64 transition-transform duration-300 transform bg-white border-r border-gray-200 md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 to-blue-800">
            <span class="text-xl font-bold text-white">Dashboard</span>
        </div>

        <nav class="mt-5 space-y-1">
            <a href="{{ route('dashboard.index') }}"
               class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-home mr-3"></i>
                <span>Home</span>
            </a>

            <a href="{{ route('dashboard.index') }}"
               class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-users mr-3"></i>
                <span>Usuários</span>
            </a>

            <a href="{{ route('dashboard.index') }}"
               class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard.index') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-chart-bar mr-3"></i>
                <span>Vendas</span>
            </a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex flex-col flex-1">
        {{-- Header --}}
        <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
            <div class="flex items-center space-x-4">
                <button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                    <span class="sr-only">Notifications</span>
                    <i class="fas fa-bell"></i>
                </button>
                {{-- Profile Dropdown --}}
                <div class="relative">
                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                        <img class="w-8 h-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="">
                    </button>

                    <div class="hidden absolute right-0 w-48 mt-2 py-1 bg-white rounded-md shadow-lg">
                        <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Perfil
                        </a>
                        <form method="POST" action="{{ route('dashboard.auth.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
