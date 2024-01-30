<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\FeedbackController;
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

Route::post('login',[UserController::class, 'login']);
Route::post('register',[UserController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {

    Route::apiResource('feedback',FeedbackController::class)->only(['index','store']);
    Route::post('feedback-comment',[FeedbackController::class, 'feedbackComment']);
    
    Route::get('category',[FeedbackController::class, 'fetchCategories']);

    Route::prefix('user')->group(function() {
        Route::get('/list',[UserController::class, 'index']);
        Route::post('logout',[UserController::class, 'logout']);
    });

});
