<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return 5;
});
Route::post('/users', 'ApiUserController@getAll');
Route::post('/user/login', 'ApiUserController@login');
Route::post('/user/registration', 'UserController@store');
Route::get('/login', 'ApiUserController@login');

Route::get('/user/{id}/profile', ['uses' => 'UserController@profile']);
Route::post('/user/profile/update', ['uses' => 'UserController@update']);
Route::post('/user/change_user_password', ['uses' => 'UserController@changePassword']);
Route::post('/user/change_status', ['uses' => 'UserController@changeStatus']);

Route::post('/price', 'PriceController@getAll');

Route::post('/news/store', 'NewsController@store');
Route::post('/news/all', 'NewsController@masterGetNews');





