<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use App\Models\Course;
use Illuminate\Http\Request;

class LearnerProgressController extends Controller
{
    // Show the dashboard page
    public function index()
    {
        return view('learner-progress.index');
    }

    // API endpoint: Return learners with their courses and progress
    public function api()
    {
        $learners = Learner::with(['courses' => function($query) {
            $query->withPivot('progress');
        }])->get();
        return response()->json($learners);
    }

    // API endpoint: Return all courses (for filtering UI)
    public function courses()
    {
        $courses = Course::all(['id', 'name']);
        return response()->json($courses);
    }
}
