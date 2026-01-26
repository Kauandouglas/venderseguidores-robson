<?php


use App\Http\Controllers\Forgot\ForgotController;
use App\Http\Controllers\Panel\ApiProviderController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\ConfigPreviewStoreController;
use App\Http\Controllers\Panel\ConfigTemplateController;
use App\Http\Controllers\Panel\ConversionTagController;
use App\Http\Controllers\Panel\DiscountCouponController;
use App\Http\Controllers\Panel\DomainController;
use App\Http\Controllers\Panel\PaymentController;
use App\Http\Controllers\Panel\PlanController;
use App\Http\Controllers\Panel\PurchaseController;
use App\Http\Controllers\Panel\WhatsappController;
use App\Http\Controllers\Panel\ServiceController;
use App\Http\Controllers\Panel\ServiceDescountController;
use App\Http\Controllers\Panel\EmailTemplateController;
use App\Http\Controllers\Panel\SystemSettingController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\CopyDataController;
use App\Http\Controllers\Web\SystemSettingController as SystemSettingControllerWeb;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['role:1']], function () {
    require __DIR__ . '/admin.php';
});

// Login
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.auth.login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.auth.login.post');
});


// Forgot
Route::middleware('guest')->group(function () {
    Route::get('/esqueceu-a-senha', [ForgotController::class, 'passwordRequest'])->name('password.request');
    Route::post('/esqueceu-a-senha', [ForgotController::class, 'passwordEmail'])->name('password.email');
    Route::get('/alterar-senha/{token}', [ForgotController::class, 'passwordReset'])->name('password.reset');
    Route::post('/alterar-senha', [ForgotController::class, 'passwordUpdate'])->name('password.update');
});

// Web
Route::group(['as' => 'web.'], function () {
    Route::get('/', [WebController::class, 'home'])->name('home')->middleware('guest');
});

// Panel
Route::group(['as' => 'panel.', 'prefix' => 'painel'], function () {
    Route::get('/entrar', [AuthController::class, 'formLogin'])->name('auth.formLogin');
    Route::post('/entrar', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/sair', [AuthController::class, 'logout'])->name('auth.logout');

    // Users
    Route::post('/cadastro', [UserController::class, 'store'])->name('users.store');
    Route::get('/verificar-dominio', [UserController::class, 'verifyDomain'])->name('users.verifyDomain');

    Route::middleware('role:2')->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('index');

        Route::group(['prefix' => 'configuracao'], function () {
            // Api Providers
            Route::resource('provedor-de-api', ApiProviderController::class)
                ->parameters(['provedor-de-api' => 'apiProvider'])->names('apiProviders')->except( 'show', 'destroy');

            // System Settings
            Route::get('/sistema', [SystemSettingController::class, 'edit'])->name('systemSettings.edit');
            Route::put('/sistema', [SystemSettingController::class, 'update'])->name('systemSettings.update');

            // Config Templates
            Route::get('/template', [ConfigTemplateController::class, 'edit'])->name('configTemplates.edit');
            Route::put('/template', [ConfigTemplateController::class, 'update'])->name('configTemplates.update');
            Route::get('/template/removeImage', [ConfigTemplateController::class, 'removeImage'])->name('configTemplates.removeImage');

            // Payments
            Route::get('/pagamentos', [PaymentController::class, 'edit'])->name('payments.edit');
            Route::put('/pagamentos', [PaymentController::class, 'update'])->name('payments.update');
        });

        // Whatsapp
        Route::group(['prefix' => 'whatsapp'], function () {
            Route::get('/', [WhatsappController::class, 'index'])->name('whatsapp.index');
            Route::post('/ativar', [WhatsappController::class, 'activate'])->name('whatsapp.activate');
            Route::post('/desconectar', [WhatsappController::class, 'disconnect'])->name('whatsapp.disconnect');
        });

        // Categories
        Route::post('/categorias/ordem', [CategoryController::class, 'order'])->name('categories.order');
        Route::resource('categorias', CategoryController::class)
            ->parameters(['categorias' => 'category'])->names('categories')->except('show');

        // Services
        Route::post('/servicos/ordem', [ServiceController::class, 'order'])->name('services.order');
        Route::post('/servicos/status/{service}', [ServiceController::class, 'status'])->name('services.status');
        Route::post('/servicos/provedores', [ServiceController::class, 'providerService'])
            ->name('services.providerService');
        Route::post('/servicos/{service}/clonar', [ServiceController::class, 'clone'])->name('services.clone');
        Route::resource('servicos', ServiceController::class)
            ->parameters(['servicos' => 'service'])->names('services')->except('show');

        // Purchases
        Route::get('/compras', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::post('/compras/reenviarOrdem/{purchase}', [PurchaseController::class, 'sendOrder'])->name('purchases.sendOrder');

        // Users
        Route::get('/editar-perfil', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/editar-perfil', [UserController::class, 'update'])->name('users.update');
        Route::post('/desativar-popup', [UserController::class, 'disablePopup'])->name('users.disablePopup');

        // Plans
        Route::get('/planos', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/planos/verificar', [PlanController::class, 'verify'])->name('plans.verify');
        Route::get('/planos/{plan}', [PlanController::class, 'signed'])->name('plans.signed');
        Route::post('/planos/processar/{plan}', [PlanController::class, 'processSigned'])->name('plans.processSigned');

        // Domains
        Route::get('/dominios', [DomainController::class, 'create'])->name('domains.create');
        Route::post('/dominios', [DomainController::class, 'store'])->name('domains.store');

        // Config Preview
        Route::get('/configuracao-preview/{step}', [ConfigPreviewStoreController::class, 'create'])->name('configPreviews.create');
        Route::post('/configuracao-preview/{step}', [ConfigPreviewStoreController::class, 'store'])->name('configPreviews.store');

        // Conversion Tags
        Route::get('/tags-conversao', [ConversionTagController::class, 'edit'])->name('conversionTags.edit');
        Route::put('/tags-conversao', [ConversionTagController::class, 'update'])->name('conversionTags.update');

        // Service Descounts
        Route::resource('descontos-servicos', ServiceDescountController::class)
            ->parameters(['descontos-servicos' => 'serviceDescount'])->names('serviceDescounts')->except('show');

        Route::resource('cupom-desconto', DiscountCouponController::class)
            ->parameters(['cupom-desconto' => 'discountCoupon'])->names('discountCoupons')->except('show');

        // Email Templates
        Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('emailTemplates.index');
        Route::get('/email-templates/{emailTemplate}/editar', [EmailTemplateController::class, 'edit'])->name('emailTemplates.edit');
        Route::put('/email-templates/{emailTemplate}', [EmailTemplateController::class, 'update'])->name('emailTemplates.update');
        Route::post('/email-templates/{emailTemplate}/toggle-active', [EmailTemplateController::class, 'toggleActive'])->name('emailTemplates.toggleActive');

        // Copy Data from Template User
        Route::post('/copiar-categorias-servicos', [CopyDataController::class, 'copyFromTemplate'])->name('copyData.copyFromTemplate');
    });
});

// Web
Route::group(['as' => 'web.'], function () {
    Route::view('/tutoriais', 'web.tutorial')->name('tutorials');

    // System Settings
    Route::get('/{domain}', [SystemSettingControllerWeb::class, 'template'])->name('systemSettings.template');
    Route::get('/{domain}/{service}/{quantity?}', [\App\Http\Controllers\Api\ServiceController::class, 'show'])->name('services.show');
});
