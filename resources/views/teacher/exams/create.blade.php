<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Create Exam — {{ $offering->course->code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('teacher.exams.store', $offering) }}"
                  enctype="multipart/form-data"
                  class="space-y-4">

                @csrf

                <div>
                    <label class="block font-medium">Title</label>
                    <input type="text" name="title"
                           class="w-full border rounded p-2"
                           value="{{ old('title') }}">
                </div>

                <div>
                    <label class="block font-medium">Exam Type</label>
                    <select name="type"
                            class="w-full border rounded p-2">
                        <option value="midterm">Midterm</option>
                        <option value="final">Final</option>
                        <option value="quiz">Quiz</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium">Start Time</label>
                    <input type="datetime-local" name="start_time"
                           class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-medium">End Time</label>
                    <input type="datetime-local" name="end_time"
                           class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-medium">Exam File (Optional)</label>
                    <input type="file" name="file"
                           class="border rounded p-2 w-full">
                </div>

                <div>
                    <label class="block font-medium">Description</label>
                    <textarea name="description"
                              class="w-full border rounded p-2"
                              rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-blue-600 border rounded">
                        Create Exam
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
