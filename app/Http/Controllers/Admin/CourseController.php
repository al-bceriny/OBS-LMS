<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('department')
        ->orderBy('code')
        ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:courses,code',
            'name' => 'required|string|max:255',
            'credit' => 'required|numeric|min:1|max:15',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'nullable|numeric|min:1|max:8',
        ]);

        Course::create($request->all());

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        //
    }

    public function edit(Course $course)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'credit' => 'required|numeric|min:1|max:15',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'nullable|numeric|min:1|max:8',
        ]);

        $course->update($request->all());

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
