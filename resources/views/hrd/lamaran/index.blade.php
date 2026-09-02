<x-layouts.hrd>
    <x-slot name="heading">Data Pelamar</x-slot>

    <div class="mt-4 space-y-4">

        {{-- Filters --}}
        <form method="GET" class="bg-white rounded-xl shadow-sm p-4 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Filter Lowongan</label>
                <select name="lowongan"
                    class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Lowongan</option>
                    @foreach ($myJobs as $id => $title)
                        <option value="{{ $id }}" {{ request('lowongan') == $id ? 'selected' : '' }}>
                            {{ $title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status"
                    class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                            {{ $s }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg transition">
                Terapkan
            </button>
            @if (request()->hasAny(['lowongan', 'status']))
                <a href="{{ route('employer.applications.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 py-2">Reset</a>
            @endif
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama Pelamar</th>
                        <th class="px-6 py-3 text-left">Posisi Dilamar</th>
                        <th class="px-6 py-3 text-left">Tanggal Melamar</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $app->applicant->name }}</p>
                                <p class="text-xs text-gray-400">{{ $app->applicant->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $app->jobPosting->title }}
                                @if ($app->jobPosting->department)
                                    <span class="text-gray-400 text-xs"> &mdash;
                                        {{ $app->jobPosting->department }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $app->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = match ($app->status) {
                                        'Diterima' => 'green',
                                        'Tidak Diterima' => 'red',
                                        'Sedang Ditinjau' => 'yellow',
                                        default => 'gray',
                                    };
                                @endphp
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium
                                    bg-{{ $color }}-100 text-{{ $color }}-700">
                                    {{ $app->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('employer.applications.show', $app) }}"
                                    class="text-blue-600 hover:underline text-xs font-medium">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                Belum ada lamaran masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($applications->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layouts.hrd>
