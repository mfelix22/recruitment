<x-layouts.applicant>
    <x-slot name="heading">Pengalaman Kerja</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-700">Daftar Riwayat Pengalaman Kerja</h2>
                <a href="{{ route('applicant.work.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pengalaman
                </a>
            </div>

            @if ($works->isEmpty())
                <div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm">Belum ada data pengalaman kerja.</p>
                    <a href="{{ route('applicant.work.create') }}"
                        class="mt-3 inline-block text-blue-600 text-sm hover:underline">
                        Tambah sekarang
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($works as $work)
                        <div class="bg-white rounded-xl shadow p-5 flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $work->company }}</p>
                                    <p class="text-sm text-gray-500">{{ $work->position }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $work->period }}</p>
                                    @if ($work->still_working)
                                        <span
                                            class="inline-block mt-1 px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">Masih
                                            bekerja</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('applicant.work.edit', $work) }}"
                                    class="text-xs text-blue-600 hover:underline font-medium">Ubah</a>
                                <form method="POST" action="{{ route('applicant.work.destroy', $work) }}"
                                    onsubmit="return confirm('Hapus data pengalaman kerja ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-red-500 hover:underline font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-layouts.applicant>
