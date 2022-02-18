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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'App\Http\Controllers\Api\UserController@login');

Route::post('register', 'App\Http\Controllers\Api\UserController@register');


Route::middleware('auth:api')->group(function () {
    Route::post('profile', 'App\Http\Controllers\Api\UserController@profile');
    Route::get('profile_worker/{id}', 'App\Http\Controllers\Api\UserController@profile_worker');

    Route::apiResource('works', 'App\Http\Controllers\Api\WorkController');

    Route::post('edit/works/{id}', 'App\Http\Controllers\Api\WorkController@fix');
    Route::get('show/works/{id}', 'App\Http\Controllers\Api\WorkController@all_work_by_section');
    Route::get('show/works', 'App\Http\Controllers\Api\WorkController@all_works');
    Route::get('user/{id}/works', 'App\Http\Controllers\Api\WorkController@user_work');

    Route::apiResource('likes', 'App\Http\Controllers\Api\LikeController');
    Route::apiResource('comments', 'App\Http\Controllers\Api\CommentController');
    Route::apiResource('orders', 'App\Http\Controllers\Api\OrderController');
    Route::get('all/orders/{id}', 'App\Http\Controllers\Api\OrderController@all');
    Route::get('user_order', 'App\Http\Controllers\Api\OrderController@user_order');



    Route::post('status/orders/{id}', 'App\Http\Controllers\Api\OrderController@status');
});