<?php

use App\Http\Controllers\ProductController;
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

Route::resource('items', '\App\Http\Controllers\ItemController');
Route::resource('categories', '\App\Http\Controllers\CategoryController');
Route::resource('products', '\App\Http\Controllers\ProductController');


Route::get('/products/{id}{cid}/details', 'App\Http\Controllers\ProductController@details')->name('products.details');
Route::get('/products/{category}/select', 'App\Http\Controllers\ProductController@select')->name('products.select');
//if you select SHOP in the route, it'll be directed to the SHOW function and blade file. 
//it kept causing errors in my code if i didn't do this however hope it makes sense.
Route::get('/products/shop', 'App\Http\Controllers\ProductController@shop')->name('products.shop');

Route::post('/products/check_order', 'App\Http\Controllers\ProductController@check_orders')->name('check_order');
//admin page to blade file.
Route::get('/admin', 'App\Http\Controllers\ProductController@admin')->name('admin');

Route::post('/products/selectable', 'App\Http\Controllers\ProductController@selectables')->name('selectable');
//Route::get('/products/thankyou', 'App\Http\Controllers\ProductController@thankyou')->name('thankyou');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



