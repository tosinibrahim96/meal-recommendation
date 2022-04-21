<?php

use App\Http\Controllers\Api\AllergyController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\MealItemController;
use App\Http\Controllers\Api\MealRecommendationController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/meals', [MealController::class, 'store']);
        Route::put('/meals/{id}', [MealController::class, 'update']);
        Route::get('/meals/{id}', [MealController::class, 'show']);
        Route::get('/meals', [MealController::class, 'index']);
        Route::delete('/meals/{id}', [MealController::class, 'destroy']);


        Route::post('/meal-items', [MealItemController::class, 'store']);
        Route::get('/meal-items', [MealItemController::class, 'index']);
        Route::put('/meal-items/{id}', [MealItemController::class, 'update']);
        Route::get('/meal-items/{id}', [MealItemController::class, 'show']);
        Route::delete('/meal-items/{id}', [MealItemController::class, 'destroy']);

        Route::get('/allergies', [AllergyController::class, 'index']);

        Route::put('/user-profile/{id}', [UserProfileController::class, 'update']);
        Route::get('/user-profile/{id}', [UserProfileController::class, 'show']);

        Route::get('/users/{id}/meal-recommendations', [MealRecommendationController::class, 'recommendForOne']);
        Route::post('/users/meal-recommendations', [MealRecommendationController::class, 'recommendForMany']);
    });

});
