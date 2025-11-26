<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherCourseController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->teacher->id;

        $offerings = CourseOffering::with('course')
            ->where('teacher_id', $teacherId)
            ->orderBy('academic_year', 'desc')
            ->get();

        return view('teacher.courses.index', compact('offerings'));
    }

    public function show(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized');
        }

        $offering->load(['course', 'teacher.user']);

        return view('teacher.courses.show', compact('offering'));
    }
}
