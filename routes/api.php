<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/articles', [\App\Http\Controllers\ArticlesController::class, 'create']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function() {
	
	// Auth
	Route::get('/me', [\App\Http\Controllers\LoginController::class, 'getMe']);
	Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
	
	//Articles
	Route::get('/articles', [\App\Http\Controllers\ArticlesController::class, 'getAuthorArticles'])->middleware('roles:author');
	
	//Reviews
	Route::get('/reviews/stats', [\App\Http\Controllers\ReviewsController::class, 'getReviewedArticlesWithStats'])->middleware('roles:reviewer');
	Route::get('/reviews', [\App\Http\Controllers\ReviewsController::class, 'getPendingArticles'])->middleware('roles:reviewer');
	Route::post('/reviews', [\App\Http\Controllers\ReviewsController::class, 'postArticleReview'])->middleware('roles:reviewer');
	
});
