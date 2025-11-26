<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user', 'department')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.students.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'student_number'=> 'required|string|max:50|unique:students,student_number',
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|numeric|min:1|max:8',
        ]);

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'student',
            'password' => bcrypt($request->password),
        ]);

        // Create student profile
        Student::create([
            'user_id'       => $user->id,
            'student_number'=> $request->student_number,
            'department_id' => $request->department_id,
            'semester'      => $request->semester,
        ]);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $student->user_id,
            'student_number'=> 'required|string|max:50|unique:students,student_number,' . $student->id,
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|numeric|min:1|max:8',
        ]);

        $student->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $student->update([
            'student_number'=> $request->student_number,
            'department_id' => $request->department_id,
            'semester'      => $request->semester,
        ]);

        return redirect()->route('admin.students.index')
                        ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete(); // cascades
        return redirect()->route('admin.students.index')
                        ->with('success', 'Student deleted successfully.');
    }
}
