<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Course
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Code</label>
                        <input type="text" name="code" class="mt-1 w-full border rounded p-2"
                               value="{{ old('code') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" class="mt-1 w-full border rounded p-2"
                               value="{{ old('name') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Credit</label>
                        <input type="number" name="credit" min="1" max="15"
                               class="mt-1 w-full border rounded p-2" value="3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Department</label>
                        <select name="department_id" class="mt-1 w-full border rounded p-2">
                            @foreach ($departments as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Semester (Optional)</label>
                        <input type="number" name="semester" min="1" max="8"
                               class="mt-1 w-full border rounded p-2"
                               value="{{ old('semester') }}">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 border rounded bg-blue-600">
                            Create
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
