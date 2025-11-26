<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
    public function index(CourseOffering $offering, Exam $exam)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        // تحميل الطلاب المسجلين + نتائجهم
        $students = $offering->students()->with('user')->get();

        // استرجاع النتائج الموجودة
        $results = ExamResult::where('exam_id', $exam->id)->get()->keyBy('student_id');

        return view('teacher.exams.results', compact('offering', 'exam', 'students', 'results'));
    }

    public function update(
        Request $request,
        CourseOffering $offering,
        Exam $exam,
        $studentId
    ) {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'grade'   => 'nullable|numeric|min:0|max:100',
            'comment' => 'nullable|string',
        ]);

        ExamResult::updateOrCreate(
            [
                'exam_id'   => $exam->id,
                'student_id'=> $studentId
            ],
            [
                'grade'     => $request->grade,
                'comment'   => $request->comment,
            ]
        );

        return back()->with('success', 'Grades updated successfully!');
    }
}
