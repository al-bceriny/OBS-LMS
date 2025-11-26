<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use App\Models\CourseOffering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized');
        }

        $materials = Material::where('course_offering_id', $offering->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.materials.index', compact('offering', 'materials'));
    }

    public function create(CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized');
        }

        return view('teacher.materials.create', compact('offering'));
    }

    public function store(Request $request, CourseOffering $offering)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|max:51200', // 50MB
        ]);

        $path = $request->file('file')->store('materials', 'public');

        Material::create([
            'course_offering_id' => $offering->id,
            'title'              => $request->title,
            'description'        => $request->description,
            'file_path'          => $path,
        ]);

        return redirect()
            ->route('teacher.materials.index', $offering)
            ->with('success', 'Material uploaded successfully.');
    }

    public function destroy(CourseOffering $offering, Material $material)
    {
        if ($offering->teacher_id !== Auth::user()->teacher->id) {
            abort(403, 'Unauthorized');
        }

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()
            ->route('teacher.materials.index', $offering)
            ->with('success', 'Material deleted successfully.');
    }
}
