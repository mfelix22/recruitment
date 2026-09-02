<x-layouts.applicant>
    <x-slot name="heading">{{ $work ? 'Ubah Pengalaman Kerja' : 'Tambah Pengalaman Kerja' }}</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">

                <form method="POST"
                    action="{{ $work ? route('applicant.work.update', $work) : route('applicant.work.store') }}">
                    @csrf
                    @if ($work)
                        @method('PUT')
                    @endif

                    <div class="space-y-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Company --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Perusahaan <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="company" value="{{ old('company', $work?->company) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('company') border-red-400 @enderror">
                                @error('company')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Position --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jabatan / Posisi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="position" value="{{ old('position', $work?->position) }}"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('position') border-red-400 @enderror">
                                @error('position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Supervisor --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Atasan Langsung</label>
                                <input type="text" name="supervisor_name"
                                    value="{{ old('supervisor_name', $work?->supervisor_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>

                            {{-- Start Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Masuk <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="start_date"
                                    value="{{ old('start_date', $work?->start_date?->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('start_date') border-red-400 @enderror">
                                @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Keluar</label>
                                <input type="date" name="end_date" id="end_date_field"
                                    value="{{ old('end_date', $work?->end_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                <div class="mt-1 flex items-center gap-2">
                                    <input type="hidden" name="still_working" value="0">
                                    <input type="checkbox" id="still_working" name="still_working" value="1"
                                        @checked(old('still_working', $work?->still_working))
                                        onchange="document.getElementById('end_date_field').disabled = this.checked"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="still_working" class="text-xs text-gray-600">Masih bekerja di
                                        sini</label>
                                </div>
                            </div>

                            {{-- Salary --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Gaji (incl.
                                    tunjangan)</label>
                                <input type="text" name="salary_total"
                                    value="{{ old('salary_total', $work?->salary_total) }}"
                                    placeholder="mis. Rp 8.000.000,-"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>

                            {{-- Facilities --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fasilitas</label>
                                <input type="text" name="facilities"
                                    value="{{ old('facilities', $work?->facilities) }}"
                                    placeholder="mis. BPJS, Kendaraan, Asuransi"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>

                            {{-- Subordinates --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Bawahan Langsung</label>
                                <input type="number" name="subordinates_count" min="0"
                                    value="{{ old('subordinates_count', $work?->subordinates_count) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>

                        </div>

                        {{-- Job Description --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Uraian Tugas / Job
                                Description</label>
                            <textarea name="job_description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('job_description', $work?->job_description) }}</textarea>
                        </div>

                        {{-- Achievement --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prestasi / Pencapaian</label>
                            <textarea name="achievement" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ old('achievement', $work?->achievement) }}</textarea>
                        </div>

                        {{-- Reason for Leaving --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alasan Berhenti</label>
                            <input type="text" name="reason_for_leaving"
                                value="{{ old('reason_for_leaving', $work?->reason_for_leaving) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>

                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg">
                            {{ $work ? 'Simpan Perubahan' : 'Tambahkan' }}
                        </button>
                        <a href="{{ route('applicant.profile.edit') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-6 py-2 rounded-lg">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layouts.applicant>
