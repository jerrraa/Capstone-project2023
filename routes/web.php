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
//i added the shop as however it'll be called from show, if i called SHOP first i'll recieve a error.
Route::get('/products/shop', 'App\Http\Controllers\ProductController@shop')->name('products.shop');


//route for details page from products

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



