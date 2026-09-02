<x-layouts.hrd>
    <x-slot name="heading">Detail Lamaran</x-slot>

    <div class="mt-4 max-w-5xl space-y-5">

        {{-- Back + header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('employer.applications.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">{{ $application->applicant->name }}</h3>
                <p class="text-sm text-gray-500">Melamar: {{ $application->jobPosting->title }}</p>
            </div>
            {{-- PDF Download --}}
            <a href="{{ route('employer.applications.pdf', $application) }}" target="_blank"
                class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Download PDF
            </a>
        </div>

        {{-- Progress tracker --}}
        @php
            $steps = [
                'Menunggu',
                'Sedang Ditinjau',
                'Dipanggil Interview',
                'Proses Seleksi',
                'Menunggu MCU',
                'Onboarding',
            ];
            $currentStep = $application->status_step;
            $rejected = $application->status === 'Tidak Diterima';
            $accepted = $application->status === 'Diterima';
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-5">
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-4">Tahapan Seleksi</p>
            <div class="flex items-center">
                @foreach ($steps as $i => $step)
                    @php $stepNum = $i + 1; @endphp
                    <div class="flex flex-col items-center">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $rejected
                                ? 'bg-red-100 text-red-500'
                                : ($stepNum < $currentStep
                                    ? 'bg-blue-600 text-white'
                                    : ($stepNum === $currentStep && !$accepted
                                        ? 'bg-blue-600 text-white ring-2 ring-blue-200'
                                        : ($accepted
                                            ? 'bg-green-500 text-white'
                                            : 'bg-gray-100 text-gray-400'))) }}">
                            @if ($stepNum < $currentStep && !$rejected)
                                ✓
                            @else
                                {{ $stepNum }}
                            @endif
                        </div>
                        <p
                            class="text-xs mt-1 text-center max-w-[60px] leading-tight
                            {{ $stepNum === $currentStep && !$rejected && !$accepted ? 'text-blue-600 font-medium' : 'text-gray-400' }}">
                            {{ $step }}
                        </p>
                    </div>
                    @if (!$loop->last)
                        <div
                            class="flex-1 h-0.5 mb-5 mx-1
                            {{ $stepNum < $currentStep && !$rejected ? 'bg-blue-600' : 'bg-gray-200' }}">
                        </div>
                    @endif
                @endforeach

                {{-- Final connector --}}
                <div
                    class="flex-1 h-0.5 mb-5 mx-1 {{ $accepted ? 'bg-green-500' : ($rejected ? 'bg-red-400' : 'bg-gray-200') }}">
                </div>

                {{-- Final result circle --}}
                <div class="flex flex-col items-center">
                    <div
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $accepted
                            ? 'bg-green-500 text-white ring-2 ring-green-200'
                            : ($rejected
                                ? 'bg-red-500 text-white ring-2 ring-red-200'
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
                        class="text-xs mt-1 text-center max-w-[60px] leading-tight
                        {{ $accepted ? 'text-green-600 font-medium' : ($rejected ? 'text-red-500 font-medium' : 'text-gray-400') }}">
                        {{ $accepted ? 'Diterima' : ($rejected ? 'Tidak Diterima' : 'Hasil') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Left: Applicant info --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Personal Data --}}
                @php $profile = $application->applicant->applicantProfile; @endphp
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Data Pribadi</h4>
                    @if ($profile)
                        <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div>
                                <dt class="text-gray-400">NIK</dt>
                                <dd class="text-gray-800 font-medium">{{ $profile->nik ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Telepon</dt>
                                <dd class="text-gray-800 font-medium">{{ $profile->phone ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Tempat, Tgl Lahir</dt>
                                <dd class="text-gray-800 font-medium">
                                    {{ $profile->place_of_birth ?? '-' }},
                                    {{ $profile->date_of_birth?->format('d M Y') ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Jenis Kelamin</dt>
                                <dd class="text-gray-800 font-medium">{{ $profile->gender ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Agama</dt>
                                <dd class="text-gray-800 font-medium">{{ $profile->religion ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Status Perkawinan</dt>
                                <dd class="text-gray-800 font-medium">{{ $profile->marital_status ?? '-' }}</dd>
                            </div>
                        </dl>

                        @if ($profile->address)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <dt class="text-gray-400 text-sm">Alamat</dt>
                                <dd class="text-gray-800 text-sm mt-1">{{ $profile->address->full_address }}</dd>
                            </div>
                        @endif
                    @else
                        <p class="text-gray-400 text-sm">Profil belum dilengkapi.</p>
                    @endif
                </div>

                {{-- Education --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Riwayat Pendidikan</h4>
                    @if ($profile && $profile->educations->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($profile->educations as $edu)
                                <div class="flex gap-4 text-sm">
                                    <div class="flex-shrink-0 w-20 text-center">
                                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-xs font-medium">
                                            {{ $edu->level }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $edu->institution }}</p>
                                        <p class="text-gray-500 text-xs">
                                            {{ $edu->major ?? '' }}
                                            @if ($edu->gpa)
                                                &middot; IPK {{ $edu->gpa }}
                                            @endif
                                        </p>
                                        <p class="text-gray-400 text-xs">{{ $edu->year_range }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Tidak ada data pendidikan.</p>
                    @endif
                </div>

                {{-- Work Experience --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Pengalaman Kerja</h4>
                    @if ($profile && $profile->workExperiences->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($profile->workExperiences as $work)
                                <div class="text-sm border-l-2 border-blue-200 pl-4">
                                    <p class="font-medium text-gray-800">{{ $work->position }}</p>
                                    <p class="text-gray-600">{{ $work->company }}</p>
                                    <p class="text-gray-400 text-xs">{{ $work->period }}</p>
                                    @if ($work->job_description)
                                        <p class="text-gray-500 mt-1 text-xs">{{ $work->job_description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Tidak ada pengalaman kerja.</p>
                    @endif
                </div>

                {{-- Cover Letter --}}
                @if ($application->cover_letter)
                    <div class="bg-white rounded-xl shadow-sm p-5">
                        <h4 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">Surat Lamaran</h4>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $application->cover_letter }}</p>
                    </div>
                @endif

            </div>

            {{-- Right: Status panel --}}
            <div class="space-y-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Perbarui Status</h4>

                    @php
                        $color = match ($application->status) {
                            'Diterima' => 'green',
                            'Tidak Diterima' => 'red',
                            'Sedang Ditinjau' => 'yellow',
                            default => 'gray',
                        };
                    @endphp
                    <div class="mb-4 text-center">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium
                            bg-{{ $color }}-100 text-{{ $color }}-700">
                            {{ $application->status }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('employer.applications.status', $application) }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Status Baru</label>
                                <select name="status" id="status-select" required
                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @foreach (\App\Models\Application::STATUSES as $s)
                                        <option value="{{ $s }}"
                                            {{ $application->status === $s ? 'selected' : '' }}>
                                            {{ $s }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Interview fields (shown only when "Dipanggil Interview" selected) --}}
                            <div id="interview-fields"
                                class="{{ $application->status === 'Dipanggil Interview' ? '' : 'hidden' }} space-y-3 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Jadwal Interview
                                </p>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Tanggal &amp; Waktu</label>
                                    <input type="datetime-local" name="interview_at"
                                        value="{{ $application->interview_at?->format('Y-m-d\TH:i') }}"
                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Lokasi</label>
                                    <input type="text" name="interview_location"
                                        value="{{ $application->interview_location }}"
                                        placeholder="Contoh: Gedung A, Lt 3 / Google Meet"
                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Catatan untuk Pelamar</label>
                                    <textarea name="interview_notes" rows="2" placeholder="Instruksi atau informasi tambahan..."
                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">{{ $application->interview_notes }}</textarea>
                                </div>
                                <p class="text-xs text-blue-600">Email undangan akan dikirim otomatis ke pelamar saat
                                    disimpan.</p>
                            </div>

                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Catatan (opsional)</label>
                                <textarea name="employer_notes" rows="3" placeholder="Tambahkan catatan untuk pelamar..."
                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">{{ $application->employer_notes }}</textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-lg transition">
                                Simpan Status
                            </button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('status-select').addEventListener('change', function() {
                            const interviewFields = document.getElementById('interview-fields');
                            if (this.value === 'Dipanggil Interview') {
                                interviewFields.classList.remove('hidden');
                            } else {
                                interviewFields.classList.add('hidden');
                            }
                        });
                    </script>
                </div>

                {{-- MCU Panel (only visible when status = Menunggu MCU or finished) --}}
                @if (in_array($application->status, ['Menunggu MCU', 'Onboarding', 'Diterima', 'Tidak Diterima']))
                    @php $mcuResult = $application->mcuResult; @endphp
                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-5">
                        <h4 class="font-semibold text-orange-700 text-sm uppercase tracking-wide mb-3">
                            Medical Check-Up
                        </h4>

                        @if ($mcuResult?->result)
                            <div class="mb-3 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $mcuResult->result === 'Lulus' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                    MCU {{ $mcuResult->result }}
                                </span>
                            </div>
                            @if ($mcuResult->notes)
                                <p class="text-xs text-gray-600 mb-3">{{ $mcuResult->notes }}</p>
                            @endif
                        @else
                            <p class="text-xs text-orange-600 mb-3">
                                Paket MCU:
                                <strong>{{ $mcuResult?->package?->code ? 'Paket ' . $mcuResult->package->code : 'Belum ditentukan' }}</strong>
                            </p>
                        @endif

                        @if (!$application->isFinished())
                            <form action="{{ route('employer.applications.mcu', $application) }}" method="POST"
                                class="space-y-3">
                                @csrf @method('PATCH')

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Paket MCU</label>
                                    <select name="mcu_package_id" required
                                        class="w-full border-gray-300 rounded-lg text-xs focus:ring-orange-400 focus:border-orange-400">
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach (\App\Models\McuPackage::orderBy('code')->get() as $pkg)
                                            <option value="{{ $pkg->id }}"
                                                {{ $mcuResult?->mcu_package_id == $pkg->id ? 'selected' : '' }}>
                                                Paket {{ $pkg->code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tgl Jadwal</label>
                                        <input type="date" name="scheduled_date"
                                            value="{{ $mcuResult?->scheduled_date?->format('Y-m-d') }}"
                                            class="w-full border-gray-300 rounded-lg text-xs focus:ring-orange-400">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tgl Selesai</label>
                                        <input type="date" name="completed_date"
                                            value="{{ $mcuResult?->completed_date?->format('Y-m-d') }}"
                                            class="w-full border-gray-300 rounded-lg text-xs focus:ring-orange-400">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Hasil MCU <span
                                            class="text-red-500">*</span></label>
                                    <select name="result" required
                                        class="w-full border-gray-300 rounded-lg text-xs focus:ring-orange-400 focus:border-orange-400">
                                        <option value="">-- Pilih Hasil --</option>
                                        <option value="Lulus"
                                            {{ $mcuResult?->result === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Tidak Lulus"
                                            {{ $mcuResult?->result === 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Catatan</label>
                                    <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg text-xs focus:ring-orange-400">{{ $mcuResult?->notes }}</textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-2 rounded-lg transition">
                                    Simpan Hasil MCU
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

                {{-- Onboarding Documents Panel --}}
                @if (in_array($application->status, ['Onboarding', 'Diterima']))
                    <div class="bg-teal-50 border border-teal-200 rounded-xl p-5">
                        <h4 class="font-semibold text-teal-700 text-sm uppercase tracking-wide mb-3">Dokumen Onboarding
                        </h4>

                        @php $docs = $application->applicantDocuments ?? collect(); @endphp

                        @if ($docs->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($docs as $adoc)
                                    <div
                                        class="flex items-center justify-between bg-white rounded-lg px-3 py-2 text-sm">
                                        <div class="min-w-0">
                                            <p class="text-gray-700 font-medium text-xs truncate">
                                                {{ $adoc->supportingDocument?->description }}</p>
                                            <p class="text-gray-400 text-xs truncate">{{ $adoc->original_name }}</p>
                                        </div>
                                        <a href="{{ Storage::url($adoc->file_path) }}" target="_blank"
                                            class="text-teal-600 hover:underline text-xs font-medium flex-shrink-0 ml-2">
                                            Lihat ↗
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-teal-600 text-xs">Pelamar belum mengupload dokumen.</p>
                        @endif
                    </div>
                @endif

                {{-- Job info --}}
                <div class="bg-white rounded-xl shadow-sm p-5 text-sm space-y-2">
                    <h4 class="font-semibold text-gray-700 text-sm uppercase tracking-wide mb-3">Info Lowongan</h4>
                    <p class="text-gray-800 font-medium">{{ $application->jobPosting->title }}</p>
                    @if ($application->jobPosting->department)
                        <p class="text-gray-500">{{ $application->jobPosting->department }}</p>
                    @endif
                    <p class="text-gray-400 text-xs">
                        Dikirim {{ $application->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-layouts.hrd>
