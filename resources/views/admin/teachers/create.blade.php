<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            New Teacher
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

                <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               class="mt-1 w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email') }}"
                               class="mt-1 w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" name="password"
                               class="mt-1 w-full border rounded p-2">
                        <p class="text-xs text-gray-500 mt-1">
                            Minimum 6 characters.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Department</label>
                        <select name="department_id" class="mt-1 w-full border rounded p-2">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $dep)
                                <option value="{{ $dep->id }}"
                                    @selected(old('department_id') == $dep->id)>
                                    {{ $dep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Title (optional)</label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               class="mt-1 w-full border rounded p-2"
                               placeholder="Dr., Prof., Öğr.Gör., ...">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.teachers.index') }}"
                           class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 border rounded bg-blue-600">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
