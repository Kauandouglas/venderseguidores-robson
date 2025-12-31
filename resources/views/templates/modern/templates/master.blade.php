<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título da página --}}
    <title>{{ $systemSetting->title ?? config('template.title') }} - Home</title>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ $systemSetting->url_favicon ?? asset('images/default-favicon.ico') }}">

    {{-- Meta básicos --}}
    <meta name="title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta name="description" content="{{ $systemSetting->description ?? config('template.description') ?? '' }}">
    <meta name="keywords" content="{{ $systemSetting->keyword ?? '' }}">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Portuguese">
    <meta name="author" content="{{ $systemSetting->title ?? config('template.title') }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta property="og:description" content="{{ $systemSetting->description ?? '' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:image" content="{{ $systemSetting?->logo ? Storage::url($systemSetting->logo) : asset('images/default-logo.png') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $systemSetting->title ?? config('template.title') }} - Home">
    <meta name="twitter:description" content="{{ $systemSetting->description ?? '' }}">
    <meta name="twitter:image" content="{{ $systemSetting?->logo ? Storage::url($systemSetting->logo) : asset('images/default-logo.png') }}">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->full() }}" />

    <style>
        /* ============================================
           VARIÁVEIS DE TEMA
           ============================================ */
        :root {
            /* Tema Escuro (padrão) */
            --bg-primary: linear-gradient(135deg, #0a1628 0%, #1a2332 50%, #2d1b4e 100%);
            --bg-card: rgba(15, 23, 42, 0.6);
            --bg-card-hover: rgba(15, 23, 42, 0.95);
            --bg-platform: rgba(30, 41, 59, 0.8);
            --bg-platform-hover: rgba(30, 41, 59, 0.95);
            --bg-package: linear-gradient(135deg, rgba(30, 41, 59, 0.9), rgba(15, 23, 42, 0.9));
            --text-primary: #fff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: rgba(71, 85, 105, 0.3);
            --border-active: #3b82f6;
            --shadow-color: rgba(0, 0, 0, 0.3);
            --shadow-hover: rgba(59, 130, 246, 0.3);
            --star-color: #fff;
            --star-opacity: 0.3;
        }

        [data-theme="light"] {
            /* Tema Claro */
            --bg-primary: linear-gradient(135deg, #f0f4ff 0%, #e8eeff 50%, #f5f0ff 100%);
            --bg-card: rgba(81, 119, 246, 0.21);
            --bg-card-hover: rgba(255, 255, 255, 1);
            --bg-platform: rgba(248, 250, 252, 0.95);
            --bg-platform-hover: rgba(241, 245, 249, 1);
            --bg-package: linear-gradient(135deg, rgba(248, 250, 252, 0.95), rgba(241, 245, 249, 0.95));
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: rgba(203, 213, 225, 0.5);
            --border-active: #3b82f6;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --shadow-hover: rgba(59, 130, 246, 0.2);
            --star-color: #cbd5e1;
            --star-opacity: 0.2;
        }

        /* ============================================
           RESET E ESTILOS BÁSICOS
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* ============================================
           BOTÃO DE ALTERNÂNCIA DE TEMA
           ============================================ */
        .theme-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            width: 50px;
            height: 50px;
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10001;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            border-color: var(--border-active);
        }

        .theme-toggle i {
            font-size: 1.3rem;
            color: var(--text-primary);
            transition: transform 0.3s ease;
        }

        .theme-toggle:hover i {
            transform: rotate(20deg);
        }

        /* ============================================
           ESTRELAS DE FUNDO
           ============================================ */
        .stars {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--star-color);
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: var(--star-opacity); }
            50% { opacity: 1; }
        }

        /* ============================================
           CONTROLE DE PÁGINAS
           ============================================ */
        .page {
            display: none;
        }

        .page.active {
            display: block;
        }

        /* ============================================
           CONTAINER PRINCIPAL
           ============================================ */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        h1 {
            text-align: center;
            font-size: 2.8rem;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #4a9eff, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            text-align: center;
            color: var(--text-secondary);
            margin-bottom: 60px;
            font-size: 1.1rem;
        }

        /* ============================================
           PÁGINA 1: SELEÇÃO DE PLATAFORMA
           ============================================ */
        .platform-container {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px;
            border-top: 3px solid;
            border-image: linear-gradient(90deg, #3b82f6, #a78bfa) 1;
            box-shadow: 0 10px 40px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .platform-container h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .platform-description {
            text-align: center;
            color: var(--text-secondary);
            margin-bottom: 25px;
        }

        .platforms {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .platform-item {
            background: var(--bg-platform);
            border: 2px solid var(--border-color);
            border-radius: 15px;
            padding: 15px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .platform-item:hover {
            transform: translateY(-5px);
            border-color: var(--border-active);
            background: var(--bg-platform-hover);
            box-shadow: 0 10px 30px var(--shadow-hover);
        }

        .platform-item.selected {
            border-color: var(--border-active);
            background: rgba(59, 130, 246, 0.2);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #8b5cf6, #6366f1);
            color: #fff;
            padding: 5px 15px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .platform-icon {
            font-size: 2rem;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .platform-name {
            font-size: 17px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .next-btn {
            display: block;
            margin: 0 auto;
            padding: 15px 50px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .next-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.6);
        }

        .footer-text {
            text-align: center;
            color: var(--text-muted);
            margin-top: 30px;
            font-size: 0.95rem;
        }

        /* ============================================
           PÁGINA 2: CATEGORIAS E PACOTES
           ============================================ */
        .tabs {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .categories-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.5rem;
            color: var(--text-primary);
        }

        .tab-header {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 24px;
            background: var(--bg-platform);
            border: 1px solid var(--border-color);
            border-radius: 25px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .tab-btn.active {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            border-color: transparent;
        }

        .tab-btn:hover {
            transform: translateY(-2px);
            background: rgba(59, 130, 246, 0.3);
            color: var(--text-primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .tab-content h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .tab-description {
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .tab-description .check {
            color: #10b981;
            margin-right: 5px;
        }

        .packages {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .package-card {
            background: var(--bg-package);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
        }

        .package-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-active);
            box-shadow: 0 10px 30px var(--shadow-hover);
        }

        .badge {
            position: absolute;
            top: 20px;
            right: -30px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            padding: 5px 40px;
            font-size: 0.75rem;
            font-weight: bold;
            transform: rotate(45deg);
        }

        .package-amount {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .package-label {
            color: var(--text-secondary);
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .package-price {
            font-size: 1.8rem;
            font-weight: bold;
            color: #3b82f6;
        }

        /* ============================================
           PACOTE DESTACADO
           ============================================ */
        .package-card.highlighted {
            border: 3px solid #ffc107;
            transform: scale(1.08);
            box-shadow: 0 20px 50px rgba(255, 193, 7, 0.6);
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(30, 41, 59, 0.95));
            z-index: 10;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        [data-theme="light"] .package-card.highlighted {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(248, 250, 252, 0.95));
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 20px 50px rgba(255, 193, 7, 0.6);
            }
            50% {
                box-shadow: 0 25px 60px rgba(255, 193, 7, 0.8);
            }
        }

        .package-card.highlighted:hover {
            transform: scale(1.1) translateY(-8px);
            border-color: #ff9800;
        }

        .highlight-badge {
            position: absolute;
            top: 14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #ffc107, #ff9800);
            color: #000;
            padding: 8px 29px;
            border-radius: 50px;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1.5px;
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.6);
            text-transform: uppercase;
            animation: badge-float 2s ease-in-out infinite;
            width: 180px;
            white-space: nowrap;
        }

        @keyframes badge-float {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

        .highlight-badge::before {
            content: '⭐';
            margin-right: 5px;
        }

        .highlight-badge::after {
            content: '⭐';
            margin-left: 5px;
        }

        /* ============================================
           BOTÃO VOLTAR
           ============================================ */
        .voltar-btn {
            padding: 12px 25px;
            background: var(--bg-platform);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            cursor: pointer;
            margin-bottom: 20px;
            transition: 0.3s;
            font-size: 1rem;
        }

        .voltar-btn:hover {
            background: var(--bg-platform-hover);
            border-color: var(--border-active);
            transform: translateY(-2px);
        }

        /* ============================================
           SEÇÃO DE VÍDEO
           ============================================ */
        .video-section {
            margin-top: 0px;
            padding: 60px 20px;
        }

        .video-container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(147, 51, 234, 0.2);
            box-shadow: 0 10px 40px var(--shadow-color);
        }

        /* ============================================
           SEÇÃO DE AVALIAÇÕES
           ============================================ */
        .testimonials-section {
            padding: 40px 0;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .testimonial-card {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(147, 51, 234, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(147, 51, 234, 0.3);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .avatar-wrapper {
            position: relative;
        }

        .avatar-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(147, 51, 234, 0.3);
        }

        .star-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 11px;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .user-role {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .rating {
            display: flex;
            gap: 4px;
            margin-bottom: 18px;
            font-size: 1rem;
            color: #fbbf24;
        }

        .quote-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .quote-icon {
            position: absolute;
            top: -8px;
            left: -8px;
            font-size: 2rem;
            color: rgba(147, 51, 234, 0.2);
        }

        .testimonial-text {
            color: var(--text-secondary);
            line-height: 1.6;
            font-size: 0.9rem;
            padding-left: 15px;
        }

        .verified-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 25px;
            color: #10b981;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .verified-badge i {
            font-size: 0.9rem;
        }

        /* ============================================
           NOTIFICAÇÕES DE COMPRAS
           ============================================ */
        #notificationsContainer {
            position: fixed;
            top: 20px;
            left: 90px;
            z-index: 10000;
            pointer-events: none;
        }

        .notification-popup {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 8px 24px var(--shadow-color);
            margin-bottom: 10px;
            min-width: 280px;
            max-width: 320px;
            animation: slideInLeft 0.5s ease-out;
            pointer-events: auto;
            border-left: 4px solid #8b5cf6;
            border: 1px solid var(--border-color);
        }

        [data-theme="light"] .notification-popup {
            background: rgba(255, 255, 255, 0.98);
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .notification-popup.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        @keyframes fadeOut {
            to {
                transform: translateX(-400px);
                opacity: 0;
            }
        }

        .notification-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
        }

        .notification-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
            margin-bottom: 2px;
        }

        .notification-action {
            color: var(--text-secondary);
            font-size: 13px;
        }

        .notification-time {
            color: var(--text-muted);
            font-size: 11px;
            white-space: nowrap;
            align-self: flex-start;
        }

        .notification-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .notification-close:hover {
            color: var(--text-secondary);
        }

        /* ============================================
           BOTÃO WHATSAPP
           ============================================ */
        .whatsapp-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            transition: all 0.3s;
            z-index: 9999;
            text-decoration: none;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
        }

        .whatsapp-icon {
            font-size: 2rem;
            color: #fff;
        }

        /* ============================================
           ESTILOS DO FAQ
           ============================================ */
        .faq-section {
            position: relative;
            z-index: 1;
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: var(--border-active);
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .faq-question {
            width: 100%;
            padding: 20px 25px;
            background: transparent;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            text-align: left;
            color: var(--text-primary);
            font-size: 1.05rem;
            font-weight: 600;
            transition: all 0.3s ease;
            gap: 15px;
        }

        .faq-question:hover {
            color: var(--border-active);
        }

        .faq-question span {
            flex: 1;
        }

        .faq-icon {
            color: var(--border-active);
            font-size: 1rem;
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            padding: 0 25px;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 25px 20px 25px;
        }

        .faq-answer p {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 0.95rem;
            margin: 0;
        }

        /* ============================================
           MODAL DE PEDIDOS
           ============================================ */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-pedidos {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 10002;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-pedidos.active {
            display: flex;
        }

        .modal-content {
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 90%;
            max-height: 85vh;
            box-shadow: 0 20px 60px var(--shadow-color);
            position: relative;
            animation: slideUp 0.4s ease;
            overflow-y: auto;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 24px;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
            z-index: 1;
        }

        .modal-close:hover {
            background: var(--bg-platform);
            color: var(--text-primary);
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
        }

        .modal-icon i {
            font-size: 32px;
            color: white;
        }

        .modal-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #4a9eff, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .modal-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group label {
            display: block;
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group label i {
            margin-right: 8px;
            color: var(--border-active);
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: var(--bg-platform);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--border-active);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .modal-submit {
            padding: 14px 30px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .modal-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.6);
        }

        .modal-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .modal-info {
            margin-top: 25px;
            padding: 15px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .modal-info i {
            color: #3b82f6;
            font-size: 18px;
            margin-top: 2px;
        }

        .modal-info p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 0;
        }

        /* ============================================
           LISTA DE PEDIDOS NO MODAL
           ============================================ */
        #pedidosLista {
            display: none;
        }

        #pedidosLista.show {
            display: block;
        }

        .pedidos-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .pedido-item {
            background: var(--bg-platform);
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s;
        }

        .pedido-item:hover {
            border-color: var(--border-active);
            box-shadow: 0 4px 15px var(--shadow-hover);
        }

        .pedido-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .pedido-numero {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .pedido-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-concluido {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-processando {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .status-pendente {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .pedido-detalhes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .detalhe-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detalhe-label {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .detalhe-valor {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .pedido-preco {
            color: #3b82f6;
            font-size: 1.2rem;
        }

        .pedido-data {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--text-secondary);
        }

        .btn-voltar-busca {
            margin-top: 20px;
            padding: 12px 24px;
            background: var(--bg-platform);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .btn-voltar-busca:hover {
            background: var(--bg-platform-hover);
            border-color: var(--border-active);
            transform: translateY(-2px);
        }

        /* ============================================
           RESPONSIVO
           ============================================ */
        @media (max-width: 768px) {
            h1 {
                font-size: 21px;
            }

            .subtitle {
                font-size: 14px;
                margin-bottom: 30px;
            }

            .package-amount {
                font-size: 2.5rem;
            }

            .packages {
                grid-template-columns: 1fr;
            }

            .platforms {
                grid-template-columns: repeat(2, 1fr);
            }

            .platform-container {
                padding: 10px 20px;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .testimonial-text {
                font-size: 0.85rem;
            }

            .user-name {
                font-size: 1rem;
            }

            .testimonial-card {
                padding: 25px;
            }

            #notificationsContainer {
                left: 10px;
                right: 10px;
                top: 80px;
            }

            .notification-popup {
                min-width: auto;
                max-width: calc(100vw - 20px);
            }

            .theme-toggle {
                width: 45px;
                height: 45px;
                top: 15px;
                left: 15px;
            }

            .theme-toggle i {
                font-size: 1.1rem;
            }

            .faq-question {
                padding: 18px 20px;
                font-size: 0.95rem;
            }

            .faq-answer {
                padding: 0 20px;
            }

            .faq-item.active .faq-answer {
                padding: 0 20px 18px 20px;
            }

            .faq-answer p {
                font-size: 0.9rem;
            }

            .modal-content {
                padding: 30px 20px;
                max-width: 95%;
            }

            .modal-title {
                font-size: 1.5rem;
            }

            .pedido-detalhes {
                grid-template-columns: 1fr;
            }

            .pedido-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    {!! $systemSetting->code ?? '' !!}

    @if(!empty($conversionTag->pixel_google_ads))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_google_ads }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $conversionTag->pixel_google_ads }}');
        </script>
    @endif

    @if(!empty($conversionTag->pixel_analytics))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $conversionTag->pixel_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $conversionTag->pixel_analytics }}');
        </script>
    @endif
</head>
<body>

    {{-- ============================================
        BOTÃO DE ALTERNÂNCIA DE TEMA
        ============================================ --}}
    <button class="theme-toggle" id="themeToggle" title="Alternar Tema">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    {{-- ============================================
        BOTÃO MEUS PEDIDOS
        ============================================ --}}
    <a href="#" onclick="event.preventDefault(); abrirModalPedidos();" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, rgb(59, 130, 246), rgb(139, 92, 246));
        color: rgb(255, 255, 255);
        padding: 12px 24px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: rgba(59, 130, 246, 0.4) 0px 4px 15px;
        text-decoration: none;
        z-index: 9999;
        transition: 0.3s;
    " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.6)'"
       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.4)'">
        <i class="fas fa-history"></i>
        <span>Meus Pedidos</span>
    </a>

    {{-- ============================================
        BOTÃO WHATSAPP FLUTUANTE
        ============================================ --}}
    <a href="https://wa.me/55{{ (isset($systemSetting->phone) ? clearString($systemSetting->phone) : config('template.phone')) }}"
       target="_blank"
       class="whatsapp-btn"
       title="Fale conosco no WhatsApp">
        <i class="fab fa-whatsapp whatsapp-icon"></i>
    </a>

    {{-- ============================================
        CONTAINER DE NOTIFICAÇÕES
        ============================================ --}}
    <div id="notificationsContainer"></div>

    {{-- ============================================
        ESTRELAS DE FUNDO
        ============================================ --}}
    <div class="stars" id="stars"></div>

    {{-- ============================================
        CONTEÚDO PRINCIPAL
        ============================================ --}}
    @yield('content')

    {{-- ============================================
        MODAL DE CONSULTA DE PEDIDOS
        ============================================ --}}
    <div id="modalPedidos" class="modal-pedidos">
        <div class="modal-content">
            {{-- Botão Fechar --}}
            <button class="modal-close" onclick="fecharModalPedidos()" title="Fechar">
                <i class="fas fa-times"></i>
            </button>

            {{-- FORMULÁRIO DE BUSCA --}}
            <div id="formBusca">
                {{-- Cabeçalho do Modal --}}
                <div class="modal-header">
                    <div class="modal-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h2 class="modal-title">Meus Pedidos</h2>
                    <p class="modal-description">
                        Digite seu email para consultar seus pedidos
                    </p>
                </div>

                {{-- Formulário --}}
                <form id="formConsultaPedidos" class="modal-form" onsubmit="consultarPedidos(event)">
                    <div class="form-group">
                        <label for="emailPedidos">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input
                            type="email"
                            id="emailPedidos"
                            name="email"
                            required
                            placeholder="seu@email.com"
                            autocomplete="email"
                        >
                    </div>

                    <button type="submit" class="modal-submit" id="btnBuscar">
                        <i class="fas fa-search"></i>
                        Buscar Pedidos
                    </button>
                </form>

                {{-- Informação Extra --}}
                <div class="modal-info">
                    <i class="fas fa-info-circle"></i>
                    <p>
                        Use o mesmo email que você forneceu ao fazer o pedido. Você receberá um histórico completo de todas as suas compras.
                    </p>
                </div>
            </div>

            {{-- LISTA DE PEDIDOS --}}
            <div id="pedidosLista">
                <div class="modal-header">
                    <div class="modal-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h2 class="modal-title">Seus Pedidos</h2>
                    <p class="modal-description" id="emailUsuario"></p>
                </div>

                <div id="pedidosContainer" class="pedidos-container">
                    {{-- Pedidos serão inseridos aqui via JavaScript --}}
                </div>

                <button onclick="voltarParaBusca()" class="btn-voltar-busca">
                    <i class="fas fa-arrow-left"></i> Buscar outro email
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================
        SCRIPTS
        ============================================ --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ============================================
        // CONFIGURAÇÃO AJAX
        // ============================================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // ============================================
        // MODAL DE PEDIDOS
        // ============================================
        function abrirModalPedidos() {
            const modal = document.getElementById('modalPedidos');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            // Garantir que está mostrando o formulário
            document.getElementById('formBusca').style.display = 'block';
            document.getElementById('pedidosLista').classList.remove('show');

            // Focar no input de email
            setTimeout(() => {
                document.getElementById('emailPedidos').focus();
            }, 300);
        }

        function fecharModalPedidos() {
            const modal = document.getElementById('modalPedidos');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';

            // Resetar formulário e view
            document.getElementById('formConsultaPedidos').reset();
            document.getElementById('formBusca').style.display = 'block';
            document.getElementById('pedidosLista').classList.remove('show');
        }

        function voltarParaBusca() {
            document.getElementById('formBusca').style.display = 'block';
            document.getElementById('pedidosLista').classList.remove('show');
            document.getElementById('formConsultaPedidos').reset();
        }

        // Fechar modal ao clicar fora
        document.getElementById('modalPedidos')?.addEventListener('click', function(e) {
            if (e.target === this) {
                fecharModalPedidos();
            }
        });

        // Fechar modal com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalPedidos');
                if (modal.classList.contains('active')) {
                    fecharModalPedidos();
                }
            }
        });

        // ============================================
        // CONSULTAR PEDIDOS
        // ============================================
        function consultarPedidos(event) {
            event.preventDefault();

            const email = document.getElementById('emailPedidos').value;
            const submitBtn = document.getElementById('btnBuscar');
            const originalHTML = submitBtn.innerHTML;

            // Mostrar loading no botão
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Buscando...';

            // Requisição AJAX
            $.ajax({
                url: '{{ route('api.purchases.historic') }}', // ALTERE PARA SUA ROTA
                method: 'POST',
                data: { email: email },
                success: function(response) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;

                    // Verificar se há pedidos
                    if (response.pedidos && response.pedidos.length > 0) {
                        // Exibir pedidos no modal
                        exibirPedidos(response.pedidos, email);
                    } else {
                        // Nenhum pedido encontrado
                        Swal.fire({
                            icon: 'info',
                            title: 'Nenhum pedido encontrado',
                            text: 'Não encontramos pedidos associados a este email.',
                            confirmButtonColor: '#3b82f6',
                            background: getComputedStyle(document.documentElement).getPropertyValue('--bg-card'),
                            color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary')
                        });
                    }
                },
                error: function(xhr) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;

                    // Mensagem de erro
                    let errorMessage = 'Não foi possível buscar os pedidos. Tente novamente.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: errorMessage,
                        confirmButtonColor: '#3b82f6',
                        background: getComputedStyle(document.documentElement).getPropertyValue('--bg-card'),
                        color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary')
                    });
                }
            });
        }

        // ============================================
        // EXIBIR PEDIDOS NO MODAL
        // ============================================
        function exibirPedidos(pedidos, email) {
            // Esconder formulário e mostrar lista
            document.getElementById('formBusca').style.display = 'none';
            document.getElementById('pedidosLista').classList.add('show');
            
            // Exibir email do usuário
            document.getElementById('emailUsuario').textContent = email;

            const container = document.getElementById('pedidosContainer');
            container.innerHTML = '';

            if (pedidos.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Nenhum pedido encontrado</h3>
                        <p>Você ainda não realizou nenhum pedido.</p>
                    </div>
                `;
                return;
            }

            pedidos.forEach(pedido => {
                const pedidoHtml = criarCardPedido(pedido);
                container.innerHTML += pedidoHtml;
            });
        }

        // ============================================
        // CRIAR CARD DE PEDIDO
        // ============================================
        function criarCardPedido(pedido) {
    // Determinar classe de status
    let statusClass = 'status-pendente';
    let statusTexto = 'Pendente';
    
    if (pedido.status === 'completed' || pedido.status === 'concluido') {
        statusClass = 'status-concluido';
        statusTexto = 'Concluído';
    } else if (pedido.status === 'processing' || pedido.status === 'processando') {
        statusClass = 'status-processando';
        statusTexto = 'Processando';
    } else if (pedido.status === 'pending') {
        statusClass = 'status-pendente';
        statusTexto = 'Pendente';
    }

    // Formatar preço
    const preco = pedido.price ? `R$ ${parseFloat(pedido.price).toFixed(2).replace('.', ',')}` : 'R$ 0,00';

    return `
        <div class="pedido-item">
            <div class="pedido-header">
                <div class="pedido-numero">
                    <i class="fas fa-receipt"></i> Pedido #${pedido.id}
                </div>
                <span class="pedido-status ${statusClass}">
                    ${statusTexto}
                </span>
            </div>
            
            <div class="pedido-detalhes">
                <div class="detalhe-item">
                    <span class="detalhe-label">
                        <i class="fas fa-user"></i> Nome
                    </span>
                    <span class="detalhe-valor">${pedido.name || '-'}</span>
                </div>
                
                <div class="detalhe-item">
                    <span class="detalhe-label">
                        <i class="fab fa-instagram"></i> Instagram
                    </span>
                    <span class="detalhe-valor">@${pedido.instagram || '-'}</span>
                </div>
                
                <div class="detalhe-item">
                    <span class="detalhe-label">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </span>
                    <span class="detalhe-valor">${pedido.whatsapp || '-'}</span>
                </div>
                
                <div class="detalhe-item">
                    <span class="detalhe-label">
                        <i class="fas fa-dollar-sign"></i> Valor
                    </span>
                    <span class="detalhe-valor pedido-preco">${preco}</span>
                </div>
            </div>
            
            <div class="pedido-data">
                <i class="far fa-clock"></i> ${pedido.created_at || '-'}
            </div>
        </div>
    `;
}
    </script>

    @stack('scripts')

</body>
</html>