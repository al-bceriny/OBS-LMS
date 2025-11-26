<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Teacher Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">
            <h3 class="text-lg font-semibold">Welcome, {{ auth()->user()->name }}</h3>

            <div class="mt-4">
                <a href="{{ route('teacher.courses.index') }}"
                   class="text-blue-600 underline">
                    My Courses
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
