<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseOffering;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseOfferingController extends Controller
{
    public function index()
    {
        $offerings = CourseOffering::with(['course', 'teacher.user'])
            ->orderBy('academic_year', 'desc')
            ->paginate(10);

        return view('admin.course_offerings.index', compact('offerings'));
    }

    public function create()
    {
        $courses  = Course::orderBy('code')->get();
        $teachers = Teacher::with('user')->orderBy('id')->get();

        return view('admin.course_offerings.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'teacher_id'    => 'required|exists:teachers,id',
            'academic_year' => 'required|string|max:20',
            'term'          => 'required|in:fall,spring,summer',
            'section'       => 'required|string|max:10',
        ]);

        CourseOffering::create($request->all());

        return redirect()
            ->route('admin.course-offerings.index')
            ->with('success', 'Course offering created successfully.');
    }

    public function edit(CourseOffering $courseOffering)
    {
        $courses  = Course::orderBy('code')->get();
        $teachers = Teacher::with('user')->get();

        return view('admin.course_offerings.edit', compact('courseOffering', 'courses', 'teachers'));
    }

    public function update(Request $request, CourseOffering $courseOffering)
    {
        $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'teacher_id'    => 'required|exists:teachers,id',
            'academic_year' => 'required|string|max:20',
            'term'          => 'required|in:fall,spring,summer',
            'section'       => 'required|string|max:10',
        ]);

        $courseOffering->update($request->all());

        return redirect()
            ->route('admin.course-offerings.index')
            ->with('success', 'Course offering updated successfully.');
    }

    public function destroy(CourseOffering $courseOffering)
    {
        $courseOffering->delete();

        return redirect()
            ->route('admin.course-offerings.index')
            ->with('success', 'Course offering deleted successfully.');
    }
}
