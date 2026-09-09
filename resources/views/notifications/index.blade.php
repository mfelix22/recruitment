<x-dynamic-component :component="auth()->user()->isEmployer() ? 'layouts.hrd' : 'layouts.applicant'">
    <x-slot name="heading">Notifikasi</x-slot>

    <div class="py-6 px-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-semibold text-gray-700">Semua Notifikasi</h2>
                    @if (auth()->user()->unreadNotifications()->exists())
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button type="submit" class="text-xs text-blue-600 hover:underline">
                                Tandai semua dibaca
                            </button>
                        </form>
                    @endif
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse ($notifications as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-5 py-4 hover:bg-gray-50 transition flex gap-3
                                {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <span
                                    class="mt-1.5 w-2 h-2 rounded-full flex-shrink-0
                                    {{ $notification->read_at ? 'bg-transparent' : 'bg-blue-500' }}"></span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-sm text-gray-700">
                                        {{ $notification->data['message'] ?? 'Notifikasi baru' }}
                                    </span>
                                    <span class="block text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->translatedFormat('d M Y H:i') }}
                                        · {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </span>
                                <span class="text-xs text-blue-500 self-center flex-shrink-0">Lihat →</span>
                            </button>
                        </form>
                    @empty
                        <p class="px-5 py-10 text-sm text-gray-400 text-center">Belum ada notifikasi.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-dynamic-component>
