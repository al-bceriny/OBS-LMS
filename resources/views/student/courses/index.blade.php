<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            My Courses
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto space-y-8">

            {{-- رسائل النجاح --}}
            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Courses المسجّل فيها --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-4">Enrolled Courses</h3>

                @if ($enrolledOfferings->isEmpty())
                    <p class="text-gray-500">You are not enrolled in any course yet.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Course</th>
                                <th class="px-4 py-2 text-left">Teacher</th>
                                <th class="px-4 py-2 text-left">Year / Term</th>
                                <th class="px-4 py-2 text-left">Section</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($enrolledOfferings as $off)
                                <tr>
                                    <td class="px-4 py-2">
                                        {{ $off->course->code }} — {{ $off->course->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->teacher->user->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->academic_year }} / {{ ucfirst($off->term) }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->section }}
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-2">

                                        <a href="{{ route('student.courses.exams.index', $off) }}"
                                            class="px-3 py-1 bg-blue-600 border text-xs rounded">
                                            Exams
                                        </a>
                                        <a href="{{ route('student.courses.grades.show', $off) }}"
                                            class="px-3 py-1 bg-purple-600 border text-xs rounded">
                                            Grades
                                        </a>

                                        <a href="{{ route('student.courses.attendance.index', $off) }}"
                                            class="px-3 py-1 bg-green-600 border text-xs rounded">
                                            Attendance
                                        </a>

                                        <form method="POST" action="{{ route('student.courses.unenroll', $off) }}"
                                            class="inline" onsubmit="return confirm('Unenroll from this course?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 text-xs">
                                                Unenroll
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Courses المتاحة للتسجيل --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-4">Available Courses</h3>

                @if ($availableOfferings->isEmpty())
                    <p class="text-gray-500">No available courses to enroll.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Course</th>
                                <th class="px-4 py-2 text-left">Teacher</th>
                                <th class="px-4 py-2 text-left">Year / Term</th>
                                <th class="px-4 py-2 text-left">Section</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($availableOfferings as $off)
                                <tr>
                                    <td class="px-4 py-2">
                                        {{ $off->course->code }} — {{ $off->course->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->teacher->user->name }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->academic_year }} / {{ ucfirst($off->term) }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $off->section }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <form method="POST" action="{{ route('student.courses.enroll', $off) }}">
                                            @csrf
                                            <button class="px-3 py-1 bg-blue-600 border text-sm rounded">
                                                Enroll
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
