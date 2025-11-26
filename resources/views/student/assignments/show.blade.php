<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Assignment — {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">

            <p class="text-gray-700">{{ $assignment->description }}</p>

            @if($assignment->file_path)
                <p class="mt-2">
                    <a href="{{ asset('storage/'.$assignment->file_path) }}"
                       class="text-blue-600 underline"
                       download>
                        Download Assignment File
                    </a>
                </p>
            @endif

            <hr class="my-4">

            <h3 class="text-lg font-semibold">Your Submission</h3>

            @if(session('success'))
                <div class="bg-green-100 p-3 rounded text-green-700 mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($submission)

                <p class="mt-3">
                    You submitted at:
                    <strong>{{ $submission->submitted_at }}</strong>
                </p>

                <p>
                    <a href="{{ asset('storage/'.$submission->file_path) }}"
                       class="text-blue-600 underline"
                       download>
                        Download Your File
                    </a>
                </p>

                @if($submission->grade)
                    <p class="mt-3">
                        Grade:
                        <strong>{{ $submission->grade }}</strong>
                    </p>
                @endif
                
                @if($submission->comments)
                    <p class="mt-2 text-sm text-gray-700">
                        Teacher comments: {{ $submission->comments }}
                    </p>
                @endif
            <hr>
            @else

                <form method="POST"
                      action="{{ route('student.assignments.submit', $assignment) }}"
                      enctype="multipart/form-data"
                      class="mt-4">

                    @csrf

                    <label class="block mb-2 font-medium">Upload File</label>
                    <input type="file" name="file" class="border rounded p-2 w-full">

                    <button class="mt-3 bg-blue-600 border px-4 py-2 rounded">
                        Submit Assignment
                    </button>
                </form>

            @endif

        </div>

    </div>
</x-app-layout>
