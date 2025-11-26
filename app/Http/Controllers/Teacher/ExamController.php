<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $exams = Exam::where('course_offering_id', $offering->id)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('teacher.exams.index', compact('offering', 'exams'));
    }

    public function create(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        return view('teacher.exams.create', compact('offering'));
    }

    public function store(Request $request, CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|in:midterm,final,quiz',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'file'        => 'nullable|file|max:51200',
            'description' => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('exams', 'public');
        }

        $exam = Exam::create([
            'course_offering_id' => $offering->id,
            'title'              => $request->title,
            'type'               => $request->type,
            'start_time'         => $request->start_time,
            'end_time'           => $request->end_time,
            'file_path'          => $path,
            'description'        => $request->description,
        ]);
        // Notify all students enrolled in the course offering about the new exam
        $offering->load('students.user');

        foreach ($offering->students as $student) {
            notify_user(
                $student->user->id,
                'New Exam Scheduled',
                "A new exam '{$exam->title}' has been scheduled.",
                route('student.courses.exams.index', $offering)
            );
        }

        return redirect()
            ->route('teacher.exams.index', $offering)
            ->with('success', 'Exam created successfully.');
    }
}
