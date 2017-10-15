<?php

use Illuminate\Http\Request;

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

Route::middleware('api')->resource('categories', 'CrudController');
Route::middleware('api')->resource('currencies', 'CrudController');
//Route::middleware('api')->resource('products', 'CrudController');
Route::middleware('api')->resource('orders', 'CrudController');
Route::middleware('api')->resource('domains', 'CrudController');

Route::middleware('api')->resource('products', 'ProductController');
Route::middleware('api')->resource('parts', 'CrudController');
Route::middleware('api')->resource('options', 'CrudController');

Route::middleware('api')->get('globals', 'GlobalsController@index');

Route::middleware('api')->get('test', 'CrudController@test');