<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold">
            Student Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- معلومات الطالب --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">👨‍🎓 Student Info</h3>
                <p><strong>Name:</strong> {{ $student->user->name }}</p>
                <p><strong>Student Number:</strong> {{ $student->student_number }}</p>
                <p><strong>Department:</strong> {{ $student->department->name }}</p>
                <p><strong>Semester:</strong> {{ $student->semester }}</p>
            </div>

            {{-- المواد المسجل فيها --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">📚 My Courses</h3>

                @if($courses->isEmpty())
                    <p class="text-gray-500">You are not enrolled in any course.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($courses as $off)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold">{{ $off->course->code }} — {{ $off->course->name }}</h4>
                                    <p class="text-sm text-gray-600">Teacher: {{ $off->teacher->user->name }}</p>
                                </div>

                                <div>
                                    <a href="{{ route('student.courses.exams.index', $off) }}"
                                       class="px-3 py-1 bg-blue-600 border text-xs rounded">
                                        Exams
                                    </a>
                                    <a href="{{ route('student.courses.attendance.index', $off) }}"
                                            class="px-3 py-1 bg-green-600 border text-xs rounded">
                                            Attendance
                                        </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Upcoming Assignments --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">📝 Upcoming Assignments</h3>

                @if($upcomingAssignments->isEmpty())
                    <p class="text-gray-500">No upcoming assignments.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($upcomingAssignments as $assign)
                            <li class="py-3">
                                <h4 class="font-semibold">{{ $assign->title }}</h4>
                                <p class="text-sm text-gray-600">
                                    Deadline: {{ $assign->deadline }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Upcoming Exams --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">🧪 Upcoming Exams</h3>

                @if($upcomingExams->isEmpty())
                    <p class="text-gray-500">No upcoming exams.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($upcomingExams as $exam)
                            <li class="py-3">
                                <h4 class="font-semibold">{{ $exam->title }}</h4>
                                <p class="text-sm text-gray-600">
                                    {{ $exam->start_time }} → {{ $exam->end_time }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Latest Grades --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">⭐ Recent Grades</h3>

                @if($recentGrades->isEmpty())
                    <p class="text-gray-500">No recent grades.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($recentGrades as $g)
                            <li class="py-3">
                                <strong>{{ $g->exam->title }}</strong> —
                                Grade: <span class="font-semibold">{{ $g->grade }}</span>

                                @if($g->comment)
                                    <p class="text-sm text-gray-600">Comment: {{ $g->comment }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
