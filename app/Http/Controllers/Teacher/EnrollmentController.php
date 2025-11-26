<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $offering->load(['students.user']);

        return view('teacher.courses.students', compact('offering'));
    }
}
