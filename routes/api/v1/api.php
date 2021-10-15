<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});


//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);

Route::prefix('/user')->group(function() {

        Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');

        Route::middleware('auth:sanctum')->get('/all', 'App\Http\Controllers\UserController@all');

        Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');

        Route::middleware('auth:sanctum')->get('/me', 'App\Http\Controllers\Api\AuthController@me');


    
});


 