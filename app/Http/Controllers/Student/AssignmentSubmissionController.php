<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentSubmissionController extends Controller
{
    public function show(Assignment $assignment)
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
        abort(403, 'No student profile found for this user Contact us at telegram @al_bceriny.');
    }

        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();

        return view('student.assignments.show', compact('assignment', 'submission'));
    }

    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $user = Auth::user();
        $student = $user->student;
        if (!$student) {
            abort(403, 'No student profile found for this user. Contact us at telegram @al_bceriny.');
        }

        $path = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id'    => $student->id,
            'file_path'     => $path,
            'submitted_at'  => now(),
        ]);

        return back()->with('success', 'Assignment submitted successfully.');
    }
}
