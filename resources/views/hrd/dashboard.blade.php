<x-layouts.hrd>
    <x-slot name="heading">Beranda HRD</x-slot>

    <div class="mt-4 space-y-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Lowongan</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalLowongan }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Lowongan Aktif</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $lowonganAktif }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Total Lamaran</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalLamaran }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Menunggu Ditinjau</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $lamaranBaru }}</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="flex gap-3">
            <a href="{{ route('employer.lowongan.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Lowongan Baru
            </a>
            <a href="{{ route('employer.applications.index') }}"
                class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg border border-gray-200 transition">
                Lihat Semua Lamaran
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

            {{-- Pipeline breakdown --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Distribusi Status Lamaran</h3>
                @php $maxStatus = max(1, $statusBreakdown->max('total')); @endphp
                <div class="space-y-2.5">
                    @foreach ($statusBreakdown as $row)
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">{{ $row['status'] }}</span>
                                <span class="font-semibold text-gray-800">{{ $row['total'] }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $row['status'] === 'Diterima' ? 'bg-green-500' : ($row['status'] === 'Tidak Diterima' ? 'bg-red-400' : 'bg-blue-500') }}"
                                    style="width: {{ round($row['total'] / $maxStatus * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Applications per posting --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Lamaran per Lowongan</h3>
                </div>
                @if ($perLowongan->isEmpty())
                    <p class="px-6 py-10 text-center text-gray-400 text-sm">Belum ada lowongan.</p>
                @else
                    <div class="divide-y divide-gray-50">
                        @foreach ($perLowongan as $job)
                            <div class="px-6 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $job->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $job->is_active ? 'Aktif' : 'Nonaktif' }}
                                        @if ($job->deadline)
                                            · Batas {{ $job->deadline->translatedFormat('d M Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-bold text-gray-800">{{ $job->applications_count }}</p>
                                    @if ($job->pending_count > 0)
                                        <p class="text-xs text-yellow-600">{{ $job->pending_count }} menunggu</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Applications --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Lamaran Terbaru</h3>
                <a href="{{ route('employer.applications.index') }}" class="text-sm text-blue-600 hover:underline">Lihat
                    semua</a>
            </div>

            @if ($lamaranTerbaru->isEmpty())
                <div class="px-6 py-10 text-center text-gray-400 text-sm">
                    Belum ada lamaran masuk.
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach ($lamaranTerbaru as $lam)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $lam->applicant->name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $lam->jobPosting->title }}
                                    &middot; {{ $lam->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                @php
                                    $color = match ($lam->status) {
                                        'Diterima' => 'green',
                                        'Tidak Diterima' => 'red',
                                        'Sedang Ditinjau' => 'yellow',
                                        default => 'gray',
                                    };
                                @endphp
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium
                                    bg-{{ $color }}-100 text-{{ $color }}-700">
                                    {{ $lam->status }}
                                </span>
                                <a href="{{ route('employer.applications.show', $lam) }}"
                                    class="text-xs text-blue-600 hover:underline">Detail</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-layouts.hrd>
