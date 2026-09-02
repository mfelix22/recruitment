<x-layouts.applicant>
    <x-slot name="heading">{{ $jobPosting->title }}</x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- Main content --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Job header --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <p class="text-xs text-blue-500 font-medium uppercase tracking-wide mb-1">
                            {{ $jobPosting->department ?? 'Umum' }}
                        </p>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $jobPosting->title }}</h1>
                        <p class="text-gray-500 mt-0.5">{{ $jobPosting->position }}</p>

                        <div class="flex flex-wrap gap-2 mt-4">
                            @if ($jobPosting->employment_type)
                                <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    {{ $jobPosting->employment_type }}
                                </span>
                            @endif
                            @if ($jobPosting->experience_level)
                                <span class="bg-purple-50 text-purple-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    {{ $jobPosting->experience_level }}
                                    @if ($jobPosting->experience_years)
                                        • {{ $jobPosting->experience_years }} thn
                                    @endif
                                </span>
                            @endif
                            @if ($jobPosting->min_education)
                                <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                                    Min. {{ $jobPosting->min_education }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="font-semibold text-gray-700 mb-3">Deskripsi Pekerjaan</h2>
                        <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">
                            {{ $jobPosting->job_description }}</div>
                    </div>

                    {{-- Persyaratan --}}
                    @if ($jobPosting->requirements)
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <h2 class="font-semibold text-gray-700 mb-3">Persyaratan</h2>
                            <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">
                                {{ $jobPosting->requirements }}</div>
                        </div>
                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="space-y-5">

                    {{-- Info singkat --}}
                    <div class="bg-white rounded-xl shadow-sm p-5 space-y-3">
                        <h3 class="font-semibold text-gray-700 text-sm">Informasi Lowongan</h3>

                        @if ($jobPosting->location)
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Lokasi</p>
                                    <p class="text-gray-700">{{ $jobPosting->location }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-400">Jumlah Posisi</p>
                                <p class="text-gray-700">{{ $jobPosting->open_positions }} orang</p>
                            </div>
                        </div>

                        @if ($jobPosting->deadline)
                            <div class="flex items-start gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p class="text-xs text-gray-400">Batas Lamaran</p>
                                    <p
                                        class="{{ $jobPosting->deadline->isPast() ? 'text-red-500' : ($jobPosting->deadline->diffInDays(now()) <= 3 ? 'text-orange-500' : 'text-gray-700') }} font-medium">
                                        {{ $jobPosting->deadline->translatedFormat('d F Y') }}
                                        @if (!$jobPosting->deadline->isPast())
                                            <span class="text-xs font-normal text-gray-400">
                                                ({{ $jobPosting->deadline->diffForHumans() }})
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Apply box --}}
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        @if ($alreadyApplied)
                            <div class="text-center py-2">
                                <p class="text-green-600 font-semibold text-sm">✓ Sudah Melamar</p>
                                <p class="text-gray-400 text-xs mt-1">Anda telah mengirim lamaran untuk lowongan ini</p>
                                <a href="{{ route('applicant.applications.index') }}"
                                    class="mt-3 inline-block text-sm text-blue-600 hover:underline">
                                    Lihat Status Lamaran →
                                </a>
                            </div>
                        @else
                            <form action="{{ route('applicant.apply', $jobPosting) }}" method="POST">
                                @csrf
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Surat Lamaran <span class="text-gray-400">(opsional)</span>
                                </label>
                                <textarea name="cover_letter" rows="5" placeholder="Ceritakan mengapa Anda cocok untuk posisi ini..."
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 resize-none">{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                    class="w-full mt-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-2.5 rounded-lg transition">
                                    Kirim Lamaran
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layouts.applicant>
