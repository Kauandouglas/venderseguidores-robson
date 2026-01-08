<?php

use App\Http\Controllers\Api\CartProductController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\EvolutionWebhookController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SystemSettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function () {
    // Service
    Route::prefix('validateInstagram')->group(function () {
        Route::post('validate-user', [ServiceController::class, 'validateUser']);
        Route::post('validate-post', [ServiceController::class, 'validatePost']);
        Route::post('list-posts', [ServiceController::class, 'listPosts']);
    });

    Route::prefix('validateTiktok')->group(function () {
        Route::post('validate-user', [ServiceController::class, 'validateTiktokUser']);
        Route::post('validate-post', [ServiceController::class, 'validateTiktokPost']);
        Route::post('list-posts', [ServiceController::class, 'listTiktokPosts']);
    });

    // System Settings
    Route::post('/carinho/{domain}/{service}', [SystemSettingController::class, 'addCart'])->name('systemSettings.addCart');

    // Cart Products
    Route::get('/carinho/{domain}', [CartProductController::class, 'index'])->name('cartProducts.index');
    Route::get('/carrinho/produtos/{domain}', [CartProductController::class, 'fragmentIndex'])->name('carts.fragmentIndex');
    Route::post('/carinho/link/{cartProduct}/{domain}', [CartProductController::class, 'addLink'])->name('cartProducts.addLink');
    Route::post('/carinho/comment/{cartProduct}/{domain}', [CartProductController::class, 'addComment'])->name('cartProducts.addComment');
    Route::delete('/carinho/remover/{cartProduct}/{domain}', [CartProductController::class, 'destroy'])->name('cartProducts.destroy');
    Route::post('/carrinho/addCoupon/{domain}', [CartProductController::class, 'addCoupon'])->name('cartProducts.addCoupon');

    // Purchases
    Route::post('/finalizar-compra/{domain}', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/finalizar-compra/status',  [PurchaseController::class, 'status'])->name('purchases.status');
    Route::post('/notification-template', [PurchaseController::class, 'notificationTemplate'])->name('purchases.notificationTemplate');
    Route::get('/compras/historic', [PurchaseController::class, 'historic'])->name('purchases.historic');

    // Plan
    Route::post('/plan/notification', [PlanController::class, 'notification'])->name('plans.notification');
});

// Webhooks de Pagamento
Route::post('/webhooks/pushinpay', [\App\Http\Controllers\Api\PurchaseController::class, 'pushinpayWebhook'])->name('webhooks.pushinpay');

// Webhook Evolution API
Route::post('/webhooks/evolution/{instanceName}', [EvolutionWebhookController::class, 'handle'])->name('api.webhooks.evolution');
