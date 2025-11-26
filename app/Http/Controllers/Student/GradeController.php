<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use App\Models\Submission;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    // صفحة Transcript: جميع المواد
    public function index()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        // كل الشعب اللي الطالب مسجّل فيها
        $offerings = $student->courseOfferings()
            ->with(['course', 'teacher.user'])
            ->get();

        $records = [];

        foreach ($offerings as $offering) {
            // درجات الواجبات
            $assignmentGrades = Submission::where('student_id', $student->id)
                ->whereHas('assignment', function ($q) use ($offering) {
                    $q->where('course_offering_id', $offering->id);
                })
                ->whereNotNull('grade')
                ->pluck('grade')
                ->toArray();

            // درجات الامتحانات
            $examGrades = ExamResult::where('student_id', $student->id)
                ->whereHas('exam', function ($q) use ($offering) {
                    $q->where('course_offering_id', $offering->id);
                })
                ->whereNotNull('grade')
                ->pluck('grade')
                ->toArray();

            $assignmentAvg = count($assignmentGrades)
                ? round(array_sum($assignmentGrades) / count($assignmentGrades), 2)
                : null;

            $examAvg = count($examGrades)
                ? round(array_sum($examGrades) / count($examGrades), 2)
                : null;

            // حساب الدرجة النهائية (40% واجبات، 60% امتحانات)
            $final = null;
            if ($assignmentAvg !== null || $examAvg !== null) {
                $assignPart = $assignmentAvg !== null ? $assignmentAvg * 0.4 : 0;
                $examPart   = $examAvg !== null ? $examAvg * 0.6 : 0;

                // لو ما فيه غير نوع واحد نستخدمه كله
                if ($assignmentAvg === null && $examAvg !== null) {
                    $final = $examAvg;
                } elseif ($examAvg === null && $assignmentAvg !== null) {
                    $final = $assignmentAvg;
                } else {
                    $final = round($assignPart + $examPart, 2);
                }
            }

            $records[] = [
                'offering'       => $offering,
                'assignmentAvg'  => $assignmentAvg,
                'examAvg'        => $examAvg,
                'final'          => $final,
            ];
        }

        return view('student.grades.index', compact('student', 'records'));
    }

    // صفحة تفاصيل درجات مادة واحدة
    public function show(CourseOffering $offering)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        // تأكد أن الطالب مسجل بالمادة
        $isEnrolled = $offering->students()->where('students.id', $student->id)->exists();
        if (! $isEnrolled) {
            abort(403);
        }

        // الواجبات + تسليم الطالب
        $assignments = $offering->assignments()
            ->with(['submissions' => function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->orderBy('deadline')
            ->get();

        // الامتحانات + نتيجة الطالب
        $exams = $offering->exams()
            ->with(['results' => function ($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->orderBy('start_time')
            ->get();

        return view('student.grades.show', compact(
            'student',
            'offering',
            'assignments',
            'exams'
        ));
    }
}
