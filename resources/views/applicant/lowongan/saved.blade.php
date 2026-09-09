<x-layouts.applicant>
    <x-slot name="heading">Lowongan Tersimpan</x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <p class="text-sm text-gray-500 px-1">
                {{ $savedJobs->total() }} lowongan tersimpan
            </p>

            @forelse($savedJobs as $job)
                <div
                    class="bg-white rounded-xl shadow-sm p-5 border border-transparent hover:border-blue-200 transition">
                    <div class="flex items-start justify-between gap-4">
                        <a href="{{ route('applicant.jobs.show', $job) }}" class="flex-1 min-w-0">
                            <p class="text-xs text-blue-500 font-medium uppercase tracking-wide mb-1">
                                {{ $job->department ?? 'Umum' }}
                            </p>
                            <h3 class="font-semibold text-gray-800 text-base truncate">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $job->position }}</p>

                            <div class="flex flex-wrap gap-2 mt-3">
                                @if ($job->location)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    {{ $job->employment_type }}
                                </span>
                                @if ($job->min_education)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                        Min. {{ $job->min_education }}
                                    </span>
                                @endif
                            </div>
                        </a>

                        <div class="text-right shrink-0 space-y-2">
                            @if ($appliedIds->contains($job->id))
                                <span class="block text-xs text-green-600 font-medium">✓ Sudah melamar</span>
                            @endif
                            @if ($job->deadline)
                                <p class="text-xs text-gray-400">
                                    Batas {{ $job->deadline->translatedFormat('d M Y') }}
                                </p>
                            @endif
                            <form method="POST" action="{{ route('applicant.jobs.save', $job) }}">
                                @csrf
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <p class="font-medium">Belum ada lowongan tersimpan</p>
                    <p class="text-sm mt-1">
                        Simpan lowongan yang menarik dari halaman
                        <a href="{{ route('applicant.jobs.index') }}" class="text-blue-600 hover:underline">Lowongan
                            Kerja</a>
                    </p>
                </div>
            @endforelse

            @if ($savedJobs->hasPages())
                <div class="px-1">{{ $savedJobs->links() }}</div>
            @endif

        </div>
    </div>
</x-layouts.applicant>
