<x-layouts.applicant>
    <x-slot name="heading">Dokumen Onboarding</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info Banner --}}
            <div class="bg-teal-50 border border-teal-200 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="text-teal-500 text-2xl mt-0.5">📋</div>
                    <div>
                        <h3 class="font-semibold text-teal-800 text-sm">Selamat! Anda Sedang dalam Tahap Onboarding</h3>
                        <p class="text-teal-700 text-sm mt-1">
                            Silakan lengkapi dokumen berikut untuk menyelesaikan proses onboarding Anda.
                            Dokumen bertanda <span class="font-bold text-red-600">Wajib</span> harus diunggah.
                            Ukuran maksimal per file: <strong>5 MB</strong>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Lamaran info --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Lamaran</h3>
                <div class="grid grid-cols-2 gap-y-2 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Posisi</p>
                        <p class="text-gray-700 font-medium">{{ $application->jobPosting->title }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Departemen</p>
                        <p class="text-gray-700">{{ $application->jobPosting->department ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Document List --}}
            @php
                $mandatoryTotal = $requiredDocs->where('status', 'mandatory')->count();
                $mandatoryDone = $requiredDocs
                    ->where('status', 'mandatory')
                    ->filter(fn($d) => $uploaded->has($d->id))
                    ->count();
                $allMandatoryDone = $mandatoryTotal > 0 && $mandatoryDone === $mandatoryTotal;
            @endphp

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">Daftar Dokumen</h3>
                    <div class="text-xs text-gray-500">
                        Wajib: <span
                            class="font-semibold {{ $allMandatoryDone ? 'text-green-600' : 'text-red-600' }}">{{ $mandatoryDone }}/{{ $mandatoryTotal }}</span>
                        selesai
                    </div>
                </div>

                @forelse($requiredDocs as $i => $doc)
                    @php $uploadedDoc = $uploaded->get($doc->id); @endphp
                    <div class="border-b border-gray-50 last:border-b-0 p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-gray-400 text-xs font-medium">{{ $i + 1 }}.</span>
                                    <span class="text-sm font-medium text-gray-800">{{ $doc->description }}</span>
                                    @if ($doc->status === 'mandatory')
                                        <span
                                            class="text-xs bg-red-100 text-red-600 font-semibold px-2 py-0.5 rounded-full">Wajib</span>
                                    @else
                                        <span
                                            class="text-xs bg-green-100 text-green-600 font-semibold px-2 py-0.5 rounded-full">Opsional</span>
                                    @endif
                                    <span
                                        class="text-xs bg-blue-100 text-blue-600 font-bold px-2 py-0.5 rounded uppercase">{{ $doc->format_file }}</span>
                                </div>

                                @if ($uploadedDoc)
                                    {{-- Already uploaded --}}
                                    <div class="mt-2 flex items-center gap-3">
                                        <div
                                            class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-lg px-3 py-1.5 text-sm">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <a href="{{ Storage::url($uploadedDoc->file_path) }}" target="_blank"
                                                class="text-green-700 hover:underline truncate max-w-[200px]">
                                                {{ $uploadedDoc->original_name ?? 'Lihat file' }}
                                            </a>
                                        </div>
                                        <form
                                            action="{{ route('applicant.onboarding.destroy', [$application, $uploadedDoc]) }}"
                                            method="POST" onsubmit="return confirm('Hapus file ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 mt-1.5">Belum diupload</p>
                                @endif
                            </div>

                            {{-- Upload button (toggle) --}}
                            <div class="flex-shrink-0">
                                <button onclick="toggleUpload('upload-{{ $doc->id }}')"
                                    class="text-xs {{ $uploadedDoc ? 'bg-yellow-400 hover:bg-yellow-500' : 'bg-teal-600 hover:bg-teal-700' }} text-white px-3 py-1.5 rounded-lg font-medium transition">
                                    {{ $uploadedDoc ? 'Ganti' : 'Upload' }}
                                </button>
                            </div>
                        </div>

                        {{-- Upload Form (hidden by default) --}}
                        <div id="upload-{{ $doc->id }}" class="hidden mt-3">
                            <form action="{{ route('applicant.onboarding.store', $application) }}" method="POST"
                                enctype="multipart/form-data" class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                                @csrf
                                <input type="hidden" name="supporting_document_id" value="{{ $doc->id }}">
                                <div class="flex-1">
                                    <input type="file" name="file" required accept=".{{ $doc->format_file }}"
                                        class="block w-full text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100 cursor-pointer">
                                    <p class="text-xs text-gray-400 mt-1">Format: .{{ strtoupper($doc->format_file) }},
                                        maks 5MB</p>
                                </div>
                                <div class="flex gap-2 flex-shrink-0">
                                    <button type="submit"
                                        class="bg-teal-600 hover:bg-teal-700 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                        Kirim
                                    </button>
                                    <button type="button" onclick="toggleUpload('upload-{{ $doc->id }}')"
                                        class="text-gray-500 hover:text-gray-700 text-xs px-3 py-1.5 rounded border border-gray-300 transition">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-12 text-center text-gray-400 text-sm">
                        Tidak ada dokumen yang diperlukan.
                    </div>
                @endforelse
            </div>

            @if ($allMandatoryDone)
                <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700">
                    ✅ Semua dokumen wajib telah diupload. Tim HRD kami akan memverifikasi dan menghubungi Anda.
                </div>
            @endif

        </div>
    </div>

    @push('scripts')
        <script>
            function toggleUpload(id) {
                const el = document.getElementById(id);
                el.classList.toggle('hidden');
            }
        </script>
    @endpush
</x-layouts.applicant>
