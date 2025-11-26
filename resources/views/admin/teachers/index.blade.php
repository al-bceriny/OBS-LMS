<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Teachers</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold">Teachers List</h3>
                <a href="{{ route('admin.teachers.create') }}"
                    class="px-4 py-2 bg-blue-600 rounded">+ New Teacher</a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Department</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td class="px-4 py-2">{{ $teacher->user->name }}</td>
                                <td class="px-4 py-2">{{ $teacher->user->email }}</td>
                                <td class="px-4 py-2">{{ $teacher->department->name }}</td>
                                <td class="px-4 py-2">{{ $teacher->title }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                       class="text-blue-600">Edit</a>

                                    <form method="POST"
                                          action="{{ route('admin.teachers.destroy', $teacher) }}"
                                          class="inline"
                                          onsubmit="return confirm('Delete this teacher?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $teachers->links() }}
            </div>

        </div>
    </div>

</x-app-layout>
