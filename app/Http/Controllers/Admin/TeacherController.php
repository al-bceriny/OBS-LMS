<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user', 'department')->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.teachers.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'department_id' => 'required|exists:departments,id',
            'title'         => 'nullable|string|max:255',
        ]);

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'teacher',
            'password' => bcrypt($request->password),
        ]);

        // Create teacher profile
        Teacher::create([
            'user_id'       => $user->id,
            'department_id' => $request->department_id,
            'title'         => $request->title,
        ]);

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.teachers.edit', compact('teacher', 'departments'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $teacher->user_id,
            'department_id' => 'required|exists:departments,id',
            'title'         => 'nullable|string|max:255',
        ]);

        $teacher->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $teacher->update([
            'department_id' => $request->department_id,
            'title'         => $request->title,
        ]);

        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete(); // cascades
        return redirect()->route('admin.teachers.index')
                        ->with('success', 'Teacher deleted successfully.');
    }
}
