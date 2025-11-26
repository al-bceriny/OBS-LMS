<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Exams — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white p-6 shadow rounded">

            @if($exams->isEmpty())
                <p class="text-gray-500">No exams scheduled for this course.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Exam</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Time</th>
                            <th class="px-4 py-2 text-left">File</th>
                            <th class="px-4 py-2 text-left">Grade</th>
                            <th class="px-4 py-2 text-left">Comment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($exams as $exam)
                            @php
                                $result = $results[$exam->id] ?? null;
                            @endphp

                            <tr>
                                <td class="px-4 py-2">
                                    {{ $exam->title }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ ucfirst($exam->type) }}
                                </td>

                                <td class="px-4 py-2 text-sm text-gray-600">
                                    {{ $exam->start_time }} <br>
                                    <span class="text-xs">to {{ $exam->end_time }}</span>
                                </td>

                                <td class="px-4 py-2">
                                    @if($exam->file_path)
                                        <a href="{{ asset('storage/'.$exam->file_path) }}"
                                           class="text-blue-600 underline"
                                           download>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No file</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2">
                                    @if($result && $result->grade !== null)
                                        <span class="font-semibold text-green-700">
                                            {{ $result->grade }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Not graded</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 text-sm">
                                    @if($result && $result->comment)
                                        {{ $result->comment }}
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
