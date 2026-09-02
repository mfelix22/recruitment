<x-layouts.hrd>
    <x-slot name="heading">Kelola Lowongan Kerja</x-slot>

    <div class="mt-4 space-y-4">

        {{-- Header bar --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">
                {{ $jobs->total() }} lowongan ditemukan
            </p>
            <a href="{{ route('employer.lowongan.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Lowongan
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wide">
                    <tr>
                        <th class="px-6 py-3 text-left">Jabatan / Posisi</th>
                        <th class="px-6 py-3 text-left">Departemen</th>
                        <th class="px-6 py-3 text-left">Jenis</th>
                        <th class="px-6 py-3 text-center">Lamaran</th>
                        <th class="px-6 py-3 text-left">Batas Waktu</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $job->title }}</p>
                                @if ($job->position)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $job->position }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $job->department ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full">
                                    {{ $job->employment_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('employer.applications.index', ['lowongan' => $job->id]) }}"
                                    class="text-blue-600 font-semibold hover:underline">
                                    {{ $job->applications_count }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                @if ($job->deadline)
                                    <span class="{{ $job->deadline->isPast() ? 'text-red-500' : 'text-gray-600' }}">
                                        {{ $job->deadline->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">Tidak ada batas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($job->is_active && (!$job->deadline || !$job->deadline->isPast()))
                                    <span
                                        class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full">Aktif</span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">Tidak
                                        Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('employer.lowongan.edit', $job) }}"
                                        class="text-yellow-600 hover:text-yellow-800 text-xs font-medium">Ubah</a>
                                    <form method="POST" action="{{ route('employer.lowongan.destroy', $job) }}"
                                        onsubmit="return confirm('Hapus lowongan ini? Semua lamaran akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 text-xs font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                Belum ada lowongan. Buat lowongan pertama Anda!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($jobs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layouts.hrd>
