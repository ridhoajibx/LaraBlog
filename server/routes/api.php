<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->apiResource('/posts', PostController::class)->except(['create', 'edit']);
Route::get('/posts/search/{param}', [SearchController::class, 'searchPost']);

Route::post('/registration', [UserController::class, 'registration']);
Route::post('/login', [UserController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function() {
    // manggil controller sesuai bawaan laravel 8
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('details', [UserController::class, 'details']);
});
