<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Upload Material — {{ $offering->course->code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('teacher.materials.store', $offering) }}"
                  enctype="multipart/form-data"
                  class="space-y-4">

                @csrf

                <div>
                    <label class="block font-medium">Title</label>
                    <input type="text" name="title"
                           class="w-full border rounded p-2"
                           value="{{ old('title') }}">
                </div>

                <div>
                    <label class="block font-medium">Description (optional)</label>
                    <textarea name="description"
                              class="w-full border rounded p-2"
                              rows="3">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block font-medium">File</label>
                    <input type="file" name="file"
                           class="border rounded p-2 w-full">
                </div>

                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-blue-600 rounded">
                        Upload
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
