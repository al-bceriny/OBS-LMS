<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $courses = $student->courseOfferings()
            ->with(['course', 'teacher.user'])
            ->get();

        // الواجبات القادمة وغير المسلّمة
        $upcomingAssignments = Assignment::whereIn('course_offering_id', $courses->pluck('id'))
            ->where(function ($q) use ($student) {
                $q->whereDoesntHave('submissions', function ($q2) use ($student) {
                    $q2->where('student_id', $student->id);
                });
            })
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();

        // الامتحانات القادمة
        $upcomingExams = Exam::whereIn('course_offering_id', $courses->pluck('id'))
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // آخر العلامات التي حصل عليها
        $recentGrades = ExamResult::where('student_id', $student->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'student',
            'courses',
            'upcomingAssignments',
            'upcomingExams',
            'recentGrades'
        ));
    }
}
