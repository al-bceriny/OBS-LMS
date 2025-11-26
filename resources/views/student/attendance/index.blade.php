<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Attendance — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto space-y-8">

            {{-- Summary --}}
            <div class="bg-white shadow p-6 rounded">
                <h3 class="text-lg font-semibold mb-4">📊 Attendance Summary</h3>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                    <div>
                        <p class="font-bold text-xl">{{ $summary['total'] }}</p>
                        <p class="text-gray-600 text-sm">Total Sessions</p>
                    </div>

                    <div>
                        <p class="font-bold text-xl text-green-700">{{ $summary['present'] }}</p>
                        <p class="text-gray-600 text-sm">Present</p>
                    </div>

                    <div>
                        <p class="font-bold text-xl text-red-700">{{ $summary['absent'] }}</p>
                        <p class="text-gray-600 text-sm">Absent</p>
                    </div>

                    <div>
                        <p class="font-bold text-xl text-yellow-600">{{ $summary['late'] }}</p>
                        <p class="text-gray-600 text-sm">Late</p>
                    </div>

                    <div>
                        <p class="font-bold text-xl text-blue-700">{{ $summary['excused'] }}</p>
                        <p class="text-gray-600 text-sm">Excused</p>
                    </div>
                </div>

                <p class="mt-4 text-center font-semibold text-lg">
                    Attendance Rate:
                    <span class="text-indigo-600">{{ $summary['percentage'] }}%</span>
                </p>
            </div>

            {{-- جلسات الحضور --}}
            <div class="bg-white shadow p-6 rounded">
                <h3 class="text-lg font-semibold mb-4">🕒 Attendance Sessions</h3>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Topic</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($sessions as $s)
                            @php
                                $rec = $records[$s->id] ?? null;
                                $status = $rec->status ?? 'not_marked';
                            @endphp

                            <tr>
                                <td class="px-4 py-2">{{ $s->date }}</td>
                                <td class="px-4 py-2">{{ $s->topic ?? '-' }}</td>
                                <td class="px-4 py-2 font-semibold">

                                    @if($status === 'present')
                                        <span class="text-green-700">Present</span>
                                    @elseif($status === 'absent')
                                        <span class="text-red-700">Absent</span>
                                    @elseif($status === 'late')
                                        <span class="text-yellow-600">Late</span>
                                    @elseif($status === 'excused')
                                        <span class="text-blue-600">Excused</span>
                                    @else
                                        <span class="text-gray-500">Not Marked Yet</span>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>
