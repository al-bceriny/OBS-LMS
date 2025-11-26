<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Exams — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            <a href="{{ route('teacher.exams.create', $offering) }}" class="px-4 py-2 bg-blue-600 border rounded">
                + Add Exam
            </a>

            <div class="mt-6">

                @if (session('success'))
                    <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($exams->isEmpty())
                    <p class="text-gray-500">No exams scheduled.</p>
                @else
                    <ul class="divide-y divide-gray-300">
                        @foreach ($exams as $exam)
                            <li class="py-4">
                                <div class="flex justify-between items-center">

                                    <div>
                                        <h3 class="font-semibold">{{ $exam->title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ ucfirst($exam->type) }} —
                                            {{ $exam->start_time }} to {{ $exam->end_time }}
                                        </p>

                                        @if ($exam->file_path)
                                            <a href="{{ asset('storage/' . $exam->file_path) }}"
                                                class="text-blue-600 underline" download>
                                                Download Exam File
                                            </a>
                                        @endif
                                    </div>

                                    <div class="flex space-x-3 items-center">
                                        <a href="{{ route('teacher.exams.results.index', [$offering, $exam]) }}"
                                            class="px-3 py-1 bg-green-600 border text-sm rounded">
                                            View Results
                                        </a>
                                    </div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
