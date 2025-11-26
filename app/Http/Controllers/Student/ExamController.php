<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index(CourseOffering $offering)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'No student profile found.');
        }

        // for checking enrollment for this student
        $isEnrolled = $offering->students()
            ->where('students.id', $student->id)
            ->exists();

        if (! $isEnrolled) {
            abort(403, 'You are not enrolled in this course.');
        }

        // all exams for this offering
        $exams = Exam::where('course_offering_id', $offering->id)
            ->orderBy('start_time')
            ->get();

        // get exam results for this student
        $results = ExamResult::where('student_id', $student->id)
            ->whereIn('exam_id', $exams->pluck('id'))
            ->get()
            ->keyBy('exam_id'); // حتى نعمل $results[$exam->id] بسهولة

        return view('student.exams.index', compact('offering', 'exams', 'results'));
    }
}
