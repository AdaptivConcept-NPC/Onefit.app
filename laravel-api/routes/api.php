<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\FitnessController;
use App\Http\Controllers\Api\CommunityController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::get('/profile/socials', [ProfileController::class, 'getSocials']);
    Route::post('/profile/socials', [ProfileController::class, 'updateSocials']);

    // Fitness routes
    Route::get('/exercises', [FitnessController::class, 'getExercises']);
    Route::get('/programs', [FitnessController::class, 'getPrograms']);
    Route::post('/metrics', [FitnessController::class, 'logMetric']);

    // Community routes
    Route::get('/friends', [CommunityController::class, 'getFriends']);
    Route::get('/conversations', [CommunityController::class, 'getConversations']);
    Route::get('/conversations/{id}/messages', [CommunityController::class, 'getMessages']);
    Route::get('/notifications', [CommunityController::class, 'getNotifications']);
});
