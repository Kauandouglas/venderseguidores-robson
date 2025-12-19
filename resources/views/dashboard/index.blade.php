<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white">
        <div class="px-6 py-4">
            <div class="flex items-center">
                <span class="text-xl font-bold">Dashboard</span>
            </div>
        </div>

        <nav class="mt-6">
            <a href="#" class="flex items-center px-6 py-3 bg-blue-800">
                <i class="fas fa-home mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-800">
                <i class="fas fa-users mr-3"></i>
                <span>Usuários</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-800">
                <i class="fas fa-chart-line mr-3"></i>
                <span>Vendas</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-800">
                <i class="fas fa-store mr-3"></i>
                <span>Lojas</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-800">
                <i class="fas fa-cog mr-3"></i>
                <span>Configurações</span>
            </a>
            <a href="#" class="flex items-center px-6 py-3 hover:bg-blue-800">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span>Sair</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <header class="bg-white shadow">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Visão Geral</h1>
                    <p class="text-sm text-gray-600">Bem-vindo de volta, Admin</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="Profile">
                </div>
            </div>
        </header>

        <div class="p-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Users Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Usuários Ativos</p>
                            <p class="text-2xl font-bold">2,450</p>
                            <p class="text-sm text-green-500">+12.5% vs mês anterior</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full">
                            <i class="fas fa-users text-blue-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Sales Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Vendas do Mês</p>
                            <p class="text-2xl font-bold">1,234</p>
                            <p class="text-sm text-green-500">+15.2% vs mês anterior</p>
                        </div>
                        <div class="p-3 bg-purple-100 rounded-full">
                            <i class="fas fa-shopping-cart text-purple-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Stores Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Lojas Ativas</p>
                            <p class="text-2xl font-bold">156</p>
                            <p class="text-sm text-green-500">+5.4% vs mês anterior</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-full">
                            <i class="fas fa-store text-green-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue Card -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Receita Mensal</p>
                            <p class="text-2xl font-bold">R$ 67.000</p>
                            <p class="text-sm text-green-500">+22.5% vs mês anterior</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-full">
                            <i class="fas fa-dollar-sign text-red-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Vendas Mensais</h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">Mês</button>
                            <button class="px-3 py-1 text-sm hover:bg-gray-100 rounded-full">Ano</button>
                        </div>
                    </div>
                    <div style="height: 300px">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">Desempenho por Mês</h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">Mês</button>
                            <button class="px-3 py-1 text-sm hover:bg-gray-100 rounded-full">Ano</button>
                        </div>
                    </div>
                    <div style="height: 300px">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const mockData = {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        values: [45000, 52000, 48000, 61000, 55000, 67000]
    };

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    };

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: mockData.labels,
            datasets: [{
                data: mockData.values,
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#fff'
            }]
        },
        options: commonOptions
    });

    new Chart(document.getElementById('performanceChart'), {
        type: 'bar',
        data: {
            labels: mockData.labels,
            datasets: [{
                data: mockData.values,
                backgroundColor: '#3B82F6',
                borderRadius: 4,
                maxBarThickness: 40
            }]
        },
        options: commonOptions
    });
</script>
</body>
</html>
