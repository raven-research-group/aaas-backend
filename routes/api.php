<?php

use App\Http\Controllers\Admins\AuthenticateController as AdminsAuthenticateController;
use App\Http\Controllers\Organizations\AuthenticateController as OrganizationAuthenticateController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\UserController;
use App\Models\Organization;
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
    Route::post('/reset-password', [AuthenticateController::class, 'resetPassword']);
});

Route::post('/user', [UserController::class, 'create']);
Route::post('/login', [AuthenticateController::class, 'login']);

Route::post('/admin-signup', [AdminsAuthenticateController::class, 'register']);
Route::post('/admin-login', [AdminsAuthenticateController::class, 'login']);




Route::middleware('frontend')->prefix("frontend")->group(function(){
    Route::post('/admin-signup', [AdminsAuthenticateController::class, 'register']);
    Route::post('/admin-login', [AdminsAuthenticateController::class, 'login']);
    


    Route::middleware('auth:admin')->group(function(){
        Route::get("/adminTest", function(){
            return response()->json(["message" => "Welcome to the Admin API"]);
        });
    });

});



Route::prefix("organization")->group(function(){

    Route::get("/token", [OrganizationAuthenticateController::class, 'token']);

    Route::middleware('auth:organization')->group(function(){
        Route::get("/test", function(){
            return response()->json(["message" => "Welcome to the Organization API"]);
        });
    });

});