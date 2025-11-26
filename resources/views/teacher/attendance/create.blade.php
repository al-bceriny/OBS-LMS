<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            New Attendance Session — {{ $offering->course->code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white shadow rounded p-6">

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('teacher.attendance.store', $offering) }}"
                  class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium">Date</label>
                    <input type="date" name="date"
                           class="w-full border rounded p-2"
                           value="{{ old('date', now()->toDateString()) }}">
                </div>

                <div>
                    <label class="block font-medium">Topic (optional)</label>
                    <input type="text" name="topic"
                           class="w-full border rounded p-2"
                           value="{{ old('topic') }}">
                </div>

                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-blue-600 border rounded">
                        Create & Go to Marking
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
