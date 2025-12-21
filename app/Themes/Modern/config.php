<?php

return [
    'name' => 'Modern Theme',
    'version' => '1.0.0',
    'author' => 'Painel SMM Team',
    'description' => 'Tema moderno com Tailwind CSS',

    'colors' => [
        'primary' => '#3b82f6',
        'secondary' => '#8b5cf6',
        'accent' => '#06b6d4',
        'success' => '#10b981',
        'danger' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6',
        'dark' => '#1f2937',
        'light' => '#f9fafb',
    ],

    'features' => [
        'dark_mode' => true,
        'rtl_support' => false,
        'animations' => true,
        'responsive' => true,
        'custom_colors' => true,
        'gradient_support' => true,
        'blur_effects' => true,
    ],

    'layouts' => [
        'home' => 'modern::layouts.home',
        'product' => 'modern::layouts.product',
        'cart' => 'modern::layouts.cart',
        'checkout' => 'modern::layouts.checkout',
        'about' => 'modern::layouts.about',
        'contact' => 'modern::layouts.contact',
    ],

    'components' => [
        'header' => 'modern::components.header',
        'footer' => 'modern::components.footer',
        'product-card' => 'modern::components.product-card',
        'cart-item' => 'modern::components.cart-item',
        'category-card' => 'modern::components.category-card',
        'testimonial' => 'modern::components.testimonial',
        'cta-section' => 'modern::components.cta-section',
    ],

    'settings' => [
        'show_logo' => true,
        'show_search' => true,
        'show_categories' => true,
        'show_testimonials' => true,
        'show_stats' => true,
        'products_per_page' => 12,
        'enable_lazy_loading' => true,
    ],

    'typography' => [
        'font_family' => 'Inter, system-ui, sans-serif',
        'heading_weight' => '700',
        'body_weight' => '400',
    ],
];
