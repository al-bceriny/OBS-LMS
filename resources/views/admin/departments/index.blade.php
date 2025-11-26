<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Departments
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
                <h3 class="text-lg font-semibold">Departments List</h3>
                <a href="{{ route('admin.departments.create') }}"
                    class="px-4 py-2 bg-blue-600  hover:bg-blue-700">
                    + New Department
                </a>
            </div>

            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($departments as $department)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $department->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $department->code }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $department->name }}</td>
                                <td class="px-4 py-2 text-sm text-right space-x-2">
                                    <a href="{{ route('admin.departments.edit', $department) }}"
                                        class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('admin.departments.destroy', $department) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No departments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
