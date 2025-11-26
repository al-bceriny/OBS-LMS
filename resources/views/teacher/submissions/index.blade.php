<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Submissions — {{ $assignment->title }} ({{ $offering->course->code }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($assignment->submissions->isEmpty())
                <p class="text-gray-500">No submissions yet.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Student</th>
                            <th class="px-4 py-2 text-left">Submitted At</th>
                            <th class="px-4 py-2 text-left">File</th>
                            <th class="px-4 py-2 text-left">Grade</th>
                            <th class="px-4 py-2 text-left">Comments</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($assignment->submissions as $submission)
                            <tr>
                                <td class="px-4 py-2">
                                    {{ $submission->student->user->name }}
                                    <div class="text-xs text-gray-500">
                                        {{ $submission->student->student_number }}
                                    </div>
                                </td>

                                <td class="px-4 py-2">
                                    {{ $submission->submitted_at }}
                                </td>

                                <td class="px-4 py-2">
                                    @if($submission->file_path)
                                        <a href="{{ asset('storage/'.$submission->file_path) }}"
                                           class="text-blue-600 underline"
                                           download>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm">No file</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2">
                                    {{ $submission->grade ?? '-' }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $submission->comments ?? '-' }}
                                </td>

                                <td class="px-4 py-2 text-right">
                                    <form method="POST"
                                          action="{{ route('teacher.submissions.update', [$offering, $assignment, $submission]) }}"
                                          class="space-y-1 inline-block text-left w-64">
                                        @csrf
                                        @method('PUT')

                                        <input type="number"
                                               name="grade"
                                               step="0.01"
                                               min="0" max="100"
                                               value="{{ old('grade', $submission->grade) }}"
                                               class="w-full border rounded p-1 text-sm mb-1"
                                               placeholder="Grade">

                                        <textarea name="comments"
                                                  rows="2"
                                                  class="w-full border rounded p-1 text-sm"
                                                  placeholder="Comments">{{ old('comments', $submission->comments) }}</textarea>

                                        <div class="mt-1 text-right">
                                            <button class="px-3 py-1 border bg-blue-600 text-xs rounded">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
