<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrderProductResource;
use App\Models\User;
use App\Models\OrderProduct;

Route::group([

    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group([

    'middleware' => ['api'],
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    /**** Categories *****/
    Route::get('/category', 'CategoryController@index')->name('category.index');

    /**** Product *****/
    Route::apiResource('/product', 'ProductController', );

    /**** Products -> arquivos *****/
    Route::apiResource('product_file', 'App\Http\Controllers\ProductFileController', ['except' => ['index','create','edit','update','show']]);

     /**** Order *****/
    Route::apiResource('/order', 'OrderController', ['except' => ['create','edit']]);
});

/***********************************************************************************************/
/***********************************************************************************************/

Route::group([

    
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['api','jwt.auth']      

], function ($router) {   

    /**** Category *****/
    Route::apiResource('/category', 'CategoryController', ['except' => ['index']]);
    Route::get('/category/getParentTree/{id?}', 'CategoryController@getParentTree')->name('category.getParentTree');

    /**** Client *****/
    Route::apiResource('/client', 'ClientController');

    /**** Client - Address *****/
    Route::apiResource('/client_address', 'ClientAddressController');    

    /**** Orders - Products *****/
    Route::resource('/order_product', 'OrderProductController', ['except' => ['show','create','edit']]);
    Route::get('/order_product/{order_product}', function (string $order_product) {
        return new OrderProductResource(OrderProduct::findOrFail($order_product));
    });

    /**** Product *****/
    Route::apiResource('/product', 'ProductController', ['except' => ['index','show','create','edit']]);

    /**** Stock *****/
    Route::apiResource('stock', 'App\Http\Controllers\StockController');

    /**** User *****/
    Route::resource('/user', 'UserController', ['except' => ['create','store','edit']]);
});




