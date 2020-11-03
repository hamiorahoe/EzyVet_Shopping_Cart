<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'uses' => 'App\Http\Controllers\CartController@getCart',
    'as' => 'cart.home'
]);


Route::post('/addItem', [
    'uses' => 'App\Http\Controllers\CartController@addToCart',
    'as' => 'cart.addItem'
]);
Route::get('/addQty{id}', [
    'uses' => 'App\Http\Controllers\CartController@addQty',
    'as' => 'cart.addQty'
]);
Route::get('/minusQty{id}', [
    'uses' => 'App\Http\Controllers\CartController@minusQty',
    'as' => 'cart.minusQty'
]);
Route::get('/removeItem{id}', [
    'uses' => 'App\Http\Controllers\CartController@removeFromCart',
    'as' => 'cart.removeItem'
]);
