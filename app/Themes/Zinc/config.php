<?php

return [
    'name' => 'Zinc Theme',
    'version' => '1.0.0',
    'author' => 'Original Author',
    'description' => 'Tema Zinc original do sistema',

    'colors' => [
        'primary' => '#3b82f6',
        'secondary' => '#8b5cf6',
        'accent' => '#f59e0b',
        'success' => '#10b981',
        'danger' => '#ef4444',
        'warning' => '#f59e0b',
        'info' => '#3b82f6',
    ],

    'features' => [
        'dark_mode' => false,
        'rtl_support' => false,
        'animations' => true,
        'responsive' => true,
        'custom_colors' => true,
    ],

    'layouts' => [
        'home' => 'zinc::layouts.home',
        'product' => 'zinc::layouts.product',
        'cart' => 'zinc::layouts.cart',
        'checkout' => 'zinc::layouts.checkout',
    ],

    'components' => [
        'header' => 'zinc::components.header',
        'footer' => 'zinc::components.footer',
        'product-card' => 'zinc::components.product-card',
        'cart-item' => 'zinc::components.cart-item',
    ],

    'settings' => [
        'show_logo' => true,
        'show_search' => true,
        'show_categories' => true,
        'products_per_page' => 12,
    ],
];
