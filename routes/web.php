<?php

use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\MainController;

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\Admin\Users\LogoutController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\MainController as UserMainController;
use App\Http\Controllers\User\MenuController as UserMenuController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Services\UploadService;
use Illuminate\Support\Facades\Route;

Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);
Route::post('admin/users/logout', [LogoutController::class, 'logout'])->name('logout');

//Route authentication(Admin)
Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);

        //Route menu
        Route::prefix('menu')->group(function () {
            Route::get('list', [MenuController::class, 'list'])->name('list');
            Route::get('create', [MenuController::class, 'create'])->name('create');
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'edit'])->name('edit');
            Route::post('create', [MenuController::class, 'store'])->name('store');
            Route::DELETE('destroy', [MenuController::class, 'destroy'])->name('destroy');
        });
        //Discount
        Route::prefix('discounts')->group(function () {
            Route::get('create', [DiscountController::class, 'index']);
            Route::post('create', [DiscountController::class, 'store']);
            Route::get('list', [DiscountController::class, 'show']);
            Route::get('edit/{discount}', [DiscountController::class, 'edit']);
            Route::post('edit/{discount}', [DiscountController::class, 'update']);
            Route::DELETE('destroy', [DiscountController::class, 'destroy']);
        });
        //Route Product 
        Route::prefix('products')->group(function () {
            Route::get('create', [ProductController::class, 'create']);
            Route::post('create', [ProductController::class, 'store']);
            Route::get('index', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'edit']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
        });
        //Route Upload
        Route::post('upload/services', [UploadController::class, 'store']);
        //Route Slider
        Route::prefix('sliders')->group(function () {
            Route::get('create', [SliderController::class, 'create']);
            Route::post('create', [SliderController::class, 'store']);
            Route::get('index', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'edit']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });
        //Cart-Order
        Route::get('customer', [AdminCartController::class, 'index']);
        Route::get('customer/view/{customer}', [AdminCartController::class, 'show']);
        Route::DELETE('destroy', [AdminCartController::class, 'destroy']);
    });
});
//User
Route::prefix('user')->group(function () {
    Route::get('/', [UserMainController::class, 'index']);
    Route::get('shop', [UserMainController::class, 'product']);
    //Contact
    Route::get('contact', [UserMainController::class, 'contact']);
    //About
    Route::get('about', [UserMainController::class, 'about']);
    //discount
    Route::post('apply_discount', [CartController::class, 'apply_discount'])->name('apply_discount');
});
Route::post('/services/load-product', [UserMainController::class, 'loadProduct']);
//Product with category
Route::get('/categories/{id}-{slug}.html', [UserMenuController::class, 'index'])->name('categories.show');

//QuickView product
Route::get('/product/{id}-{name}.html', [UserProductController::class, 'index']);
Route::get('/product/{id}/quickview', [UserMainController::class, 'quickView'])->name('product.quickview');
Route::get('/size-chart', [UserMainController::class, 'getSizeChart'])->name('size_chart');
//Cart
Route::get('/cart', [CartController::class, 'index']);
// Route::get('/order', [CartController::class, 'order']);
Route::post('/add-cart', [CartController::class, 'add']);
Route::post('/update-cart', [CartController::class, 'update']);
Route::get('/delete-cart/{id}', [CartController::class, 'delete']);
Route::post('/buy-cart', [CartController::class, 'buy']);
Route::get('/order-cart', [CartController::class, 'order']);
