<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">My Courses</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto bg-white shadow rounded p-6">

            @if ($offerings->isEmpty())
                <p class="text-gray-600">You are not assigned to any course offerings.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Course</th>
                            <th class="px-4 py-2">Year</th>
                            <th class="px-4 py-2">Term</th>
                            <th class="px-4 py-2">Section</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($offerings as $off)
                            <tr>
                                <td class="px-4 py-2">{{ $off->course->code }}</td>
                                <td class="px-4 py-2">{{ $off->academic_year }}</td>
                                <td class="px-4 py-2">{{ ucfirst($off->term) }}</td>
                                <td class="px-4 py-2">{{ $off->section }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('teacher.courses.show', $off) }}"
                                       class="text-blue-600 underline">
                                        Manage
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
