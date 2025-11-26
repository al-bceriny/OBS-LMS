<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Exam Results — {{ $exam->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            @if(session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Student</th>
                        <th class="px-4 py-2 text-left">Grade</th>
                        <th class="px-4 py-2 text-left">Comment</th>
                        <th class="px-4 py-2 text-right">Save</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $student)
                        @php
                            $result = $results[$student->id] ?? null;
                        @endphp

                        <tr>
                            <td class="px-4 py-2">
                                {{ $student->user->name }}
                            </td>

                            <td class="px-4 py-2">
                                <form method="POST"
                                      action="{{ route('teacher.exams.results.update', [$offering, $exam, $student->id]) }}"
                                      class="flex space-x-2">
                                    @csrf
                                    @method('PUT')

                                    <input type="number"
                                           name="grade"
                                           value="{{ $result->grade ?? '' }}"
                                           step="0.01"
                                           min="0" max="100"
                                           class="border rounded p-1 w-20">

                                    <input type="text"
                                           name="comment"
                                           value="{{ $result->comment ?? '' }}"
                                           class="border rounded p-1 w-64">

                                    <button class="bg-blue-600 border px-3 py-1 rounded text-sm">
                                        Save
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
