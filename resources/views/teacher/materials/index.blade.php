<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ $offering->course->code }} — Materials
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

            <a href="{{ route('teacher.materials.create', $offering) }}"
                class="px-4 py-2 bg-blue-600 rounded">
                + Upload Material
            </a>

            <div class="mt-6">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($materials->isEmpty())
                    <p class="text-gray-500 mt-4">No materials uploaded yet.</p>
                @else
                    <ul class="divide-y divide-gray-300">
                        @foreach ($materials as $m)
                            <li class="py-4 flex justify-between items-center">

                                <div>
                                    <h3 class="font-semibold">{{ $m->title }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $m->description }}</p>
                                </div>

                                <div class="flex space-x-4 items-center">
                                    <a href="{{ asset('storage/' . $m->file_path) }}"
                                        class="text-blue-600 underline"
                                        download>
                                        Download
                                    </a>

                                    <form method="POST"
                                            action="{{ route('teacher.materials.destroy', [$offering, $m]) }}"
                                            onsubmit="return confirm('Delete this material?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
