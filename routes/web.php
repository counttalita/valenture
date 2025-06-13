<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/learner-progress');

use App\Http\Controllers\LearnerProgressController;

Route::get('/learner-progress', [LearnerProgressController::class, 'index'])->name('learner-progress');
