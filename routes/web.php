<?php

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Client\ShippingAddressController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\WishlistController;
use Illuminate\Support\Facades\Route;

Route::name('client.')->middleware('visitor')->group(function () {
    Route::middleware('customAuth:web')->group(function () {
        Route::controller(ClientController::class)->as('home.')->group(function () {
            Route::get('/san-pham-yeu-thich', 'wishlist')->name('wishlist');
            Route::get('/thong-tin-ca-nhan', 'profile')->name('profile');
            Route::get('/dia-chi-nhan-hang', 'addresses')->name('addresses');
            Route::get('/thong-bao', 'notification')->name('notification');
            Route::get('/thanh-toan', 'checkout')->name('checkout');
            Route::get('/dat-hang-thanh-cong', 'orderSuccess')->name('orderSuccess');
            Route::get('/don-hang-da-dat', 'orderHistory')->name('orderHistory');
        });

        Route::controller(WishlistController::class)->as('wishlist.')->group(function () {
            Route::post('/add-to-wishlist/{product}', 'store')->name('store');
            Route::post('/delete-wishlist', 'destroy')->name('destroy');
        });

        Route::controller(AuthController::class)->as('auth.')->group(function () {
            Route::post('/dang-xuat', 'logout')->name('logout');
        });

        Route::controller(UserController::class)->as('auth.')->group(function () {
            Route::put('/doi-mat-khau', 'changePassword')->name('changePassword');
            Route::put('/doi-lien-he', 'changeContact')->name('changeContact');
            Route::put('/doi-thong-tin', 'changeInfo')->name('changeInfo');
            Route::post('/doi-thong-bao', 'changeNoti')->name('changeNoti');
        });

        Route::controller(ShippingAddressController::class)->as('shippingAddress.')->group(function () {
            Route::post('/them-dia-chi', 'store')->name('store');
            Route::put('/cap-nhat-dia-chi/{shippingAddress}', 'update')->name('update');
            Route::delete('/xoa-dia-chi/{shippingAddress}', 'destroy')->name('destroy');
        });

        Route::controller(CouponController::class)->as('coupon.')->group(function () {
            Route::post('/ap-dung-code', 'apply')->name('apply');
        });

        Route::controller(OrderController::class)->as('order.')->group(function () {
            Route::post('/dat-hang', 'store')->name('store');
            Route::get('/show-order-detail/{order}', 'show')->name('show');
            Route::put('/huy-don-hang/{order}', 'cancel')->name('cancel');
            Route::put('/nhan-hang-thanh-cong/{order}', 'shipped')->name('shipped');
            Route::get('/show-need-review/{order}', 'showNeedReviews')->name('showNeedReviews');
        });

        Route::controller(ReviewController::class)->as('review.')->group(function () {
            Route::post('/danh-gia', 'store')->name('store');
        });
    });

    Route::middleware('customGuest:web')->group(function () {
        Route::controller(AuthController::class)->as('auth.')->group(function () {
            Route::get('/dang-nhap', 'login')->name('login');
            Route::get('/quen-mat-khau', 'forgotPassword')->name('forgotPassword');
            Route::post('/xy-ly-quen-mat-khau', 'handleForgotPassword')->name('handleForgotPassword');
            Route::post('/dang-nhap', 'handleLogin')->name('handleLogin');
            Route::get('/dang-ky', 'register')->name('register');
            Route::post('/dang-ky', 'handleRegister')->name('handleRegister');
            Route::get('/auth/redirect/google', 'redirectGoogleLogin')->name('redirectGoogleLogin');
            Route::get('/auth/callback/google', 'callbackGoogleLogin')->name('callbackGoogleLogin');
        });
    });

    Route::controller(ClientController::class)->as('home.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/chi-tiet-san-pham/{product}', 'productDetail')->name('productDetail');
        Route::get('/tim-kiem-san-pham', 'productSearch')->name('productSearch');
        Route::get('/loc-san-pham', 'shop')->name('shop');
    });

    Route::controller(CartController::class)->as('cart.')->group(function () {
        Route::post('/add-to-cart/{product}', 'addToCart')->name('addToCart');
        Route::delete('/remove-item/{key}', 'removeItem')->name('removeItem');
        Route::post('/update-quantity/{key}', 'updateQuantity')->name('updateQuantity');
        Route::get('/gio-hang', 'showCart')->name('showCart');
        Route::delete('/clear-cart', 'clearCart')->name('clearCart');
    });
});

Route::middleware('customAuth:web')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/email/verify', 'verifyEmail')->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'handleVerifyEmail')->name('verification.verify');
    });
});