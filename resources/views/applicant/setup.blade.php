<x-layouts.applicant>
    <x-slot name="heading">Lengkapi Profil Anda</x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome banner --}}
            <div class="bg-blue-600 text-white rounded-xl p-6 mb-6">
                <h3 class="text-lg font-bold">Selamat datang, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-blue-100 text-sm mt-1">
                    Lengkapi informasi dasar di bawah ini. Data ini membantu kami mengenal Anda
                    dan menyimpan profil Anda di database kami — bahkan jika Anda belum melamar posisi apapun.
                </p>
                <div class="flex items-center gap-4 mt-4 text-sm">
                    <span class="flex items-center gap-1.5 bg-blue-500 rounded-lg px-3 py-1.5">
                        <span class="w-2 h-2 bg-white rounded-full"></span>
                        Langkah 1: Profil Dasar <span class="font-bold ml-1">(Sekarang)</span>
                    </span>
                    <span class="text-blue-200">→</span>
                    <span class="flex items-center gap-1.5 text-blue-200">
                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                        Langkah 2: Form Lamaran (saat melamar)
                    </span>
                </div>
            </div>

            {{-- Flash --}}
            @if (session('info'))
                <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    <p class="font-medium mb-1">Harap perbaiki isian berikut:</p>
                    <ul class="list-disc ml-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applicant.setup.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- ── SECTION 1: Data Diri ── --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                        <h4 class="font-semibold text-gray-700 text-sm">A. Data Diri</h4>
                    </div>
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Nama (read-only) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 text-sm cursor-not-allowed">
                        </div>

                        {{-- Email (read-only) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 text-sm cursor-not-allowed">
                        </div>

                        {{-- NIK --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                NIK (KTP) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik" value="{{ old('nik', $profile?->nik) }}" maxlength="20"
                                required placeholder="16 digit nomor KTP"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-400 @enderror">
                            @error('nik')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Nomor HP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}"
                                maxlength="20" required placeholder="Contoh: 08123456789"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-400 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"
                                    {{ old('gender', $profile?->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('gender', $profile?->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Marital Status --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Status Perkawinan <span class="text-red-500">*</span>
                            </label>
                            <select name="marital_status" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('marital_status') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach (['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $ms)
                                    <option value="{{ $ms }}"
                                        {{ old('marital_status', $profile?->marital_status) === $ms ? 'selected' : '' }}>
                                        {{ $ms }}</option>
                                @endforeach
                            </select>
                            @error('marital_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Place of Birth --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="place_of_birth"
                                value="{{ old('place_of_birth', $profile?->place_of_birth) }}" required
                                placeholder="Contoh: Jakarta"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('place_of_birth') border-red-400 @enderror">
                            @error('place_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date of Birth --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $profile?->date_of_birth?->format('Y-m-d')) }}" required
                                max="{{ now()->subYears(15)->format('Y-m-d') }}"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('date_of_birth') border-red-400 @enderror">
                            @error('date_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Religion --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Agama <span class="text-red-500">*</span>
                            </label>
                            <select name="religion" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('religion') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach ($religions as $r)
                                    <option value="{{ $r }}"
                                        {{ old('religion', $profile?->religion) === $r ? 'selected' : '' }}>
                                        {{ $r }}</option>
                                @endforeach
                            </select>
                            @error('religion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Province --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <select name="province" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('province') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach ($provinces as $p)
                                    <option value="{{ $p }}"
                                        {{ old('province', $profile?->address?->province) === $p ? 'selected' : '' }}>
                                        {{ $p }}</option>
                                @endforeach
                            </select>
                            @error('province')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- City/Kabupaten --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Kota / Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kabupaten" required
                                value="{{ old('kabupaten', $profile?->address?->kabupaten) }}"
                                placeholder="Contoh: Kota Surabaya"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('kabupaten') border-red-400 @enderror">
                            @error('kabupaten')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Street --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="street" required
                                value="{{ old('street', $profile?->address?->street) }}"
                                placeholder="Nama jalan, nomor rumah"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('street') border-red-400 @enderror">
                            @error('street')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ── SECTION 2: Pendidikan Terakhir ── --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                        <h4 class="font-semibold text-gray-700 text-sm">B. Pendidikan Terakhir <span
                                class="text-red-500">*</span></h4>
                        <p class="text-xs text-gray-400 mt-0.5">Isi pendidikan tertinggi yang pernah ditempuh</p>
                    </div>
                    @php $existingEdu = $profile?->educations?->first(); @endphp
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Level --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Jenjang <span class="text-red-500">*</span>
                            </label>
                            <select name="edu_level" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('edu_level') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach ($educationLevels as $lvl)
                                    <option value="{{ $lvl }}"
                                        {{ old('edu_level', $existingEdu?->level) === $lvl ? 'selected' : '' }}>
                                        {{ $lvl }}</option>
                                @endforeach
                            </select>
                            @error('edu_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Year Start --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun Masuk <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="edu_year_start"
                                value="{{ old('edu_year_start', $existingEdu?->year_start) }}" min="1950"
                                max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') - 4 }}" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('edu_year_start') border-red-400 @enderror">
                            @error('edu_year_start')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Year End --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun Lulus</label>
                            <input type="number" name="edu_year_end"
                                value="{{ old('edu_year_end', $existingEdu?->year_end) }}" min="1950"
                                max="{{ date('Y') + 1 }}" placeholder="{{ date('Y') }}"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- Institution --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Nama Sekolah / Universitas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="edu_institution"
                                value="{{ old('edu_institution', $existingEdu?->institution) }}" required
                                placeholder="Contoh: Universitas Indonesia"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('edu_institution') border-red-400 @enderror">
                            @error('edu_institution')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Major --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jurusan / Program Studi</label>
                            <input type="text" name="edu_major"
                                value="{{ old('edu_major', $existingEdu?->major) }}"
                                placeholder="Contoh: Teknik Informatika"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        {{-- GPA --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">IPK (jika ada)</label>
                            <input type="number" name="edu_gpa" step="0.01" min="0" max="4"
                                value="{{ old('edu_gpa', $existingEdu?->gpa) }}" placeholder="Contoh: 3.50"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                    </div>
                </div>

                {{-- ── SECTION 3: Pengalaman Kerja Terakhir (Opsional) ── --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="bg-gray-50 px-5 py-3 border-b border-gray-100">
                        <h4 class="font-semibold text-gray-700 text-sm">C. Pengalaman Kerja Terakhir
                            <span class="text-gray-400 font-normal">(Opsional)</span>
                        </h4>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih "Fresh Graduate" jika belum pernah bekerja</p>
                    </div>
                    @php $existingWork = $profile?->workExperiences?->first(); @endphp
                    <div class="p-5 space-y-4">

                        {{-- Fresh Graduate toggle --}}
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="work_status" value="fresh_graduate" id="radio-fresh"
                                    {{ old('work_status', $existingWork ? 'has_experience' : 'fresh_graduate') === 'fresh_graduate' ? 'checked' : '' }}
                                    class="text-blue-600 focus:ring-blue-500" onchange="toggleWorkFields(this.value)">
                                <span class="text-sm font-medium text-gray-700">Fresh Graduate / Belum pernah
                                    bekerja</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="work_status" value="has_experience" id="radio-exp"
                                    {{ old('work_status', $existingWork ? 'has_experience' : 'fresh_graduate') === 'has_experience' ? 'checked' : '' }}
                                    class="text-blue-600 focus:ring-blue-500" onchange="toggleWorkFields(this.value)">
                                <span class="text-sm font-medium text-gray-700">Pernah bekerja</span>
                            </label>
                        </div>

                        {{-- Work fields (hidden when Fresh Graduate) --}}
                        <div id="work-fields"
                            class="{{ old('work_status', $existingWork ? 'has_experience' : 'fresh_graduate') === 'fresh_graduate' ? 'hidden' : '' }} grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Company --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Nama Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="work_company" data-work-required
                                    value="{{ old('work_company', $existingWork?->company) }}"
                                    placeholder="Contoh: PT. Contoh Indonesia"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_company') border-red-400 @enderror">
                                @error('work_company')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Position --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Jabatan / Posisi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="work_position" data-work-required
                                    value="{{ old('work_position', $existingWork?->position) }}"
                                    placeholder="Contoh: Staff Administrasi"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_position') border-red-400 @enderror">
                                @error('work_position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Job Description --}}
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Job Desk / Deskripsi Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="work_job_description" rows="2" data-work-required
                                    placeholder="Jelaskan tugas dan tanggung jawab utama Anda"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_job_description') border-red-400 @enderror">{{ old('work_job_description', $existingWork?->job_description) }}</textarea>
                                @error('work_job_description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Start Date --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Mulai Bekerja <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="work_start_date" data-work-required
                                    value="{{ old('work_start_date', $existingWork?->start_date?->format('Y-m-d')) }}"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_start_date') border-red-400 @enderror">
                                @error('work_start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- End Date / Still Working --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Selesai Bekerja <span class="text-red-500">*</span>
                                </label>
                                <div id="work-end-wrap"
                                    class="{{ old('work_still_here', $existingWork?->still_working) ? 'hidden' : '' }}">
                                    <input type="date" name="work_end_date" id="work-end-date"
                                        value="{{ old('work_end_date', $existingWork?->end_date?->format('Y-m-d')) }}"
                                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_end_date') border-red-400 @enderror">
                                    @error('work_end_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="work-present-label"
                                    class="{{ old('work_still_here', $existingWork?->still_working) ? '' : 'hidden' }} w-full rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-500 px-3 py-2">
                                    Present
                                </div>
                                <label class="flex items-center gap-2 mt-2 cursor-pointer">
                                    <input type="checkbox" name="work_still_here" value="1" id="work-still-here"
                                        {{ old('work_still_here', $existingWork?->still_working) ? 'checked' : '' }}
                                        class="rounded text-blue-600 focus:ring-blue-500"
                                        onchange="toggleStillWorking()">
                                    <span class="text-xs text-gray-600">Saya masih bekerja di sini</span>
                                </label>
                            </div>

                            {{-- Reason for leaving (only when not still working) --}}
                            <div class="sm:col-span-2 {{ old('work_still_here', $existingWork?->still_working) ? 'hidden' : '' }}"
                                id="work-reason-wrap">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Alasan Keluar dari Pekerjaan Sebelumnya <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="work_reason_for_leaving" id="work-reason"
                                    value="{{ old('work_reason_for_leaving', $existingWork?->reason_for_leaving) }}"
                                    placeholder="Contoh: Kontrak berakhir, resign untuk melanjutkan studi"
                                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 @error('work_reason_for_leaving') border-red-400 @enderror">
                                @error('work_reason_for_leaving')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- Fresh Graduate confirmation message --}}
                        <div id="fresh-msg"
                            class="{{ old('work_status', $existingWork ? 'has_experience' : 'fresh_graduate') !== 'fresh_graduate' ? 'hidden' : '' }} bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 text-sm text-blue-700">
                            ✓ Anda dipilih sebagai <strong>Fresh Graduate</strong>. Data pengalaman kerja tidak
                            diperlukan.
                        </div>

                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-between">
                    <p class="text-xs text-gray-400">
                        <span class="text-red-500">*</span> wajib diisi
                    </p>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-2.5 rounded-lg text-sm transition shadow-sm">
                        Simpan & Lanjutkan →
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleWorkFields(value) {
                const fields = document.getElementById('work-fields');
                const freshMsg = document.getElementById('fresh-msg');
                const experienced = value === 'has_experience';

                fields.classList.toggle('hidden', !experienced);
                freshMsg.classList.toggle('hidden', experienced);
                fields.querySelectorAll('[data-work-required]').forEach(el => el.required = experienced);

                toggleStillWorking();
            }

            function toggleStillWorking() {
                const experienced = document.getElementById('radio-exp').checked;
                const still = document.getElementById('work-still-here').checked;
                const endWrap = document.getElementById('work-end-wrap');
                const endInput = document.getElementById('work-end-date');
                const presentLabel = document.getElementById('work-present-label');
                const reasonWrap = document.getElementById('work-reason-wrap');
                const reasonInput = document.getElementById('work-reason');

                endWrap.classList.toggle('hidden', still);
                presentLabel.classList.toggle('hidden', !still);
                endInput.disabled = still;
                endInput.required = experienced && !still;

                reasonWrap.classList.toggle('hidden', still);
                reasonInput.disabled = still;
                reasonInput.required = experienced && !still;
            }

            document.addEventListener('DOMContentLoaded', function() {
                toggleWorkFields(document.querySelector('input[name="work_status"]:checked')?.value ||
                    'fresh_graduate');
            });
        </script>
    @endpush
</x-layouts.applicant>
