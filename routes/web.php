<?php

use App\Http\Controllers\BlingController;
use App\Http\Controllers\LogoutController;
use App\Http\Middleware\VerifyUserIsAdmin;
use App\Http\Middleware\VerifyUserIsCustomer;
use Illuminate\Support\Facades\Route;

// Home
use App\Livewire\Home\Index as HomeIndex;
use App\Livewire\Home\Show as HomeShow;
use App\Livewire\Home\Search as HomeSearch;

// Carrinho e Checkout
use App\Livewire\Cart\Index as CartIndex;
use App\Livewire\Cart\Customer as CartCustomer;
use App\Livewire\Cart\Confirm as CartConfirm;
use App\Livewire\Cart\Payment as CartPayment;

// Conta
use App\Livewire\Account\Login;
use App\Livewire\Account\Register;
use App\Livewire\Account\Access;

// Dashboard
use App\Livewire\Admin\Index as AdminIndex;

// Gerenciar categoria
use App\Livewire\Category\AdminIndex as AdminCategoryIndex;
use App\Livewire\Category\AdminShow as AdminCategoryShow;
use App\Livewire\Category\AdminCreate as AdminCategoryCreate;
use App\Livewire\Category\AdminUpdate as AdminCategoryUpdate;

// Gerenciar marca
use App\Livewire\Brand\AdminIndex as AdminBrandIndex;
use App\Livewire\Brand\AdminShow as AdminBrandShow;
use App\Livewire\Brand\AdminCreate as AdminBrandCreate;
use App\Livewire\Brand\AdminUpdate as AdminBrandUpdate;

// Área do cliente
use App\Livewire\Customer\Index as CustomerIndex;
use App\Livewire\Customer\Info as CustomerInfo;

// Gerenciar produto
use App\Livewire\Product\AdminIndex as AdminProductIndex;
use App\Livewire\Product\AdminShow as AdminProductShow;
use App\Livewire\Product\AdminCreate as AdminProductCreate;
use App\Livewire\Product\AdminUpdate as AdminProductUpdate;

// Gerenciar variação
use App\Livewire\Variation\AdminIndex as AdminVariationIndex;
use App\Livewire\Variation\AdminShow as AdminVariationShow;
use App\Livewire\Variation\AdminCreate as AdminVariationCreate;
use App\Livewire\Variation\AdminUpdate as AdminVariationUpdate;

// Gerenciar sku
use App\Livewire\Sku\AdminIndex as AdminSkuIndex;
use App\Livewire\Sku\AdminShow as AdminSkuShow;
use App\Livewire\Sku\AdminCreate as AdminSkuCreate;
use App\Livewire\Sku\AdminUpdate as AdminSkuUpdate;

// Gerenciar pedido
use App\Livewire\Order\AdminIndex as AdminOrderIndex;
use App\Livewire\Order\AdminShow as AdminOrderShow;
use Illuminate\Support\Facades\Request;

Route::get('/', HomeIndex::class)->name('home.index');
Route::get('/produto/{slug}', HomeShow::class)->name('home.show');
Route::get('/buscar', HomeSearch::class)->name('home.search');

// Rotas carrinho de compras
Route::group(['prefix' => 'carrinho'], function($route) {
    Route::get('/', CartIndex::class)->name('cart.index');
    Route::get('/cliente', CartCustomer::class)->name('cart.customer');
    Route::get('/confirmar', CartConfirm::class)->name('cart.confirm');
    Route::get('/pagamento', CartPayment::class)->name('cart.payment');
});

// Rotas webhook
Route::group(['prefix' => 'webhook'], function($route) {
    Route::post('/stripe', fn(Request $request) => Log::debug('Webhook Stripe', $request->all()));
})->withoutMiddleware(VerifyCsrfToken::class);

// Rotas callback
Route::group(['prefix' => 'callback'], function($route) {
    Route::get('/bling-auth', [BlingController::class, 'auth']);
})->withoutMiddleware(VerifyCsrfToken::class);

// Rotas para quem não está autenticado
Route::middleware('guest')->group(function($route) {
    Route::get('/login', Login::class)->name('login');
    Route::get('/cadastrar', Register::class)->name('register');
});

// Rotas para quem está autenticado
Route::middleware('auth')->group(function($route) {
    Route::get('/minha-conta', CustomerIndex::class)->name('customer.index')->middleware(VerifyUserIsCustomer::class);
    Route::get('/meus-dados', CustomerInfo::class)->name('customer.info')->middleware(VerifyUserIsCustomer::class);

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/admin', AdminIndex::class)->name('admin')->middleware(VerifyUserIsAdmin::class);

    Route::group([
        'prefix' => 'admin/categoria',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminCategoryIndex::class)->name('admin.category.index');
        Route::get('/ver/{category}', AdminCategoryShow::class)->name('admin.category.show');
        Route::get('/cadastrar', AdminCategoryCreate::class)->name('admin.category.create');
        Route::get('/editar/{category}', AdminCategoryUpdate::class)->name('admin.category.update');
    });

    Route::group([
        'prefix' => 'admin/marca',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminBrandIndex::class)->name('admin.brand.index');
        Route::get('/ver/{brand}', AdminBrandShow::class)->name('admin.brand.show');
        Route::get('/cadastrar', AdminBrandCreate::class)->name('admin.brand.create');
        Route::get('/editar/{brand}', AdminBrandUpdate::class)->name('admin.brand.update');
    });

    Route::group([
        'prefix' => 'admin/produto',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminProductIndex::class)->name('admin.product.index');
        Route::get('/ver/{product}', AdminProductShow::class)->name('admin.product.show');
        Route::get('/cadastrar', AdminProductCreate::class)->name('admin.product.create');
        Route::get('/editar/{product}', AdminProductUpdate::class)->name('admin.product.update');
    });

    Route::group([
        'prefix' => 'admin/variacao',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminVariationIndex::class)->name('admin.variation.index');
        Route::get('/ver/{variation}', AdminVariationShow::class)->name('admin.variation.show');
        Route::get('/cadastrar', AdminVariationCreate::class)->name('admin.variation.create');
        Route::get('/editar/{variation}', AdminVariationUpdate::class)->name('admin.variation.update');
    });

    Route::group([
        'prefix' => 'admin/sku',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminSkuIndex::class)->name('admin.sku.index');
        Route::get('/ver/{sku}', AdminSkuShow::class)->name('admin.sku.show');
        Route::get('/cadastrar', AdminSkuCreate::class)->name('admin.sku.create');
        Route::get('/editar/{sku}', AdminSkuUpdate::class)->name('admin.sku.update');
    });

    Route::group([
        'prefix' => 'admin/order',
        'middleware' => VerifyUserIsAdmin::class,
    ], function($route) {
        Route::get('/listar', AdminOrderIndex::class)->name('admin.order.index');
        Route::get('/ver/{order}', AdminOrderShow::class)->name('admin.order.show');
    });
});
