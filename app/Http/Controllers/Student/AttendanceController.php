<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\CourseOffering;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(CourseOffering $offering)
    {
        $student = Auth::user()->student;

        // تأكد أن الطالب مسجل بالشعبة
        $isEnrolled = $offering->students()->where('students.id', $student->id)->exists();
        if (! $isEnrolled) {
            abort(403);
        }

        // جميع جلسات الحضور لهذه الشعبة
        $sessions = AttendanceSession::where('course_offering_id', $offering->id)
            ->orderBy('date')
            ->get();

        // سجلات حضور الطالب
        $records = AttendanceRecord::where('student_id', $student->id)
            ->whereIn('attendance_session_id', $sessions->pluck('id'))
            ->get()
            ->keyBy('attendance_session_id');

        // حساب الإحصائيات
        $summary = [
            'total'   => $sessions->count(),
            'present' => $records->where('status', 'present')->count(),
            'absent'  => $records->where('status', 'absent')->count(),
            'late'    => $records->where('status', 'late')->count(),
            'excused' => $records->where('status', 'excused')->count(),
        ];

        $summary['percentage'] = $summary['total'] > 0
            ? round(($summary['present'] / $summary['total']) * 100, 2)
            : 0;

        return view('student.attendance.index', compact(
            'offering',
            'sessions',
            'records',
            'summary'
        ));
    }
}
