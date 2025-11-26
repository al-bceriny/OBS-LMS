<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            New Department
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="mb-4 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700">Code</label>
                        <input type="text" name="code" value="{{ old('code') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4 flex flex-col">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.departments.index') }}"
                            class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 border rounded hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
