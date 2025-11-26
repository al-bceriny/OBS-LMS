<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Mark Attendance — {{ $offering->course->code }} ({{ $session->date }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white shadow rounded p-6">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('teacher.attendance.update', [$offering, $session]) }}">
                @csrf

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Student</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Note</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($students as $st)
                            @php
                                $record = $records[$st->id] ?? null;
                            @endphp

                            <tr>
                                <td class="px-4 py-2">
                                    {{ $st->user->name }}
                                    <div class="text-xs text-gray-500">
                                        {{ $st->student_number }}
                                    </div>
                                </td>
                                <td class="px-4 py-2">
                                    <select name="status[{{ $st->id }}]"
                                            class="border rounded p-1">
                                        @php
                                            $current = $record->status ?? 'present';
                                        @endphp
                                        <option value="present" {{ $current == 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="absent"  {{ $current == 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="late"    {{ $current == 'late' ? 'selected' : '' }}>Late</option>
                                        <option value="excused" {{ $current == 'excused' ? 'selected' : '' }}>Excused</option>
                                    </select>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text"
                                           name="note[{{ $st->id }}]"
                                           value="{{ $record->note ?? '' }}"
                                           class="border rounded p-1 w-full text-sm">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4 flex justify-end">
                    <button class="px-4 py-2 bg-blue-600 border rounded">
                        Save Attendance
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
