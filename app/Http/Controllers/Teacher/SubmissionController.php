<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function index(CourseOffering $offering, Assignment $assignment)
    {
        // تأكد أن المعلم صاحب هذه الشعبة
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        // تأكد أن الواجب تابع لنفس الشعبة
        if ($assignment->course_offering_id !== $offering->id) {
            abort(404);
        }

        $assignment->load([
            'submissions.student.user',
        ]);

        return view('teacher.submissions.index', compact('offering', 'assignment'));
    }

    public function update(
        Request $request,
        CourseOffering $offering,
        Assignment $assignment,
        Submission $submission
    ) {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        if (
            $assignment->course_offering_id !== $offering->id ||
            $submission->assignment_id !== $assignment->id
        ) {
            abort(404);
        }

        $request->validate([
            'grade'   => 'nullable|numeric|min:0|max:100',
            'comments' => 'nullable|string',
        ]);

        $submission->update([
            'grade'   => $request->grade,
            'comments' => $request->comments,
        ]);

        $studentUserId = $submission->student->user->id;

        notify_user(
            $studentUserId,
            'Assignment Graded',
            "Your assignment '{$assignment->title}' has been graded.",
            route('student.assignments.show', $assignment)
        );

        return back()->with('success', 'Submission updated successfully.');
    }
}
