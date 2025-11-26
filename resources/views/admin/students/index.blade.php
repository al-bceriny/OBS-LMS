<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Students
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Students List</h3>
                <a href="{{ route('admin.students.create') }}"
                   class="px-4 py-2 bg-blue-600 rounded">
                    + New Student
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Student No</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Department</th>
                            <th class="px-4 py-2">Semester</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse ($students as $student)
                            <tr>
                                <td class="px-4 py-2">{{ $student->student_number }}</td>
                                <td class="px-4 py-2">{{ $student->user->name }}</td>
                                <td class="px-4 py-2">{{ $student->user->email }}</td>
                                <td class="px-4 py-2">{{ $student->department->name }}</td>
                                <td class="px-4 py-2">{{ $student->semester }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                        class="text-blue-600 hover:underline">Edit</a>

                                    <form method="POST"
                                            action="{{ route('admin.students.destroy', $student) }}"
                                            class="inline"
                                            onsubmit="return confirm('Delete this student?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 ml-2 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    No students found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $students->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
