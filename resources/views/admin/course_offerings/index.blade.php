<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Course Offerings
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Offerings List</h3>
                <a href="{{ route('admin.course-offerings.create') }}"
                   class="px-4 py-2 bg-blue-600 rounded">
                    + New Offering
                </a>
            </div>

            <div class="bg-white shadow rounded overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Course</th>
                            <th class="px-4 py-2">Teacher</th>
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
                                <td class="px-4 py-2">{{ $off->teacher->user->name }}</td>
                                <td class="px-4 py-2">{{ $off->academic_year }}</td>
                                <td class="px-4 py-2">{{ ucfirst($off->term) }}</td>
                                <td class="px-4 py-2">{{ $off->section }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.course-offerings.edit', $off) }}"
                                       class="text-blue-600">Edit</a>

                                    <form action="{{ route('admin.course-offerings.destroy', $off) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Delete?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 ml-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $offerings->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
