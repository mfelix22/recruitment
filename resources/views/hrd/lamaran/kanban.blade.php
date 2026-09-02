<x-layouts.hrd>
    <x-slot name="heading">Kanban Lamaran</x-slot>

    <div class="flex gap-1 mb-4 items-center justify-between">
        <p class="text-sm text-gray-500">Seret kartu antar kolom untuk mengubah status lamaran.</p>
        <a href="{{ route('employer.applications.index') }}" class="text-sm text-blue-600 hover:underline">← Lihat
            Tabel</a>
    </div>

    {{-- Kanban Board --}}
    <div class="flex gap-4 overflow-x-auto pb-6" style="min-height:calc(100vh - 160px)">
        @foreach ($columns as $status => $cards)
            <div class="flex-shrink-0 w-64">
                {{-- Column header --}}
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ $status }}</span>
                    <span class="bg-gray-200 text-gray-600 text-xs font-bold rounded-full px-2 py-0.5 kanban-count"
                        data-status="{{ $status }}">{{ $cards->count() }}</span>
                </div>

                {{-- Drop zone --}}
                <div class="kanban-col space-y-3 min-h-[60px] bg-gray-100 rounded-xl p-2"
                    data-status="{{ $status }}">
                    @foreach ($cards as $app)
                        <div class="kanban-card bg-white rounded-lg shadow-sm p-3 cursor-grab active:cursor-grabbing border border-transparent hover:border-blue-200 transition"
                            data-id="{{ $app->id }}" data-status="{{ $app->status }}">
                            <p class="font-medium text-sm text-gray-800 leading-snug">{{ $app->applicant->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $app->jobPosting->title }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $app->created_at->format('d M Y') }}</p>
                            <a href="{{ route('employer.applications.show', $app) }}"
                                class="mt-2 block text-xs text-blue-600 hover:underline">Lihat Detail →</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- Toast notification --}}
    <div id="kanban-toast"
        class="fixed bottom-5 right-5 bg-gray-800 text-white text-sm px-4 py-2 rounded-lg shadow-lg opacity-0 transition-opacity duration-300 pointer-events-none">
        Status diperbarui
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const toast = document.getElementById('kanban-toast');

        function showToast(msg, isError = false) {
            toast.textContent = msg;
            toast.style.background = isError ? '#dc2626' : '#1f2937';
            toast.style.opacity = '1';
            setTimeout(() => {
                toast.style.opacity = '0';
            }, 2500);
        }

        document.querySelectorAll('.kanban-col').forEach(col => {
            Sortable.create(col, {
                group: 'kanban',
                animation: 150,
                ghostClass: 'opacity-40',
                onEnd: function(evt) {
                    const cardEl = evt.item;
                    const newStatus = evt.to.dataset.status;
                    const oldStatus = evt.from.dataset.status;
                    const appId = cardEl.dataset.id;

                    if (newStatus === oldStatus) return;

                    // Optimistically update count badges
                    updateCount(oldStatus, -1);
                    updateCount(newStatus, +1);

                    fetch(`/hrd/lamaran/${appId}/status-ajax`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                status: newStatus
                            }),
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                cardEl.dataset.status = newStatus;
                                showToast('Status diperbarui: ' + newStatus);
                            } else {
                                showToast(data.message || 'Gagal memperbarui', true);
                                // Revert
                                evt.from.insertBefore(cardEl, evt.from.children[evt.oldIndex] ||
                                    null);
                                updateCount(oldStatus, +1);
                                updateCount(newStatus, -1);
                            }
                        })
                        .catch(() => {
                            showToast('Gagal terhubung ke server', true);
                            evt.from.insertBefore(cardEl, evt.from.children[evt.oldIndex] || null);
                            updateCount(oldStatus, +1);
                            updateCount(newStatus, -1);
                        });
                }
            });
        });

        function updateCount(status, delta) {
            const badge = document.querySelector(`.kanban-count[data-status="${status}"]`);
            if (badge) badge.textContent = Math.max(0, parseInt(badge.textContent) + delta);
        }
    </script>
</x-layouts.hrd>
