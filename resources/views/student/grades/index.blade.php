<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold">
            Transcript & Grades
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white shadow rounded p-6">

            <h3 class="text-lg font-semibold mb-4">
                👨‍🎓 {{ $student->user->name }} — {{ $student->student_number }}
            </h3>

            @if(empty($records))
                <p class="text-gray-500">No courses found.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Course</th>
                            <th class="px-4 py-2 text-left">Teacher</th>
                            <th class="px-4 py-2 text-left">Term</th>
                            <th class="px-4 py-2 text-center">Assignments Avg</th>
                            <th class="px-4 py-2 text-center">Exams Avg</th>
                            <th class="px-4 py-2 text-center">Final Grade</th>
                            <th class="px-4 py-2 text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($records as $rec)
                            @php
                                $off   = $rec['offering'];
                                $aAvg  = $rec['assignmentAvg'];
                                $eAvg  = $rec['examAvg'];
                                $final = $rec['final'];
                            @endphp

                            <tr>
                                <td class="px-4 py-2">
                                    {{ $off->course->code }} — {{ $off->course->name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $off->teacher->user->name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $off->academic_year }} / {{ ucfirst($off->term) }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $aAvg !== null ? $aAvg : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    {{ $eAvg !== null ? $eAvg : '-' }}
                                </td>
                                <td class="px-4 py-2 text-center font-semibold">
                                    {{ $final !== null ? $final : '-' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('student.courses.grades.show', $off) }}"
                                       class="text-blue-600 underline text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
