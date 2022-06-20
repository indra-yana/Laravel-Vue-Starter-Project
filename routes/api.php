<?php

use App\Http\Controllers\API\Post\PostController;
use App\Http\Controllers\API\SocialLink\SocialLinkController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\API\Util\UtilityController;
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
    Route::get('/', [UserController::class, 'index'])->name('api.user.index');
    Route::get('{id}/show', [UserController::class, 'show'])->name('api.user.show');
    Route::get('{id}/detail', [UserController::class, 'detail'])->name('api.user.detail');
    Route::post('create', [UserController::class, 'create'])->name('api.user.create');
    Route::put('update', [UserController::class, 'update'])->name('api.user.update');
    Route::delete('delete', [UserController::class, 'delete'])->name('api.user.delete');
    Route::put('password/change', [UserController::class, 'changePassword'])->name('api.user.password.change');
});

/**
 * The post api routes 
 * API Version: v1
 */
Route::group(['prefix' => 'v1/post', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/', [PostController::class, 'userPost'])->name('api.post.user');
    Route::get('{id}/show', [PostController::class, 'show'])->name('api.post.show');
    Route::get('{id}/detail', [PostController::class, 'detail'])->name('api.post.detail');
    Route::get('dt-table.json', [PostController::class, 'dtTableJson'])->name('api.post.table');
    Route::post('create', [PostController::class, 'create'])->name('api.post.create');
    Route::put('update', [PostController::class, 'update'])->name('api.post.update');
    Route::delete('delete', [PostController::class, 'delete'])->name('api.post.delete');
});

/**
 * The social link api routes 
 * API Version: v1
 */
Route::group(['prefix' => 'v1/social-link', 'middleware' => ['auth:sanctum']], function () {
    Route::get('{user_id}', [SocialLinkController::class, 'show'])->name('api.sociallink.show')->withoutMiddleware(['auth:sanctum']);
    Route::post('create', [SocialLinkController::class, "create"])->name('api.sociallink.create');
});

/**
 * The utils api routes 
 * API Version: v1
 */
Route::group(['prefix' => 'v1/utils', 'middleware' => ['auth:sanctum']], function () {
    Route::get('meta', [UtilityController::class, 'meta'])->name('api.utils.meta')->withoutMiddleware(['auth:sanctum']);
    Route::post('editorjs/upload/byfile', [UtilityController::class, "uploadByFile"])->name('api.utils.editorjs.upload.byfile');
    Route::post('editorjs/upload/byurl', [UtilityController::class, "uploadByFile"])->name('api.utils.editorjs.upload.byurl');
});