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
    public function api(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $query = Learner::with(['courses' => function($query) {
            $query->withPivot('progress');
        }]);
        // Filter by course_id if provided
        if ($request->filled('course_id')) {
            $courseId = $request->input('course_id');
            $query->whereHas('courses', function($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }
        if ($request->has('page')) {
            $learners = $query->paginate($perPage);
        } else {
            $learners = $query->get();
        }
        return response()->json($learners);
    }

    // API endpoint: Return all courses (for filtering UI)
    public function courses()
    {
        $courses = Course::all(['id', 'name']);
        return response()->json($courses);
    }
}
