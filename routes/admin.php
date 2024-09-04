<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\KindController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('customAuth:admin')->group(function () {
        Route::controller(HomeController::class)->as('home.')->group(function () {
            Route::get('/', 'dashboard')->name('dashboard');
        });

        Route::controller(UserController::class)->prefix('user')->as('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/them', 'create')->name('create');
        });

        Route::controller(RoleController::class)->prefix('role')->as('role.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/them', 'create')->name('create');
        });

        Route::controller(PermissionController::class)->prefix('permission')->as('permission.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/them', 'create')->name('create');
        });

        Route::controller(AuthController::class)->as('auth.')->group(function () {
            Route::post('/dang-xuat', 'handleLogout')->name('handleLogout');
        });

        Route::controller(CategoryController::class)->prefix('category')->as('category.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/them', 'store')->name('store');
            Route::get('/chinh-sua/{category}', 'edit')->name('edit');
            Route::put('/cap-nhat/{category}', 'update')->name('update');
            Route::delete('/xoa/{category}', 'destroy')->name('destroy');
        });

        Route::controller(KindController::class)->prefix('kind')->as('kind.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/them', 'store')->name('store');
            Route::get('/chinh-sua/{kind}', 'edit')->name('edit');
            Route::put('/cap-nhat/{kind}', 'update')->name('update');
            Route::delete('/xoa/{kind}', 'destroy')->name('destroy');
        });

        Route::controller(ColorController::class)->prefix('color')->as('color.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/them', 'store')->name('store');
            Route::get('/chinh-sua/{color}', 'edit')->name('edit');
            Route::put('/cap-nhat/{color}', 'update')->name('update');
            Route::delete('/xoa/{color}', 'destroy')->name('destroy');
        });

        Route::controller(SizeController::class)->prefix('size')->as('size.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/them', 'store')->name('store');
            Route::get('/chinh-sua/{size}', 'edit')->name('edit');
            Route::put('/cap-nhat/{size}', 'update')->name('update');
            Route::delete('/xoa/{size}', 'destroy')->name('destroy');
        });

        Route::resource('product', ProductController::class);
        Route::resource('productImage', ProductImageController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('coupon', CouponController::class);
    });

    Route::middleware('customGuest:admin')->group(function () {
        Route::controller(AuthController::class)->as('auth.')->group(function () {
            Route::get('/dang-nhap', 'login')->name('login');
            Route::post('/dang-nhap', 'handleLogin')->name('handleLogin');
        });
    });
});