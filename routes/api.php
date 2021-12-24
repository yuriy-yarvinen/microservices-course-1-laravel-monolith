<?php

use Illuminate\Http\Request;
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

// Route::get('users', 'UserController@index');
// Route::get('users/{id}', 'UserController@show');
// Route::post('users', 'UserController@store');
// Route::put('users/{id}', 'UserController@update');
// Route::delete('users/{id}', 'UserController@destroy');

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'AuthController@logout');
    
    Route::apiResource('users', 'UserController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('orders', 'OrderController')->only('index', 'show');
    Route::apiResource('permissions', 'PermissionsController')->only('index');
    Route::get('export', 'OrderController@export');
    Route::get('chart', 'DashboardController@chart');
    Route::get('user', 'UserController@user');
    Route::post('upload', 'ImageController@upload');
    Route::put('users/info', 'UserController@updateInfo');
    Route::put('users/password', 'UserController@updatePassword');
});
