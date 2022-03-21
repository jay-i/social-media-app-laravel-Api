<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatusUpdatesController;
use App\Http\Controllers\UserImageController;

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

// Authentication Routes
Route::group(['middleware' => 'api', 'prefix' => 'users'], function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/activate_email/{code}', [AuthController::class, 'activateEmail']);
    
    Route::post('/forgotPasswordCreate', [AuthController::class, 'forgotPasswordCreate']);
    Route::post('/forgotPassword/{token}', [AuthController::class, 'forgotPasswordToken']);

    Route::group(['middleware' => 'auth:api'], function () {
        // todo --- password reset
    });
});

// User Routes
Route::group(['middleware' => 'auth:api', 'prefix' => 'user'], function() {
    Route::get('me', [UserController::class, 'me']);
    Route::post('status/new', [StatusUpdatesController::class, 'store']);
    Route::post('image-upload', [UserImageController::class, 'store']);
});
 

