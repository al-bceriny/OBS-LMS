<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Students — {{ $offering->course->code }} (Section {{ $offering->section }})
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            @if($offering->students->isEmpty())
                <p class="text-gray-500">No students enrolled in this course.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">Student No</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Semester</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($offering->students as $student)
                            <tr>
                                <td class="px-4 py-2">{{ $student->student_number }}</td>
                                <td class="px-4 py-2">{{ $student->user->name }}</td>
                                <td class="px-4 py-2">{{ $student->user->email }}</td>
                                <td class="px-4 py-2">{{ $student->semester }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>
</x-app-layout>
