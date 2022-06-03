<?php

use App\Http\Controllers\API\Post\PostController;
use App\Http\Controllers\API\User\UserController;
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

/**
 * The user api routes 
 * API Version: v1
 */
Route::group(['prefix' => 'v1/user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}/show', [UserController::class, 'show']);
    Route::get('{id}/detail', [UserController::class, 'detail']);
    Route::post('create', [UserController::class, 'create']);
    Route::put('update', [UserController::class, 'update']);
    Route::delete('delete', [UserController::class, 'delete']);
});

/**
 * The post api routes 
 * API Version: v1
 */
Route::group(['prefix' => 'v1/post', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [PostController::class, 'userPost']);
    Route::get('{id}/show', [PostController::class, 'show']);
    Route::get('{id}/detail', [PostController::class, 'detail']);
    Route::post('create', [PostController::class, 'create']);
    Route::put('update', [PostController::class, 'update']);
    Route::delete('delete', [PostController::class, 'delete']);
});