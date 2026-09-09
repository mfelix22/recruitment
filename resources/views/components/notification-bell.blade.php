@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $latest = auth()->user()->notifications()->latest()->take(7)->get();
@endphp

<div x-data="{ open: false }" @click.outside="open = false" class="relative">
    <button @click="open = !open" type="button"
        class="relative p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition"
        aria-label="Notifikasi">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if ($unreadCount > 0)
            <span
                class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] h-[1.1rem] px-1 bg-red-500 text-white text-[0.65rem] font-semibold rounded-full flex items-center justify-center">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" x-transition x-cloak
        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <p class="text-sm font-semibold text-gray-700">Notifikasi</p>
            @if ($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="text-xs text-blue-600 hover:underline">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
            @forelse ($latest as $notification)
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-3 hover:bg-gray-50 transition flex gap-3
                        {{ $notification->read_at ? 'opacity-60' : '' }}">
                        <span class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0
                            {{ $notification->read_at ? 'bg-transparent' : 'bg-blue-500' }}"></span>
                        <span class="min-w-0">
                            <span class="block text-sm text-gray-700 leading-snug">
                                {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                            </span>
                            <span class="block text-xs text-gray-400 mt-0.5">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </span>
                    </button>
                </form>
            @empty
                <p class="px-4 py-6 text-sm text-gray-400 text-center">Belum ada notifikasi.</p>
            @endforelse
        </div>

        <a href="{{ route('notifications.index') }}"
            class="block px-4 py-2.5 text-center text-xs font-medium text-blue-600 hover:bg-blue-50 border-t border-gray-100 transition">
            Lihat Semua Notifikasi
        </a>
    </div>
</div>
