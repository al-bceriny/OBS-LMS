<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $offering->course->code }} — {{ $offering->course->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto">

            <div class="bg-white shadow rounded p-6 mb-6">
                <h3 class="text-lg font-semibold">Course Information</h3>
                <p>Teacher: <strong>{{ $offering->teacher->user->name }}</strong></p>
                <p>Section: {{ $offering->section }}</p>
                <p>Term: {{ ucfirst($offering->term) }}</p>
                <p>Academic Year: {{ $offering->academic_year }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-xl font-semibold">📚 Materials</h3>
                    <p class="text-sm text-gray-600 mb-2">Upload and manage course materials (PDFs, slides, etc.)</p>
                    <a href="{{ route('teacher.materials.index', $offering) }}" class="text-blue-600 underline">View
                        Materials</a>
                </div>

                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-xl font-semibold">📝 Assignments</h3>
                    <p class="text-sm text-gray-600 mb-2">Create assignments and review student submissions</p>
                    <a href="{{ route('teacher.assignments.index', $offering) }}" class="text-blue-600 underline">View
                        Assignments</a>
                </div>

                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-xl font-semibold">🧪 Exams</h3>
                    <p class="text-sm text-gray-600 mb-2">Schedule exams and share exam files with students</p>
                    <a href="{{ route('teacher.exams.index', $offering) }}" class="text-blue-600 underline">View
                        Exams</a>
                </div>

                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-xl font-semibold">👨‍🎓 Students</h3>
                    <p class="text-sm text-gray-600 mb-2">View enrolled students in this course offering</p>
                    <a href="{{ route('teacher.courses.students', $offering) }}" class="text-blue-600 underline">View
                        Students</a>
                </div>


                <div class="bg-white shadow rounded p-6">
                    <h3 class="text-xl font-semibold">🕒 Attendance</h3>
                    <p class="text-sm text-gray-600 mb-2">
                        Manage attendance sessions and student presence.
                    </p>
                    <a href="{{ route('teacher.attendance.index', $offering) }}" class="text-blue-600 underline">
                        View Attendance
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
