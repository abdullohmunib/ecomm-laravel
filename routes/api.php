<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::resources([
        'categories' => CategoryController::class,
        'subcategories' => SubcategoryController::class,
        'sliders' => SliderController::class,
        'products' => ProductController::class,
        'members' => MemberController::class,
        'testimonis' => TestimoniController::class,
        'reviews' => ReviewController::class,
        'orders' => OrderController::class
    ]);

    Route::get('/order/dikonfirmasi', [OrderController::class, 'dikonfirmasi']);
    Route::get('/order/dikemas', [OrderController::class, 'dikemas']);
    Route::get('/order/dikirim', [OrderController::class, 'dikirim']);
    Route::get('/order/diterima', [OrderController::class, 'diterima']);
    Route::get('/order/selesai', [OrderController::class, 'selesai']);
    Route::get('/order/dikonfirmasi', [OrderController::class, 'dikonfirmasi']);
    Route::get('/order/ubahstatus/{order}', [OrderController::class, 'ubah_status']);
});
