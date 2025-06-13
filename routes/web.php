<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\LearnerProgressController;

Route::get('/learner-progress', [LearnerProgressController::class, 'index'])->name('learner-progress');
