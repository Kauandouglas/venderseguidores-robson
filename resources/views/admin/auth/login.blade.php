<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Painel Administrativo</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-container {
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 10;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .header-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .icon-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .input-field {
            @apply w-full px-5 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-300;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .input-field:focus {
            @apply shadow-xl;
            transform: translateY(-2px);
        }
        
        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s;
        }
        
        .input-field:focus ~ .input-icon {
            color: #667eea;
        }
        
        .btn-login {
            @apply w-full px-6 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white font-bold rounded-xl transition-all duration-300;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
            font-size: 16px;
            letter-spacing: 0.5px;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .checkbox-custom {
            @apply w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 cursor-pointer transition-all duration-200;
        }
        
        .checkbox-custom:checked {
            animation: checkboxPop 0.3s ease;
        }
        
        @keyframes checkboxPop {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .error-alert {
            animation: shake 0.5s ease;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .info-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: fadeInUp 1s ease 0.5s both;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .particle-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: floatRandom 20s ease-in-out infinite;
        }
        
        @keyframes floatRandom {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, -50px) rotate(90deg); }
            50% { transform: translate(-30px, 30px) rotate(180deg); }
            75% { transform: translate(30px, 50px) rotate(270deg); }
        }
        
        .label-animate {
            transition: all 0.3s ease;
        }
        
        .input-field:focus ~ .label-animate,
        .input-field:not(:placeholder-shown) ~ .label-animate {
            transform: translateY(-28px) scale(0.85);
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Floating Shapes Background -->
    <div class="particle-bg">
        <div class="floating-shape" style="width: 300px; height: 300px; top: 10%; left: 5%; animation-delay: 0s;"></div>
        <div class="floating-shape" style="width: 200px; height: 200px; top: 60%; right: 10%; animation-delay: 2s;"></div>
        <div class="floating-shape" style="width: 150px; height: 150px; bottom: 10%; left: 15%; animation-delay: 4s;"></div>
    </div>

    <div class="login-container w-full max-w-md mx-4">
        <!-- Card -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <!-- Header -->
            <div class="header-gradient px-8 py-10 text-center relative">
                <div class="icon-container w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-5 relative z-10">
                    <i class="fas fa-shield-halved text-indigo-600 text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-3 relative z-10">Painel Admin</h1>
                <p class="text-indigo-100 text-lg relative z-10">Acesso restrito a administradores</p>
            </div>

            <!-- Form -->
            <div class="px-8 py-10">
                @if ($errors->any())
                    <div class="error-alert mb-6 p-5 bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-200 rounded-xl">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-0.5"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-red-800 text-lg">Erro ao fazer login</p>
                                @foreach ($errors->all() as $error)
                                    <p class="text-sm text-red-700 mt-2">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.auth.login') }}" method="POST" class="space-y-7">
                    @csrf

                    <!-- Email -->
                    <div class="relative">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2.5 flex items-center">
                            <i class="fas fa-envelope text-indigo-600 mr-2"></i> 
                            <span>Endereço de Email</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="input-field @error('email') border-red-400 @enderror"
                                placeholder="seu@email.com"
                                required
                                autofocus
                            >
                            <i class="fas fa-at input-icon"></i>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2.5 flex items-center">
                            <i class="fas fa-lock text-indigo-600 mr-2"></i>
                            <span>Senha de Acesso</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="input-field @error('password') border-red-400 @enderror"
                                placeholder="••••••••••••"
                                required
                            >
                            <i class="fas fa-key input-icon"></i>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-2">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="checkbox-custom"
                        >
                        <label for="remember" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer select-none">
                            Manter-me conectado neste dispositivo
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login mt-8">
                        <span class="relative z-10 flex items-center justify-center font-semibold tracking-wide">
                            <i class="fas fa-sign-in-alt mr-2"></i> 
                            Acessar Painel
                        </span>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-indigo-50 border-t-2 border-gray-100 text-center">
                <p class="text-sm text-gray-700 font-medium flex items-center justify-center">
                    <i class="fas fa-shield-alt text-indigo-600 mr-2"></i> 
                    Conexão segura com criptografia SSL
                </p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="info-box mt-6 rounded-2xl p-5 text-white text-center shadow-xl">
            <p class="text-sm font-medium flex items-center justify-center">
                <i class="fas fa-info-circle text-xl mr-3"></i>
                <span>Apenas administradores autorizados podem acessar este painel</span>
            </p>
        </div>
    </div>

    <!-- Enhanced Background Animation -->
    <script>
        const canvas = document.createElement('canvas');
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.zIndex = '0';
        canvas.style.pointerEvents = 'none';
        document.body.appendChild(canvas);

        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        const particleCount = 80;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 4 + 1;
                this.speedX = Math.random() * 0.8 - 0.4;
                this.speedY = Math.random() * 0.8 - 0.4;
                this.opacity = Math.random() * 0.6 + 0.2;
                this.color = `rgba(255, 255, 255, ${this.opacity})`;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }

            draw() {
                ctx.fillStyle = this.color;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        function connectParticles() {
            for (let a = 0; a < particles.length; a++) {
                for (let b = a + 1; b < particles.length; b++) {
                    const dx = particles[a].x - particles[b].x;
                    const dy = particles[a].y - particles[b].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 120) {
                        ctx.strokeStyle = `rgba(255, 255, 255, ${0.15 * (1 - distance / 120)})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particles[a].x, particles[a].y);
                        ctx.lineTo(particles[b].x, particles[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            connectParticles();

            requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>