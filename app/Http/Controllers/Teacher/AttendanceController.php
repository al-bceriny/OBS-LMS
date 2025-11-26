<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $sessions = $offering->attendanceSessions()
            ->withCount('records')
            ->orderBy('date', 'desc')
            ->get();

        return view('teacher.attendance.index', compact('offering', 'sessions'));
    }

    public function create(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        return view('teacher.attendance.create', compact('offering'));
    }

    public function store(Request $request, CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403);
        }

        $request->validate([
            'date'  => 'required|date',
            'topic' => 'nullable|string',
        ]);

        $session = AttendanceSession::create([
            'course_offering_id' => $offering->id,
            'date'               => $request->date,
            'topic'              => $request->topic,
        ]);

        return redirect()
            ->route('teacher.attendance.mark', [$offering, $session])
            ->with('success', 'Attendance session created. You can now mark students.');
    }

    public function mark(CourseOffering $offering, AttendanceSession $session)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id ||
            $session->course_offering_id !== $offering->id) {
            abort(403);
        }

        $students = $offering->students()->with('user')->get();

        // سجلات موجودة للحضور
        $records = $session->records()
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.mark', compact(
            'offering',
            'session',
            'students',
            'records'
        ));
    }

    public function update(Request $request, CourseOffering $offering, AttendanceSession $session)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id ||
            $session->course_offering_id !== $offering->id) {
            abort(403);
        }

        $statuses = $request->input('status', []); // [student_id => status]
        $notes    = $request->input('note', []);   // [student_id => note]

        foreach ($statuses as $studentId => $status) {
            if (!in_array($status, ['present', 'absent', 'late', 'excused'])) {
                continue;
            }

            AttendanceRecord::updateOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'student_id'            => $studentId,
                ],
                [
                    'status' => $status,
                    'note'   => $notes[$studentId] ?? null,
                ]
            );
        }

        return back()->with('success', 'Attendance updated successfully.');
    }
}
