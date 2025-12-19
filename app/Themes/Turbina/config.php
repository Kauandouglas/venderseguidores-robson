<?php

return [
    'name' => 'Turbina Theme',
    'version' => '1.0.0',
    'author' => 'Original Author',
    'description' => 'Tema Turbina - Design moderno e dinâmico',

    'colors' => [
        'primary' => '#6366f1',
        'secondary' => '#ec4899',
        'accent' => '#14b8a6',
        'success' => '#22c55e',
        'danger' => '#f43f5e',
        'warning' => '#eab308',
        'info' => '#06b6d4',
    ],

    'features' => [
        'dark_mode' => false,
        'rtl_support' => false,
        'animations' => true,
        'responsive' => true,
        'custom_colors' => true,
    ],

    'layouts' => [
        'home' => 'turbina::layouts.home',
        'product' => 'turbina::layouts.product',
        'cart' => 'turbina::layouts.cart',
        'checkout' => 'turbina::layouts.checkout',
    ],

    'components' => [
        'header' => 'turbina::components.header',
        'footer' => 'turbina::components.footer',
        'product-card' => 'turbina::components.product-card',
        'cart-item' => 'turbina::components.cart-item',
    ],

    'settings' => [
        'show_logo' => true,
        'show_search' => true,
        'show_categories' => true,
        'products_per_page' => 16,
    ],
];
