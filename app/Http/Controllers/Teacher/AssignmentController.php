<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Assignment;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $assignments = Assignment::where('course_offering_id', $offering->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.assignments.index', compact('offering', 'assignments'));
    }

    public function create(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        return view('teacher.assignments.create', compact('offering'));
    }

    public function store(Request $request, CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'nullable|date',
            'file'        => 'nullable|file|max:51200',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments', 'public');
        }

        $assignment = Assignment::create([
            'course_offering_id' => $offering->id,
            'title'              => $request->title,
            'description'        => $request->description,
            'deadline'           => $request->deadline,
            'file_path'          => $path,
        ]);

        $offering->load('students.user');

    foreach ($offering->students as $student) {
        notify_user(
            $student->user->id,
            'New Assignment Posted',
            "A new assignment titled '{$assignment->title}' has been posted for your course '{$offering->course->name}'.",
            route('student.assignments.show', $assignment)
        );
    }

        return redirect()
            ->route('teacher.assignments.index', $offering)
            ->with('success', 'Assignment created successfully.');
    }

    public function destroy(CourseOffering $offering, Assignment $assignment)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        return redirect()
            ->route('teacher.assignments.index', $offering)
            ->with('success', 'Assignment deleted.');
    }
}
