<?php

use App\Http\Controllers\BlogController;
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

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::post('/create-blog', [BlogController::class, 'store']);
Route::patch('/edit-blog/{id}', [BlogController::class, 'update']);
Route::delete('/delete-blog/{id}', [BlogController::class, 'destroy']);
Route::get('/search-data/{param}', [BlogController::class, 'searchBlogByName']);
