<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Attendance — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white shadow rounded p-6">

            <a href="{{ route('teacher.attendance.create', $offering) }}"
               class="px-4 py-2 bg-blue-600 border rounded">
                + New Session
            </a>

            @if(session('success'))
                <div class="mt-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mt-6">
                @if($sessions->isEmpty())
                    <p class="text-gray-500">No attendance sessions yet.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Date</th>
                                <th class="px-4 py-2 text-left">Topic</th>
                                <th class="px-4 py-2 text-left">Records</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sessions as $s)
                                <tr>
                                    <td class="px-4 py-2">{{ $s->date }}</td>
                                    <td class="px-4 py-2">{{ $s->topic ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $s->records_count }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('teacher.attendance.mark', [$offering, $s]) }}"
                                           class="text-blue-600 underline">
                                            Mark Attendance
                                        </a>
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
