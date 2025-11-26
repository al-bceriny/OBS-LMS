<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Assignments — {{ $offering->course->code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white p-6 shadow rounded">

            <a href="{{ route('teacher.assignments.create', $offering) }}"
               class="px-4 py-2 bg-blue-600 rounded">
                + New Assignment
            </a>

            <div class="mt-6">
                @if(session('success'))
                    <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if($assignments->isEmpty())
                    <p class="text-gray-500">No assignments yet.</p>
                @else
                    <ul class="divide-y divide-gray-300">
                        @foreach ($assignments as $a)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="font-semibold">{{ $a->title }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $a->description }}</p>
                                    @if($a->deadline)
                                        <p class="text-sm text-red-600">
                                            Deadline: {{ $a->deadline }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex space-x-4 items-center">
                                    <a href="{{ route('teacher.submissions.index', [$offering, $a]) }}"
                                    class="text-blue-600 underline">
                                        View Submissions
                                    </a>
                                <div class="flex space-x-4">
                                    @if($a->file_path)
                                        <a href="{{ asset('storage/'.$a->file_path) }}"
                                           class="text-blue-600 underline"
                                           download>
                                            Download File
                                        </a>
                                    @endif

                                    <form method="POST"
                                          action="{{ route('teacher.assignments.destroy', [$offering, $a]) }}"
                                          onsubmit="return confirm('Delete assignment?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
