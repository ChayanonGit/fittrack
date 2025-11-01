<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FitnessCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\FitnessCourse;
use App\Http\Controllers\CartController;
// for user
Route::get('/', [HomeController::class, 'home'])->name('home');

Route::controller(HomeController::class)
    ->prefix('/shop')
    ->name('shop.')
    ->group(function () {
        Route::get('/', 'viewshop')->name('view-shop');
        Route::get('/class', 'viewclass')->name('view-class');
    });




Route::controller(CartController::class)
    ->prefix('cart') // prefix /cart
    ->name('cart.')
    ->group(function () {
        Route::get('/', 'viewcart')->name('view-cart');              // cart.view-cart
        Route::post('/add/{id}', 'add')->name('add');               // cart.add
        Route::get('/remove/{code}', 'remove')->name('remove');     // cart.remove
        Route::post('/update/{code}',  'updateQuantity')->name('updateQuantity');
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
        });
    });

Route::controller(ProductController::class)
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

    Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// ...existing code...
Route::get('/auth/login', function () {
    return view('auth.login'); // หรือ return redirect()->route('login');
});