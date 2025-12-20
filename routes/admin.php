<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Rotas do painel administrativo
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Users
Route::resource('users', UserController::class);
Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

// Orders
Route::resource('orders', OrderController::class)->only(['index', 'show']);
Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
Route::post('orders/{order}/reprocess', [OrderController::class, 'reprocess'])->name('orders.reprocess');
Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');

// Themes
Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
Route::get('themes/{identifier}', [ThemeController::class, 'show'])->name('themes.show');
Route::get('themes/{identifier}/preview', [ThemeController::class, 'preview'])->name('themes.preview');

// Payment Gateways
Route::get('payment-gateways', [PaymentGatewayController::class, 'index'])->name('payment-gateways.index');
Route::get('payment-gateways/{identifier}', [PaymentGatewayController::class, 'show'])->name('payment-gateways.show');
Route::get('payment-gateways/{identifier}/configure', [PaymentGatewayController::class, 'configure'])->name('payment-gateways.configure');
Route::post('payment-gateways/{identifier}/configure', [PaymentGatewayController::class, 'saveConfiguration'])->name('payment-gateways.save-configuration');
Route::post('payment-gateways/{identifier}/test', [PaymentGatewayController::class, 'testConnection'])->name('payment-gateways.test');

// Settings
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
Route::post('settings/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clear-cache');
Route::post('settings/optimize', [SettingController::class, 'optimizeSystem'])->name('settings.optimize');

// Services
Route::get('services', function() {
    return view('admin.services.index');
})->name('services.index');

// Categories
Route::get('categories', function() {
    return view('admin.categories.index');
})->name('categories.index');

// Plans
Route::get('plans', function() {
    return view('admin.plans.index');
})->name('plans.index');

// Domains
Route::get('domains', function() {
    return view('admin.domains.index');
})->name('domains.index');

// WhatsApp Instances
Route::get('whatsapp', function() {
    return view('admin.whatsapp.index');
})->name('whatsapp.index');
