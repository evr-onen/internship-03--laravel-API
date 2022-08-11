<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;



Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'product'

], function ($router) {

    Route::post('create', 'ProductsController@create_product');
    Route::post('edit', 'ProductsController@update_product');
    Route::get('get/{stokkod}', 'ProductsController@get_product');
    Route::get('/', 'ProductsController@get_products');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'category'

], function ($router) {

    Route::post('/', 'CategoryController@create_category');
    Route::get('/categories', 'CategoryController@getscategories');
    Route::put('/{id}', 'CategoryController@update_category');
    Route::delete('/{id}', 'CategoryController@destroy_category');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'store'

], function ($router) {

    Route::post('/', 'StoreController@create_store');
    Route::get('/', 'StoreController@getsstores');
    Route::post('/pending/{id}', 'StoreController@accept_store');
    Route::put('/{id}', 'StoreController@update_store');
    Route::delete('/{id}', 'StoreController@destroy_store');
    Route::get('/images/{id}', 'StoreController@get_images');
    Route::get('/{id}', 'StoreController@getsstore');
});
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'product'

], function ($router) {

    Route::post('/', 'ProductController@create');
    Route::post('/{id}', 'ProductController@update_product');
    Route::get('/all', 'ProductController@get_products');
    Route::delete('/{id}', 'ProductController@destroy_products');
});
