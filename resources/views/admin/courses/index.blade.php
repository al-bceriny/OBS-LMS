<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Courses
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Courses List</h3>
                <a href="{{ route('admin.courses.create') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700">
                    + New Course
                </a>
            </div>

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Code</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Credit</th>
                            <th class="px-4 py-2">Department</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($courses as $course)
                            <tr>
                                <td class="px-4 py-2">{{ $course->code }}</td>
                                <td class="px-4 py-2">{{ $course->name }}</td>
                                <td class="px-4 py-2">{{ $course->credit }}</td>
                                <td class="px-4 py-2">
                                    {{ $course->department->name }}
                                </td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('admin.courses.edit', $course) }}"
                                       class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('admin.courses.destroy', $course) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-4 text-center">No courses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $courses->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
