<?php

use Illuminate\Http\Request;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\FeedbacksController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StationsController;


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

Route::group(
    [
        'prefix' => 'app',
        'namespace' => '',
    ],
    function () {
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::post('login', 'App\Http\Controllers\AuthController@login');


    Route::get('user/status/{status}', [UsersController::class, 'index']);
    Route::get('user/{id}', [UsersController::class, 'show']);
    Route::post('user/', [UsersController::class, 'store']);
    Route::patch('user/{id}', [UsersController::class, 'update']);
    Route::delete('user/{id}', [UsersController::class, 'destroy']);
    
       
    Route::get('ticket/', [TicketsController::class, 'index']);
    Route::get('ticket/{id}', [TicketsController::class, 'show']);
    Route::post('ticket/', [TicketsController::class, 'store']);
    Route::patch('ticket/{id}', [TicketsController::class, 'update']);
    Route::delete('ticket/{id}', [TicketsController::class, 'destroy']);

    Route::get('feedback/user/{user_id}', [FeedbacksController::class, 'index']);
    Route::get('feedback/{id}', [FeedbacksController::class, 'show']);
    Route::post('feedback/', [FeedbacksController::class, 'store']);
    Route::patch('feedback/{id}', [FeedbacksController::class, 'update']);
    Route::delete('feedback/{id}', [FeedbacksController::class, 'destroy']);


    Route::get('order/user/{user_id}', [OrdersController::class, 'index']);
    Route::get('order/{id}', [OrdersController::class, 'show']);
    Route::post('order/', [OrdersController::class, 'store']);
    Route::patch('order/{id}', [OrdersController::class, 'update']);
    Route::delete('order/{id}', [OrdersController::class, 'destroy']);

    Route::get('station/', [StationsController::class, 'index']);
    Route::get('station/{id}', [StationsController::class, 'show']);
    Route::post('station/', [StationsController::class, 'store']);
    Route::patch('station/{id}', [StationsController::class, 'update']);
    Route::delete('station/{id}', [StationsController::class, 'destroy']);



    }
);






