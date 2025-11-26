<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            New Course Offering
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc text-sm list-inside">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.course-offerings.store') }}"
                      class="space-y-4">

                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Course</label>
                        <select name="course_id" class="mt-1 w-full border rounded p-2">
                            @foreach ($courses as $c)
                                <option value="{{ $c->id }}">{{ $c->code }} — {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Teacher</label>
                        <select name="teacher_id" class="mt-1 w-full border rounded p-2">
                            @foreach ($teachers as $t)
                                <option value="{{ $t->id }}">{{ $t->user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Academic Year</label>
                        <input type="text" name="academic_year"
                               class="mt-1 w-full border rounded p-2"
                               value="2024/2025">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Term</label>
                        <select name="term" class="mt-1 w-full border rounded p-2">
                            <option value="fall">Fall</option>
                            <option value="spring">Spring</option>
                            <option value="summer">Summer</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Section</label>
                        <input type="text" name="section"
                               class="mt-1 w-full border rounded p-2"
                               value="1">
                    </div>

                    <div class="flex justify-end">
                        <button class="px-4 py-2 bg-blue-600 rounded">
                            Save
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
