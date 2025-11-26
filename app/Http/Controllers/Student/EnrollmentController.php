<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'No student profile found.');
        }

        // المواد المسجل فيها الطالب
        $enrolledOfferings = $student->courseOfferings()
            ->with(['course', 'teacher.user'])
            ->orderBy('academic_year', 'desc')
            ->get();

        // المواد المتاحة للتسجيل (ليس مسجلاً فيها)
        $availableOfferings = CourseOffering::with(['course', 'teacher.user'])
            ->whereDoesntHave('students', function ($q) use ($student) {
                $q->where('students.id', $student->id);
            })
            ->orderBy('academic_year', 'desc')
            ->get();

        return view('student.courses.index', compact('student', 'enrolledOfferings', 'availableOfferings'));
    }

    public function enroll(CourseOffering $offering)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'No student profile found.');
        }

        // تأكيد عدم التسجيل المسبق
        Enrollment::firstOrCreate([
            'student_id'        => $student->id,
            'course_offering_id'=> $offering->id,
        ]);

        return back()->with('success', 'Enrolled in course successfully.');
    }

    public function unenroll(CourseOffering $offering)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'No student profile found.');
        }

        Enrollment::where('student_id', $student->id)
            ->where('course_offering_id', $offering->id)
            ->delete();

        return back()->with('success', 'Unenrolled from course.');
    }
}
