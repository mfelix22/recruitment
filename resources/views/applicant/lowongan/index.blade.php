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
                class="bg-white rounded-xl shadow-sm p-4 space-y-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari posisi, departemen, atau lokasi..."
                        class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">

                    <button type="submit"
                        class="bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        Cari
                    </button>
                    @if (request()->hasAny(['cari', 'jenis', 'departemen', 'lokasi', 'pendidikan', 'pengalaman']))
                        <a href="{{ route('applicant.jobs.index') }}"
                            class="text-sm text-gray-400 hover:text-gray-600 self-center">
                            Reset
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    <select name="jenis"
                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Jenis</option>
                        @foreach ($employmentTypes as $type)
                            <option value="{{ $type }}" {{ request('jenis') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>

                    <select name="departemen"
                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Departemen</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept }}" {{ request('departemen') === $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>

                    <select name="lokasi"
                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Lokasi</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc }}" {{ request('lokasi') === $loc ? 'selected' : '' }}>
                                {{ $loc }}
                            </option>
                        @endforeach
                    </select>

                    <select name="pendidikan"
                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Min. Pendidikan</option>
                        @foreach ($educationLevels as $edu)
                            <option value="{{ $edu }}" {{ request('pendidikan') === $edu ? 'selected' : '' }}>
                                {{ $edu }}
                            </option>
                        @endforeach
                    </select>

                    <select name="pengalaman"
                        class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Level</option>
                        @foreach ($experienceLevels as $level)
                            <option value="{{ $level }}" {{ request('pengalaman') === $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- Result count --}}
            <p class="text-sm text-gray-500 px-1">
                Menampilkan {{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }}
                dari {{ $jobs->total() }} lowongan
            </p>

            {{-- Job cards --}}
            @forelse($jobs as $job)
                @php
                    $isSaved = auth()->check() && $savedIds->contains($job->id);
                    $alreadyApplied = auth()->check() && $appliedIds->contains($job->id);
                @endphp
                <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition border border-transparent hover:border-blue-200">
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
                                <span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    {{ $job->employment_type }}
                                </span>
                                @if ($job->experience_level)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                        {{ $job->experience_level }}
                                        @if ($job->experience_years)
                                            ({{ $job->experience_years }} thn)
                                        @endif
                                    </span>
                                @endif
                                @if ($job->min_education)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                        Min. {{ $job->min_education }}
                                    </span>
                                @endif
                            </div>
                        </a>

                        <div class="text-right shrink-0 flex flex-col items-end gap-2">
                            @if ($job->deadline)
                                <div>
                                    <p class="text-xs text-gray-400">Batas</p>
                                    <p
                                        class="text-xs font-medium
                                        {{ $job->deadline->diffInDays(now()) <= 3 ? 'text-red-500' : 'text-gray-600' }}">
                                        {{ $job->deadline->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            @endif
                            <p class="text-xs text-gray-400">{{ $job->open_positions }} posisi</p>
                            @if ($alreadyApplied)
                                <span class="text-xs text-green-600 font-medium">✓ Melamar</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('applicant.jobs.show', $job) }}"
                            class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                            Lihat Detail →
                        </a>
                        <span class="text-gray-300">|</span>
                        <form method="POST" action="{{ route('applicant.jobs.save', $job) }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 text-sm font-medium transition
                                {{ $isSaved ? 'text-blue-600' : 'text-gray-500 hover:text-blue-600' }}">
                                <svg class="w-4 h-4" fill="{{ $isSaved ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                {{ $isSaved ? 'Tersimpan' : 'Simpan' }}
                            </button>
                        </form>
                    </div>
                </div>
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
