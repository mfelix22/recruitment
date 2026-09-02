<x-layouts.applicant>
    <x-slot name="heading">Lowongan Kerja</x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search / filter --}}
            <form method="GET" action="{{ route('applicant.jobs.index') }}"
                class="bg-white rounded-xl shadow-sm p-4 flex flex-col sm:flex-row gap-3">
                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Cari posisi, departemen, atau lokasi..."
                    class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">

                <select name="jenis"
                    class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Jenis</option>
                    @foreach (['Full Time', 'Part Time', 'Kontrak', 'Magang', 'Freelance'] as $type)
                        <option value="{{ $type }}" {{ request('jenis') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Cari
                </button>
                @if (request()->hasAny(['cari', 'jenis']))
                    <a href="{{ route('applicant.jobs.index') }}"
                        class="text-sm text-gray-400 hover:text-gray-600 self-center">
                        Reset
                    </a>
                @endif
            </form>

            {{-- Result count --}}
            <p class="text-sm text-gray-500 px-1">
                Menampilkan {{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }}
                dari {{ $jobs->total() }} lowongan
            </p>

            {{-- Job cards --}}
            @forelse($jobs as $job)
                <a href="{{ route('applicant.jobs.show', $job) }}"
                    class="block bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition border border-transparent hover:border-blue-200">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-blue-500 font-medium uppercase tracking-wide mb-1">
                                {{ $job->department ?? 'Umum' }}
                            </p>
                            <h3 class="font-semibold text-gray-800 text-base truncate">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $job->position }}</p>

                            <div class="flex flex-wrap gap-2 mt-3">
                                {{-- Location --}}
                                @if ($job->location)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif

                                {{-- Type badge --}}
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    {{ $job->employment_type }}
                                </span>

                                {{-- Experience --}}
                                @if ($job->experience_level)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                        {{ $job->experience_level }}
                                        @if ($job->experience_years)
                                            ({{ $job->experience_years }} thn)
                                        @endif
                                    </span>
                                @endif

                                {{-- Education --}}
                                @if ($job->min_education)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                        Min. {{ $job->min_education }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            @if ($job->deadline)
                                <p class="text-xs text-gray-400">Batas</p>
                                <p
                                    class="text-xs font-medium
                                    {{ $job->deadline->diffInDays(now()) <= 3 ? 'text-red-500' : 'text-gray-600' }}">
                                    {{ $job->deadline->translatedFormat('d M Y') }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">{{ $job->open_positions }} posisi</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-400">
                    <p class="text-4xl mb-3">🔍</p>
                    <p class="font-medium">Belum ada lowongan tersedia</p>
                    <p class="text-sm mt-1">Coba kata kunci lain atau hapus filter</p>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if ($jobs->hasPages())
                <div class="px-1">{{ $jobs->links() }}</div>
            @endif

        </div>
    </div>
</x-layouts.applicant>
