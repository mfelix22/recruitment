<x-layouts.applicant>
    <x-slot name="heading">Pendidikan</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-700">Daftar Riwayat Pendidikan</h2>
                <a href="{{ route('applicant.education.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Pendidikan
                </a>
            </div>

            @if ($educations->isEmpty())
                <div class="bg-white rounded-xl shadow p-10 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <p class="text-sm">Belum ada data pendidikan.</p>
                    <a href="{{ route('applicant.education.create') }}"
                        class="mt-3 inline-block text-blue-600 text-sm hover:underline">
                        Tambah sekarang
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($educations as $education)
                        <div class="bg-white rounded-xl shadow p-5 flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $education->institution }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $education->level }}{{ $education->major ? ' — ' . $education->major : '' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $education->year_start }}
                                        – {{ $education->still_studying ? 'Sekarang' : $education->year_end ?? '-' }}
                                        @if ($education->gpa)
                                            &nbsp;· IPK {{ number_format($education->gpa, 2) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('applicant.education.edit', $education) }}"
                                    class="text-xs text-blue-600 hover:underline font-medium">Ubah</a>
                                <form method="POST" action="{{ route('applicant.education.destroy', $education) }}"
                                    onsubmit="return confirm('Hapus data pendidikan ini?')">
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
