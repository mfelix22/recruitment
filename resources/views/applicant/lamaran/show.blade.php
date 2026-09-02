<x-layouts.applicant>
    <x-slot name="heading">{{ $application->jobPosting->title }}</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Status badge --}}
            @php
                $color = $application->status_color;
                $colorMap = [
                    'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'ring' => 'ring-green-200'],
                    'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'ring' => 'ring-red-200'],
                    'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'ring' => 'ring-blue-200'],
                    'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'ring' => 'ring-purple-200'],
                    'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-200'],
                    'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'ring' => 'ring-orange-200'],
                    'teal' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'ring' => 'ring-teal-200'],
                    'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'ring' => 'ring-gray-200'],
                ];
                $badge = $colorMap[$color] ?? $colorMap['gray'];
                $steps = [
                    'Menunggu',
                    'Sedang Ditinjau',
                    'Dipanggil Interview',
                    'Proses Seleksi',
                    'Menunggu MCU',
                    'Onboarding',
                ];
                $currentStep = $application->status_step;
                $accepted = $application->status === 'Diterima';
                $rejected = $application->status === 'Tidak Diterima';
            @endphp

            {{-- Progress tracker --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Tahapan Seleksi</h3>
                    <span
                        class="inline-block {{ $badge['bg'] }} {{ $badge['text'] }} text-xs font-semibold px-3 py-1 rounded-full ring-1 {{ $badge['ring'] }}">
                        {{ $application->status }}
                    </span>
                </div>

                <div class="flex items-center">
                    @foreach ($steps as $i => $step)
                        @php $stepNum = $i + 1; @endphp
                        <div class="flex flex-col items-center">
                            <div
                                class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all
                                {{ $rejected
                                    ? 'bg-gray-100 text-gray-400'
                                    : ($stepNum < $currentStep
                                        ? 'bg-blue-600 text-white'
                                        : ($stepNum === $currentStep && !$accepted
                                            ? 'bg-blue-600 text-white ring-4 ring-blue-100'
                                            : ($accepted
                                                ? 'bg-green-100 text-green-400'
                                                : 'bg-gray-100 text-gray-400'))) }}">
                                @if (!$rejected && $stepNum < $currentStep)
                                    ✓
                                @else
                                    {{ $stepNum }}
                                @endif
                            </div>
                            <p
                                class="text-xs mt-1.5 text-center max-w-[72px] leading-tight
                                {{ !$rejected && $stepNum === $currentStep && !$accepted ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
                                {{ $step }}
                            </p>
                        </div>
                        @if (!$loop->last)
                            <div
                                class="flex-1 h-0.5 mb-5 mx-1
                                {{ !$rejected && $stepNum < $currentStep ? 'bg-blue-600' : 'bg-gray-200' }}">
                            </div>
                        @endif
                    @endforeach

                    {{-- Connector to result --}}
                    <div
                        class="flex-1 h-0.5 mb-5 mx-1
                        {{ $accepted ? 'bg-green-500' : ($rejected ? 'bg-red-400' : 'bg-gray-200') }}">
                    </div>

                    {{-- Result step --}}
                    <div class="flex flex-col items-center">
                        <div
                            class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $accepted
                                ? 'bg-green-500 text-white ring-4 ring-green-100'
                                : ($rejected
                                    ? 'bg-red-500 text-white ring-4 ring-red-100'
                                    : 'bg-gray-100 text-gray-400') }}">
                            @if ($accepted)
                                ✓
                            @elseif($rejected)
                                ✕
                            @else
                                7
                            @endif
                        </div>
                        <p
                            class="text-xs mt-1.5 text-center max-w-[72px] leading-tight
                            {{ $accepted ? 'text-green-600 font-semibold' : ($rejected ? 'text-red-500 font-semibold' : 'text-gray-400') }}">
                            {{ $accepted ? 'Diterima' : ($rejected ? 'Tidak Diterima' : 'Hasil') }}
                        </p>
                    </div>
                </div>

                @if ($accepted)
                    <div class="mt-4 bg-green-50 border border-green-100 text-green-700 rounded-lg px-4 py-3 text-sm">
                        🎉 Selamat! Lamaran Anda untuk posisi <strong>{{ $application->jobPosting->position }}</strong>
                        telah diterima.
                    </div>
                @elseif($rejected)
                    <div class="mt-4 bg-red-50 border border-red-100 text-red-600 rounded-lg px-4 py-3 text-sm">
                        Mohon maaf, lamaran Anda untuk posisi ini tidak dilanjutkan. Tetap semangat!
                    </div>
                @endif
            </div>

            {{-- Job info --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Detail Lowongan</h3>
                <div class="grid grid-cols-2 gap-y-2 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Posisi</p>
                        <p class="text-gray-700 font-medium">{{ $application->jobPosting->position }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Departemen</p>
                        <p class="text-gray-700">{{ $application->jobPosting->department ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Lokasi</p>
                        <p class="text-gray-700">{{ $application->jobPosting->location ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Jenis Pekerjaan</p>
                        <p class="text-gray-700">{{ $application->jobPosting->employment_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Tanggal Melamar</p>
                        <p class="text-gray-700">{{ $application->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    @if ($application->jobPosting->deadline)
                        <div>
                            <p class="text-xs text-gray-400">Batas Lowongan</p>
                            <p class="text-gray-700">
                                {{ $application->jobPosting->deadline->translatedFormat('d F Y') }}</p>
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    <a href="{{ route('applicant.jobs.show', $application->jobPosting) }}"
                        class="text-sm text-blue-600 hover:underline">
                        Lihat detail lowongan →
                    </a>
                </div>
            </div>

            {{-- Cover letter --}}
            @if ($application->cover_letter)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Surat Lamaran Anda</h3>
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">
                        {{ $application->cover_letter }}</p>
                </div>
            @endif

            {{-- Employer notes --}}
            @if ($application->employer_notes)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                    <h3 class="text-sm font-semibold text-blue-700 mb-2">Catatan dari HRD</h3>
                    <p class="text-sm text-blue-700 leading-relaxed whitespace-pre-wrap">
                        {{ $application->employer_notes }}</p>
                </div>
            @endif

            {{-- Onboarding Documents CTA --}}
            @if ($application->status === 'Onboarding')
                <div class="bg-teal-50 border border-teal-200 rounded-xl p-5">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-teal-800">📋 Dokumen Onboarding</h3>
                            <p class="text-sm text-teal-700 mt-1">Silakan lengkapi dokumen yang diperlukan untuk proses
                                onboarding Anda.</p>
                        </div>
                        <a href="{{ route('applicant.onboarding.index', $application) }}"
                            class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex-shrink-0">
                            Upload Dokumen →
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-layouts.applicant>
