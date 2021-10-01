<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


route::middleware('auth')->group(function(){

    Route::get('/', 'HomeController@index')->name('home')->middleware('verified');

    route::get('cart/show', "CartController@show")->name('cart.show');

    route::get('cart/add/{id}','CartController@add')->name('cart.add');

    route::get('cart/remove/{rowId}','CartController@remove')->name('cart.remove');

    route::get('cart/destroy','CartController@destroy')->name('cart.destroy');  

    route::post('cart/ajax','CartController@ajax')->name('cart.ajax');

    route::post('cart/search_ajax','CartController@search_ajax')->name('cart.search_ajax');

    route::get('search','HomeController@search')->name('search');

    route::get('detail/{id}','HomeController@detail')->name('detail');

    route::post('cart/ajax_detail','CartController@ajax_detail')->name('cart.ajax_detail');

    route::get('cart/buy', "CartController@buy")->name('cart.buy');

    //ADMIN

    route::get('admin/dashboard','DashboardController@show');

    //USER

    route::get('admin/user/list','AdminUserController@list');

    route::get('admin/user/add','AdminUserController@add'); //form add

    route::post('admin/user/store','AdminUserController@store'); // update add

    route::get('admin/user/delete/{id}','AdminUserController@delete')->name('user_delete');

    route::get('admin/user/option','AdminUserController@option'); 

    route::get('admin/user/edit/{id}','AdminUserController@edit')->name('user_edit'); //form edit

    route::post('admin/user/update/{id}','AdminUserController@update')->name('user_update'); // update edit 

    //PRODUCT

    route::get('admin/product/list','AdminProductController@list');

    route::get('admin/product/add','AdminProductController@add');

    route::post('admin/product/create','AdminProductController@create');

    route::get('admin/product/delete/{id}','AdminProductController@delete')->name('product_delete');

    route::get('admin/product/option','AdminProductController@option'); 

    route::get('admin/product/edit/{id}','AdminProductController@edit')->name('product_edit'); //form edit

    route::post('admin/product/update/{id}','AdminProductController@update')->name('product_update'); // update edit 

    //ORDER

    route::get('admin/order/list','AdminOrderController@list');

    route::get('admin/order/delete/{id}','AdminOrderController@delete')->name('order_delete');

    route::get('admin/order/option','AdminOrderController@option'); 

});
