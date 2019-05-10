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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','middleware' => ['api','cors']], function () {

	Route::get('foo', function () {
	    return 'Hello World';
	});

    Route::post('auth/register', 'Api\Auth\AuthController@register');
    Route::post('auth/login', 'Api\Auth\AuthController@login');

    Route::get('auth/foo', 'Api\Auth\AuthController@foo');

    Route::group(['middleware' => 'jwt.auth'], function () {
        
    });
});