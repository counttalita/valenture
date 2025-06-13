<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearnerProgressController;

Route::get('/learners', [LearnerProgressController::class, 'api']);
Route::get('/courses', [LearnerProgressController::class, 'courses']);

// Test route for api
Route::get('/test-api', function() {
    return response()->json(['message' => 'api route works']);
});
