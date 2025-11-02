<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FitnessCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\FitnessCourse;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\UserController;
use App\Models\OrderDetail;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::middleware([
    'cache.headers:no_store,no_cache,must_revalidate,max_age=0'
])->group(function () {
    // for user

    Route::controller(HomeController::class)
        ->prefix('/shop')
        ->name('shop.')
        ->group(function () {
            Route::get('/', 'viewshop')->name('view-shop');
            Route::get('/class', 'viewclass')->name('view-class');
        });

    Route::controller(OrderDetailController::class)
        ->prefix('/order')
        ->name('order.')
        ->group(function () {
            Route::get('/', 'vieworder')->name('view-order');
            Route::prefix('/{orderCode}')->group(static function (): void {
                Route::get('/detail', 'orderDetail')->name('view-detail');
                Route::get('/delete', 'delete')->name('delete');
            });
        });




    Route::controller(CartController::class)
        ->prefix('cart') // prefix /cart
        ->name('cart.')
        ->group(function () {
            Route::get('/', 'viewcart')->name('view-cart');              // cart.view-cart
            Route::post('/add/{id}', 'add')->name('add');               // cart.add
            Route::get('/remove/{code}', 'remove')->name('remove');     // cart.remove
            Route::post('/update/{code}',  'updateQuantity')->name('updateQuantity');
            Route::post('/cart',  'checkout')->name('checkout');
        });


    Route::controller(LoginController::class)
        ->prefix('auth')
        ->group(static function (): void {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'authenticate')->name('authenticate');
            Route::post('/logout', 'logout')->name('logout');
        });


    // for Admin 

    Route::controller(CategoryController::class)
        ->prefix('/category')
        ->name('category.')
        ->group(function () {
            Route::get('/list', 'List')->name('list');
            route::get('/create', 'createform')->name('create-form');
            route::post('/create', 'create')->name('create');
            Route::prefix('/{category}')->group(function () {
                Route::get('', 'view')->name('view');
                Route::get('/update', 'showUpdateForm')->name('update-form');
                Route::post('/update', 'update')->name('update');
                Route::get('/delete', 'delete')->name('delete');
                Route::get('/products', 'viewProducts')->name('view-product');
            });

            Route::prefix('/{product}')->group(function () {
                Route::post('/update', 'product_update')->name('update');
                Route::get('/delete', 'product_delete')->name('delete');
            });
        });

  Route::controller(OrderController::class)
        ->prefix('admin/order')
        ->name('admin.order.')
        ->group(function () {
            Route::get('/', 'vieworder')->name('view-order');
            Route::prefix('/{orderCode}')->group(static function (): void {
                Route::get('/detail', 'orderDetail')->name('view-detail');
                Route::get('/delete', 'delete')->name('delete');
            });
        });    Route::controller(ProductController::class)
        ->prefix('/products')
        ->name('products.')
        ->group(function () {
            Route::get('/list', 'List')->name('list');
            route::get('/create', 'createform')->name('create-form');
            route::post('/create', 'create')->name('create');
            Route::prefix('/{product}')->group(function () {
                Route::get('', 'view')->name('view');
                Route::get('/update', 'showUpdateForm')->name('update-form');
                Route::post('/update', 'update')->name('update');
                Route::get('/delete', 'delete')->name('delete');
            });
        });

    Route::controller(FitnessCourseController::class)
        ->prefix('/fitnessclass')
        ->name('fitnessclass.')
        ->group(function () {
            Route::get('/list', 'List')->name('list');
            route::get('/create', 'createform')->name('create-class');
            route::post('/create', 'create')->name('create');
            Route::prefix('/{class}')->group(function () {
                Route::get('', 'view')->name('view');
                Route::get('/update', 'Updateclass')->name('update-class');
                Route::post('/update', 'update')->name('update');
                Route::get('/delete', 'delete')->name('delete');
            });
        });


    route::controller(UserController::class)
        ->prefix('/user')
        ->name('users.')
        ->group(static function (): void {
            route::get('', 'list')->name('list');
            route::get('/create', 'showCreateForm')->name('create-form');
            route::post('/create', 'create')->name('create');



            route::get('/self', 'selfView')->name('view-selves');
            route::get('/self/update', 'showUpdateSelf')->name('update-selves-form');
            route::post('/self/update', 'UpdateSelf')->name('update-self');

            route::prefix('/{user}')->group(static function (): void {
                route::get('', 'view')->name('view');
                route::get('/update', 'showUpdateForm')->name('update-form');
                route::post('/update', 'update')->name('update');
                route::post('/delete', 'delete')->name('delete');
            });
        });
});
