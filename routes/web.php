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

Route::get('/', function () {
    return view('welcome');
});


Route::post('user/register', 'UserController@store');
Route::post('/price/delete', 'PriceController@destroy');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware’' => ['auth']], function () {

    Route::get('admin/user/manage', 'UserController@manage');

    Route::get('admin/price/manage', 'PriceController@getAll');
    Route::post('admin/price/store', 'PriceController@store');

    Route::get('admin/sell-request/manage', 'RequestSellController@manage');
    Route::get('admin/sell-request/create', 'RequestSellController@create');
    Route::post('admin/sell-request/store', 'RequestSellController@store');

    Route::group(['middleware' => ['mentor']], function () {

    });


    Route::group(['middleware' => ['student']], function () {

    });
});
