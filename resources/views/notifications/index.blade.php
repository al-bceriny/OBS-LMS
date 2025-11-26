<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Notifications</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto bg-white shadow p-6 rounded">

            @if($notifications->isEmpty())
                <p class="text-gray-500">No notifications.</p>
            @else

                <ul class="divide-y divide-gray-200">
                    @foreach ($notifications as $n)
                        <li class="py-3">

                            <div class="flex justify-between items-center">

                                <div>
                                    <h3 class="font-semibold">{{ $n->title }}</h3>
                                    <p class="text-sm text-gray-700">{{ $n->message }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $n->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div>
                                    <a href="{{ route('notifications.read', $n) }}"
                                       class="px-3 py-1 bg-blue-600 text-white text-xs rounded">
                                        {{ $n->is_read ? 'View' : 'Mark as Read' }}
                                    </a>
                                </div>

                            </div>

                        </li>
                    @endforeach
                </ul>

            @endif

        </div>
    </div>
</x-app-layout>
