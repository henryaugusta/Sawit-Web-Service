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

Route::get('news/{id}/', [App\Http\Controllers\NewsController::class, 'read']);


Route::group(['middleware’' => ['auth']], function () {

    Route::get('admin/user/manage', 'UserController@manage');

    Route::get('admin/price/manage', 'PriceController@getAll');
    Route::post('admin/price/store', 'PriceController@store');

    Route::get('admin/sell-request/manage', 'RequestSellController@manage');
    Route::get('admin/sell-request/create', 'RequestSellController@create');
    Route::post('admin/sell-request/store', 'RequestSellController@store');

    Route::get('admin/news/create', 'NewsController@adminCreate');

    Route::get('admin/news/index',['uses'=>'NewsController@masterGetNews']);
    Route::post('admin/news/{id}/destroy',['uses'=>'NewsController@destroy'])->name('news.delete');

    Route::get('admin/armada/manage', ['uses'=>'ArmadaController@adminManage']);
    Route::get('admin/armada/create', ['uses'=>'ArmadaController@adminCreate']);


    Route::post('news/store', ['uses' => 'NewsController@store']);
    Route::post('news/update', ['uses' => 'NewsController@update']);

    Route::get('user/{id}/profile', ['uses' => 'UserController@profile']);
    Route::post('user/profile/update', ['uses' => 'UserController@update']);
    Route::post('user/change_user_password', ['uses' => 'UserController@changePassword']);
    Route::post('user/change_status', ['uses' => 'UserController@changeStatus']);

    Route::group(['middleware' => ['mentor']], function () {

    });


    Route::group(['middleware' => ['student']], function () {

    });
});
