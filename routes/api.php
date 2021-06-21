<?php

use App\Http\Controllers\API\v1\CartController;
use App\Http\Controllers\API\v1\LoginController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\TransactionController;
use Illuminate\Http\Request;
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


Route::group(['prefix' => 'v1'],function() {
    //LoginController
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [LoginController::class, 'register']);
});


Route::group(['middleware' => 'auth-api'], function (){

    Route::post('/logout', [
        LoginController::class,
        'logout'
    ]);


    //UserControler
    Route::group([
        'middleware' => 'is_admin',
        'aa' => 'admin'
    ], function(){
        Route::get('/users', [
            App\Http\Controllers\API\v1\admin\UserController::class, 'index'
        ]);
    });

    Route::group([
        'as' => 'user'
    ], function(){

    });


    Route::get('/user', [
        UserController::class,
        'show'
    ]);
    Route::post('/user/store', [
        UserController::class,
        'store'
    ]);
    Route::put('/user/update', [
        UserController::class,
        'update'
    ]);

    //CategoryController
    Route::get('/categories', [
        CategoryController::class,
        'index'
    ]);
    Route::post('/category', [
        CategoryController::class,
        'store'
    ]);

    //ProductController
    Route::get('/products', [
        ProductController::class,
        'index'
    ]);
    Route::post('/product', [
        ProductController::class,
        'store'
    ]);
    Route::get('/products/searchByKey', [
        ProductController::class,
        'searchByKey'
    ]);
    Route::get('/products/{product}', [
        ProductController::class,
        'show'
    ]);
    Route::get('/products/searchByCategory/{category}', [
        ProductController::class,
        'searchByCategory'
    ]);

    //CartController
    Route::get('/carts', [
        CartController::class,
        'index'
    ]);
    Route::post('/cart', [
        CartController::class,
        'store'
    ]);
    Route::get('/carts/showByUser', [
        CartController::class,
        'showByUser'
    ]);

    //TransactionController
    Route::post('/transaction', [
        TransactionController::class,
        'store'
    ]);

    //OrderController
    Route::post('/order', [
        OrderController::class,
        'store'
    ]);
    Route::post('/order/delete', [
        OrderController::class,
        'destroy'
    ]);
    Route::get('/order/cart', [
        OrderController::class,
        'cart'
    ]);
    Route::get('/order/history', [
        OrderController::class,
        'history'
    ]);
    Route::post('/order/checkout', [
        OrderController::class,
        'checkout'
    ]);

});


