<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'oauth'], function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken'])
        ->name('passport.token');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/user', [UserController::class, 'create']);
    Route::post('/login', [AuthenticateController::class, 'login']);
    Route::post('/reset/password', [AuthenticateController::class, 'resetPassword']);
});
