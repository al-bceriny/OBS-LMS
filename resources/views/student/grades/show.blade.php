<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Grades — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto space-y-8">

            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-2">Course Info</h3>
                <p><strong>Course:</strong> {{ $offering->course->name }}</p>
                <p><strong>Teacher:</strong> {{ $offering->teacher->user->name }}</p>
                <p><strong>Term:</strong> {{ $offering->academic_year }} / {{ ucfirst($offering->term) }}</p>
            </div>

            {{-- Assignments --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">📝 Assignments</h3>

                @if($assignments->isEmpty())
                    <p class="text-gray-500">No assignments for this course.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Deadline</th>
                                <th class="px-4 py-2 text-center">Grade</th>
                                <th class="px-4 py-2 text-left">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($assignments as $a)
                                @php
                                    $sub = $a->submissions->first();
                                @endphp
                                <tr>
                                    <td class="px-4 py-2">{{ $a->title }}</td>
                                    <td class="px-4 py-2">{{ $a->deadline ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">
                                        {{ $sub && $sub->grade !== null ? $sub->grade : '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $sub && $sub->comment ? $sub->comment : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Exams --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="text-lg font-semibold mb-3">🧪 Exams</h3>

                @if($exams->isEmpty())
                    <p class="text-gray-500">No exams for this course.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Exam</th>
                                <th class="px-4 py-2 text-left">Type</th>
                                <th class="px-4 py-2 text-left">Time</th>
                                <th class="px-4 py-2 text-center">Grade</th>
                                <th class="px-4 py-2 text-left">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($exams as $exam)
                                @php
                                    $res = $exam->results->first();
                                @endphp
                                <tr>
                                    <td class="px-4 py-2">{{ $exam->title }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($exam->type) }}</td>
                                    <td class="px-4 py-2 text-xs text-gray-600">
                                        {{ $exam->start_time }}<br>
                                        to {{ $exam->end_time }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        {{ $res && $res->grade !== null ? $res->grade : '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $res && $res->comment ? $res->comment : '-' }}
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
