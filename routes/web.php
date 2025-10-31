<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FitnessCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\FitnessCourse;

Route::controller(HomeController::class)
    ->prefix('')
    ->name('fittrack.')
    ->group(function () {
        Route::get('/fittrack', 'Home')->name('home');
    });


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
