<x-layouts.applicant>
    <x-slot name="heading">Data Diri Lengkap</x-slot>

    @php
        $essay = $profile?->essay;
        $ktpAddr = $profile?->addresses->firstWhere('address_type', 'ktp');
        $hasFreshGrad = !$profile?->workExperiences->count();
        $savedPrefs = $profile?->jobTypePreferences->keyBy('job_type');
        $jobTypes = \App\Models\JobTypePreference::JOB_TYPES;
    @endphp

    <div class="py-6 px-4 max-w-5xl mx-auto space-y-4">

        {{-- Flash --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
                <p class="font-semibold mb-1">Harap perbaiki isian berikut:</p>
                <ul class="list-disc ml-5 space-y-0.5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tab Nav --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex overflow-x-auto border-b border-gray-200" id="tab-nav">
                @php
                    $tabs = [
                        ['id' => 'tab-a', 'label' => 'A. Identitas'],
                        ['id' => 'tab-b', 'label' => 'B. Keluarga'],
                        ['id' => 'tab-c', 'label' => 'C. Pendidikan'],
                        ['id' => 'tab-d', 'label' => 'D. Pekerjaan'],
                        ['id' => 'tab-e', 'label' => 'E. Minat'],
                        ['id' => 'tab-f', 'label' => 'F. Aktivitas'],
                        ['id' => 'tab-g', 'label' => 'G. Lain-lain'],
                    ];
                @endphp
                @foreach ($tabs as $i => $tab)
                    <button type="button" onclick="showTab('{{ $tab['id'] }}')" id="btn-{{ $tab['id'] }}"
                        class="tab-btn flex-shrink-0 px-4 py-3 text-sm font-medium border-b-2 transition whitespace-nowrap
                            {{ $i === 0 ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            <form method="POST" action="{{ route('applicant.profile.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB A — IDENTITAS --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-a" class="tab-panel p-6 space-y-5">
                    <h3 class="text-base font-bold text-indigo-700">A. Identitas Diri</h3>

                    {{-- Company Preferences --}}
                    @php
                        $savedCompanyPrefs = old('company_preferences', $profile?->company_preferences ?? []);
                        $companyRow1 = ['PT. Hartono Raya Motor', 'Surabaya', 'Jakarta', 'Semarang', 'Bali'];
                        $companyRow2 = ['PT. Rudy Darma Engineering', 'Harent', 'Grand Istana Rama Hotel, Bali'];
                        $companyOptions = array_merge($companyRow1, $companyRow2);
                    @endphp
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        {{-- Row 1: Jabatan --}}
                        <div class="flex items-center border-b border-gray-200">
                            <div
                                class="w-48 shrink-0 px-4 py-3 text-sm text-gray-600 bg-gray-50 border-r border-gray-200">
                                Untuk jabatan apa Saudara melamar
                            </div>
                            <div class="px-2 py-3 text-gray-400 bg-gray-50 border-r border-gray-200 text-sm">:</div>
                            <div class="flex-1 px-4 py-2">
                                <input type="text" name="desired_position"
                                    value="{{ old('desired_position', $profile?->desired_position) }}"
                                    placeholder="Tulis jabatan yang dilamar..."
                                    class="field-input @error('desired_position') border-red-400 @enderror">
                                @error('desired_position')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        {{-- Row 2: Perusahaan --}}
                        <div class="flex items-start">
                            <div
                                class="w-48 shrink-0 px-4 py-3 text-sm text-gray-600 bg-gray-50 border-r border-gray-200">
                                Saudara melamar untuk perusahaan mana
                            </div>
                            <div class="px-2 py-3 text-gray-400 bg-gray-50 border-r border-gray-200 text-sm">:</div>
                            <div class="flex-1 px-4 py-3 space-y-2">
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    @foreach ($companyRow1 as $co)
                                        <label
                                            class="flex items-center gap-1.5 text-sm text-gray-700 cursor-pointer select-none">
                                            <input type="checkbox" name="company_preferences[]"
                                                value="{{ $co }}"
                                                {{ in_array($co, $savedCompanyPrefs) ? 'checked' : '' }}
                                                class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            {{ $co }}
                                        </label>
                                    @endforeach
                                </div>
                                <div class="flex flex-wrap gap-x-6 gap-y-2">
                                    @foreach ($companyRow2 as $co)
                                        <label
                                            class="flex items-center gap-1.5 text-sm text-gray-700 cursor-pointer select-none">
                                            <input type="checkbox" name="company_preferences[]"
                                                value="{{ $co }}"
                                                {{ in_array($co, $savedCompanyPrefs) ? 'checked' : '' }}
                                                class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            {{ $co }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>{{-- outer box --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="field-label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                class="field-input @error('name') border-red-400 @enderror" required>
                            @error('name')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="field-label">Alamat Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                class="field-input bg-gray-50 text-gray-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="field-label">NIK (KTP) <span class="text-red-500">*</span></label>
                            <input type="text" name="nik" maxlength="16"
                                value="{{ old('nik', $profile?->nik) }}" placeholder="16 digit"
                                class="field-input @error('nik') border-red-400 @enderror" required>
                            @error('nik')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">No. HP <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $profile?->phone) }}"
                                class="field-input @error('phone') border-red-400 @enderror" required>
                            @error('phone')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="place_of_birth"
                                value="{{ old('place_of_birth', $profile?->place_of_birth) }}"
                                class="field-input @error('place_of_birth') border-red-400 @enderror" required>
                            @error('place_of_birth')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="date_of_birth"
                                value="{{ old('date_of_birth', $profile?->date_of_birth?->format('Y-m-d')) }}"
                                id="dob-input" class="field-input @error('date_of_birth') border-red-400 @enderror"
                                required>
                            <p class="text-xs text-gray-400 mt-1" id="age-display"></p>
                            @error('date_of_birth')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" class="field-input @error('gender') border-red-400 @enderror"
                                required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Laki-laki', 'Perempuan'] as $g)
                                    <option value="{{ $g }}" @selected(old('gender', $profile?->gender) === $g)>
                                        {{ $g }}</option>
                                @endforeach
                            </select>
                            @error('gender')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Agama / Kepercayaan <span class="text-red-500">*</span></label>
                            <select name="religion" class="field-input @error('religion') border-red-400 @enderror"
                                required>
                                <option value="">-- Pilih --</option>
                                @foreach ($religions as $r)
                                    <option value="{{ $r }}" @selected(old('religion', $profile?->religion) === $r)>
                                        {{ $r }}</option>
                                @endforeach
                            </select>
                            @error('religion')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Kewarganegaraan <span class="text-red-500">*</span></label>
                            <input type="text" name="nationality"
                                value="{{ old('nationality', $profile?->nationality ?? 'Indonesia') }}"
                                class="field-input" required>
                        </div>

                        <div>
                            <label class="field-label">Golongan Darah <span class="text-red-500">*</span></label>
                            <select name="blood_type"
                                class="field-input @error('blood_type') border-red-400 @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                    <option value="{{ $bt }}" @selected(old('blood_type', $profile?->blood_type) === $bt)>
                                        {{ $bt }}</option>
                                @endforeach
                            </select>
                            @error('blood_type')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                            <input type="number" name="height_cm" min="50" max="250"
                                value="{{ old('height_cm', $profile?->height_cm) }}"
                                class="field-input @error('height_cm') border-red-400 @enderror" required>
                            @error('height_cm')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="field-label">Berat Badan (kg) <span class="text-red-500">*</span></label>
                            <input type="number" name="weight_kg" min="20" max="300"
                                value="{{ old('weight_kg', $profile?->weight_kg) }}"
                                class="field-input @error('weight_kg') border-red-400 @enderror" required>
                            @error('weight_kg')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- KTP --}}
                        <div>
                            <label class="field-label">No. KTP (sama dengan NIK)</label>
                            <input type="text" value="{{ old('nik', $profile?->nik) }}" readonly
                                class="field-input bg-gray-50 text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="field-label">KTP Dikeluarkan Di <span class="text-red-500">*</span></label>
                            <input type="text" name="ktp_issued_place"
                                value="{{ old('ktp_issued_place', $profile?->ktp_issued_place) }}"
                                class="field-input @error('ktp_issued_place') border-red-400 @enderror" required>
                            @error('ktp_issued_place')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- SIM --}}
                        <div>
                            <label class="field-label">No. SIM <span class="text-red-500">*</span></label>
                            <input type="text" name="sim_no" value="{{ old('sim_no', $profile?->sim_no) }}"
                                class="field-input @error('sim_no') border-red-400 @enderror" required>
                            @error('sim_no')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="field-label">SIM Dikeluarkan Di <span class="text-red-500">*</span></label>
                            <input type="text" name="sim_issued_place"
                                value="{{ old('sim_issued_place', $profile?->sim_issued_place) }}"
                                class="field-input @error('sim_issued_place') border-red-400 @enderror" required>
                            @error('sim_issued_place')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat Domisili --}}
                        <div class="md:col-span-2 border-t pt-4">
                            <h4 class="font-semibold text-gray-700 text-sm mb-3">Alamat Domisili <span
                                    class="text-red-500">*</span></h4>
                            <textarea name="domisili_address" rows="2"
                                class="field-input @error('domisili_address') border-red-400 @enderror"
                                placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota" required>{{ old('domisili_address', $profile?->domisili_address) }}</textarea>
                            @error('domisili_address')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="field-label">No. Telp. Domisili <span class="text-red-500">*</span></label>
                            <input type="text" name="domisili_phone"
                                value="{{ old('domisili_phone', $profile?->domisili_phone) }}"
                                class="field-input @error('domisili_phone') border-red-400 @enderror" required>
                            @error('domisili_phone')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Alamat KTP --}}
                        <div class="md:col-span-2 border-t pt-4">
                            <h4 class="font-semibold text-gray-700 text-sm mb-3">Alamat Tetap (KTP)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="field-label">Jalan / No. Rumah <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="street"
                                        value="{{ old('street', $ktpAddr?->street) }}"
                                        class="field-input @error('street') border-red-400 @enderror" required>
                                    @error('street')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">RT / RW <span class="text-red-500">*</span></label>
                                    <input type="text" name="rt_rw"
                                        value="{{ old('rt_rw', $ktpAddr?->rt_rw) }}" placeholder="001/002"
                                        class="field-input @error('rt_rw') border-red-400 @enderror" required>
                                    @error('rt_rw')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">No. Telp. (KTP alamat) <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="ktp_phone"
                                        value="{{ old('ktp_phone', $profile?->ktp_phone) }}"
                                        class="field-input @error('ktp_phone') border-red-400 @enderror" required>
                                    @error('ktp_phone')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Kelurahan / Desa <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="kelurahan"
                                        value="{{ old('kelurahan', $ktpAddr?->kelurahan) }}"
                                        class="field-input @error('kelurahan') border-red-400 @enderror" required>
                                    @error('kelurahan')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Kecamatan <span class="text-red-500">*</span></label>
                                    <input type="text" name="kecamatan"
                                        value="{{ old('kecamatan', $ktpAddr?->kecamatan) }}"
                                        class="field-input @error('kecamatan') border-red-400 @enderror" required>
                                    @error('kecamatan')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Kab. / Kota <span class="text-red-500">*</span></label>
                                    <input type="text" name="kabupaten"
                                        value="{{ old('kabupaten', $ktpAddr?->kabupaten) }}"
                                        class="field-input @error('kabupaten') border-red-400 @enderror" required>
                                    @error('kabupaten')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Provinsi <span class="text-red-500">*</span></label>
                                    <select name="province"
                                        class="field-input @error('province') border-red-400 @enderror" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinces as $prov)
                                            <option value="{{ $prov }}" @selected(old('province', $ktpAddr?->province) === $prov)>
                                                {{ $prov }}</option>
                                        @endforeach
                                    </select>
                                    @error('province')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="field-label">Kode Pos <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" maxlength="10"
                                        value="{{ old('postal_code', $ktpAddr?->postal_code) }}"
                                        class="field-input @error('postal_code') border-red-400 @enderror" required>
                                    @error('postal_code')
                                        <p class="field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Photo --}}
                        <div class="md:col-span-2 border-t pt-4">
                            <label class="field-label">Foto (maks 2MB) </label>
                            @if ($profile?->photo)
                                <img src="{{ Storage::url($profile->photo) }}" alt="Foto"
                                    class="w-24 h-24 object-cover rounded mb-2">
                            @endif
                            <input type="file" name="photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('photo')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB B — KELUARGA --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-b" class="tab-panel hidden p-6 space-y-6">
                    <h3 class="text-base font-bold text-indigo-700">B. Keluarga dan Lingkungan</h3>

                    {{-- Marital status --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Status Pernikahan <span class="text-red-500">*</span></label>
                            <select name="marital_status" id="marital-status-select"
                                class="field-input @error('marital_status') border-red-400 @enderror"
                                onchange="toggleMaritalDate(this.value)" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Belum Menikah', 'Bertunangan', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $m)
                                    <option value="{{ $m }}" @selected(old('marital_status', $profile?->marital_status) === $m)>
                                        {{ $m }}</option>
                                @endforeach
                            </select>
                            @error('marital_status')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div id="marital-since-wrap"
                            class="{{ in_array(old('marital_status', $profile?->marital_status), ['Bertunangan', 'Menikah', 'Cerai Hidup', 'Cerai Mati']) ? '' : 'hidden' }}">
                            <label class="field-label" id="marital-since-label">Sejak Tanggal</label>
                            <input type="date" name="marital_since"
                                value="{{ old('marital_since', $profile?->marital_since?->format('Y-m-d')) }}"
                                class="field-input">
                        </div>
                    </div>

                    {{-- House status + relocate --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Status Rumah Tempat Tinggal <span
                                    class="text-red-500">*</span></label>
                            <select name="house_status"
                                class="field-input @error('house_status') border-red-400 @enderror" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Rumah Pribadi', 'Rumah Orang Tua / Saudara', 'Rumah Kontrak', 'Kost / Pondokan'] as $hs)
                                    <option value="{{ $hs }}" @selected(old('house_status', $profile?->house_status) === $hs)>
                                        {{ $hs }}</option>
                                @endforeach
                            </select>
                            @error('house_status')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center mt-6">
                            <input type="hidden" name="willing_to_relocate" value="0">
                            <input type="checkbox" name="willing_to_relocate" value="1" id="relocate"
                                @checked(old('willing_to_relocate', $profile?->willing_to_relocate)) class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                            <label for="relocate" class="ml-2 text-sm text-gray-700">Bersedia ditempatkan di seluruh
                                Indonesia</label>
                        </div>
                    </div>

                    {{-- Other dependents --}}
                    <div>
                        <label class="field-label">Tanggungan lain (selain istri/suami & anak) <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="other_dependents"
                            value="{{ old('other_dependents', $profile?->other_dependents) }}"
                            placeholder="mis. Orang tua (2 orang), atau Tidak ada" class="field-input">
                    </div>

                    {{-- Immediate family --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Keluarga Inti (Suami / Istri / Anak) <span
                                    class="text-red-500">*</span></h4>
                            <button type="button" onclick="addFamilyRow('immediate')"
                                class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-2 py-2 text-left border w-28">Hubungan</th>
                                        <th class="px-2 py-2 text-left border">Nama</th>
                                        <th class="px-2 py-2 text-left border w-12">L/P</th>
                                        <th class="px-2 py-2 text-left border">Tempat Lahir</th>
                                        <th class="px-2 py-2 text-left border w-32">Tgl Lahir</th>
                                        <th class="px-2 py-2 text-left border w-24">Pendidikan</th>
                                        <th class="px-2 py-2 text-left border">Pekerjaan</th>
                                        <th class="px-2 py-2 border w-8"></th>
                                    </tr>
                                </thead>
                                <tbody id="immediate-family-body">
                                    @foreach ($profile?->immediateFamilyMembers ?? [] as $i => $fm)
                                        @include('applicant.profile._family_row', [
                                            'fm' => $fm,
                                            'idx' => $i,
                                            'type' => 'immediate',
                                            'educationLevels' => $educationLevels,
                                        ])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Origin family --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Keluarga Asal (Ayah / Ibu / Saudara
                                Kandung) <span class="text-red-500">*</span></h4>
                            <button type="button" onclick="addFamilyRow('origin')"
                                class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-2 py-2 text-left border w-28">Hubungan</th>
                                        <th class="px-2 py-2 text-left border">Nama</th>
                                        <th class="px-2 py-2 text-left border w-12">L/P</th>
                                        <th class="px-2 py-2 text-left border">Tempat Lahir</th>
                                        <th class="px-2 py-2 text-left border w-32">Tgl Lahir</th>
                                        <th class="px-2 py-2 text-left border w-24">Pendidikan</th>
                                        <th class="px-2 py-2 text-left border">Pekerjaan</th>
                                        <th class="px-2 py-2 border w-8"></th>
                                    </tr>
                                </thead>
                                <tbody id="origin-family-body">
                                    @php $imCount = count($profile?->immediateFamilyMembers ?? []); @endphp
                                    @foreach ($profile?->originFamilyMembers ?? [] as $j => $fm)
                                        @include('applicant.profile._family_row', [
                                            'fm' => $fm,
                                            'idx' => $imCount + $j,
                                            'type' => 'origin',
                                            'educationLevels' => $educationLevels,
                                        ])
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB C — PENDIDIKAN --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-c" class="tab-panel hidden p-6 space-y-6">
                    <h3 class="text-base font-bold text-indigo-700">C. Riwayat Pendidikan</h3>

                    {{-- Formal --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Pendidikan Formal (min. SMA/SMK ke atas)
                                <span class="text-red-500">*</span>
                            </h4>
                            <a href="{{ route('applicant.education.create') }}"
                                class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">+
                                Tambah</a>
                        </div>
                        @if ($profile?->educations->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm border border-gray-200 rounded">
                                    <thead class="bg-gray-50 text-gray-600">
                                        <tr>
                                            <th class="px-3 py-2 text-left border">Jenjang</th>
                                            <th class="px-3 py-2 text-left border">Nama Sekolah / Institusi</th>
                                            <th class="px-3 py-2 text-left border">Kota</th>
                                            <th class="px-3 py-2 text-left border">Jurusan</th>
                                            <th class="px-3 py-2 text-left border">Tahun</th>
                                            <th class="px-3 py-2 text-left border">IPK</th>
                                            <th class="px-3 py-2 border">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($profile->educations as $edu)
                                            <tr class="hover:bg-gray-50">
                                                <td class="border px-3 py-2">{{ $edu->level }}</td>
                                                <td class="border px-3 py-2">{{ $edu->institution }}</td>
                                                <td class="border px-3 py-2">{{ $edu->place ?? '-' }}</td>
                                                <td class="border px-3 py-2">{{ $edu->major ?? '-' }}</td>
                                                <td class="border px-3 py-2">{{ $edu->year_start }} –
                                                    {{ $edu->year_end ?? 'skr' }}</td>
                                                <td class="border px-3 py-2">{{ $edu->gpa ?? '-' }}</td>
                                                <td class="border px-3 py-2 text-center space-x-2">
                                                    <a href="{{ route('applicant.education.edit', $edu) }}"
                                                        class="text-indigo-600 hover:underline text-xs">Ubah</a>
                                                    <form method="POST"
                                                        action="{{ route('applicant.education.destroy', $edu) }}"
                                                        class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-500 hover:underline text-xs"
                                                            onclick="return confirm('Hapus data pendidikan ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Belum ada. Klik "+ Tambah".</p>
                        @endif
                    </div>

                    {{-- Informal / Training --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Pendidikan Non-Formal / Training / Seminar
                            </h4>
                            <button type="button" onclick="addTrainingRow()"
                                class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-2 py-2 text-left border">Nama Kursus / Training / Seminar</th>
                                        <th class="px-2 py-2 text-left border">Diselenggarakan Oleh</th>
                                        <th class="px-2 py-2 text-left border">Tempat</th>
                                        <th class="px-2 py-2 text-left border w-20">Tahun</th>
                                        <th class="px-2 py-2 text-left border">Biaya Ditanggung</th>
                                        <th class="px-2 py-2 border w-8"></th>
                                    </tr>
                                </thead>
                                <tbody id="training-body">
                                    @foreach ($profile?->trainings ?? [] as $ti => $tr)
                                        <tr>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="trainings[{{ $ti }}][name]"
                                                    value="{{ $tr->name }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="trainings[{{ $ti }}][organizer]"
                                                    value="{{ $tr->organizer }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="trainings[{{ $ti }}][place]"
                                                    value="{{ $tr->place }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="trainings[{{ $ti }}][year]"
                                                    value="{{ $tr->year }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="trainings[{{ $ti }}][notes]"
                                                    value="{{ $tr->notes }}" placeholder="Perusahaan / Pribadi"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><button type="button"
                                                    onclick="this.closest('tr').remove()"
                                                    class="text-red-500 text-xs">✕</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Language skills --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Penguasaan Bahasa Asing <span
                                    class="text-red-500">*</span></h4>
                            <button type="button" onclick="addLangRow()"
                                class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-2 py-2 text-left border" rowspan="2">Bahasa</th>
                                        <th class="px-2 py-2 text-center border" colspan="4">Tertulis</th>
                                        <th class="px-2 py-2 text-center border" colspan="4">Percakapan</th>
                                        <th class="px-2 py-2 border" rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                            <th class="px-2 py-1 text-center border text-xs font-normal">
                                                {{ $lv }}</th>
                                        @endforeach
                                        @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                            <th class="px-2 py-1 text-center border text-xs font-normal">
                                                {{ $lv }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody id="lang-body">
                                    @foreach ($profile?->languageSkills ?? [] as $li => $ls)
                                        <tr>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="languages[{{ $li }}][language]"
                                                    value="{{ $ls->language }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"
                                                    placeholder="Inggris"></td>
                                            @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                                <td class="border px-1 py-1 text-center"><input type="radio"
                                                        name="languages[{{ $li }}][written_level]"
                                                        value="{{ $lv }}" @checked($ls->written_level === $lv)>
                                                </td>
                                            @endforeach
                                            @foreach (['S. Baik', 'Baik', 'Cukup', 'Kurang'] as $lv)
                                                <td class="border px-1 py-1 text-center"><input type="radio"
                                                        name="languages[{{ $li }}][spoken_level]"
                                                        value="{{ $lv }}" @checked($ls->spoken_level === $lv)>
                                                </td>
                                            @endforeach
                                            <td class="border px-1 py-1"><button type="button"
                                                    onclick="this.closest('tr').remove()"
                                                    class="text-red-500 text-xs">✕</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Essay questions C --}}
                    <div class="space-y-4 border-t pt-4">
                        <h4 class="font-semibold text-gray-700 text-sm">Pertanyaan Pendidikan <span
                                class="text-red-500">*</span></h4>
                        @php $essayFields = [['why_chose_major', 'Mengapa Saudara memilih pendidikan / jurusan tersebut?'], ['best_education', 'Di pendidikan manakah Saudara paling puas dengan prestasi Saudara? Mengapa?'], ['worst_education', 'Di pendidikan manakah Saudara paling tidak puas? Mengapa?'], ['karya_ilmiah', 'Karya Ilmiah Saudara (skripsi, artikel, buku, dll.)'], ['favorite_subject', 'Mata pelajaran yang paling disukai? Berapa nilai rata-rata?'], ['education_funder', 'Siapa yang selama ini membiayai pendidikan Saudara?']]; @endphp
                        @foreach ($essayFields as [$field, $label])
                            <div>
                                <label class="field-label">{{ $label }}</label>
                                <textarea name="essay[{{ $field }}]" rows="2" class="field-input">{{ old("essay.$field", $essay?->$field) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB D — PEKERJAAN --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-d" class="tab-panel hidden p-6 space-y-6">
                    <h3 class="text-base font-bold text-indigo-700">D. Riwayat Pekerjaan</h3>

                    @php
                        // Cast to int to avoid "0" string being truthy in PHP.
                        // Default: fresh_grad only if user previously saved it as 1 on profile.
                        // If no saved value and no work experience, still default to NOT fresh grad
                        // so the work experience essay questions are visible unless user opts out.
                        $freshGradSaved = $profile?->fresh_graduate ?? null;
                        $isFreshGrad = (int) old('fresh_graduate', $freshGradSaved ?? 0) === 1;
                    @endphp

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-700 text-sm">Riwayat Pekerjaan <span
                                    class="text-red-500">*</span></h4>
                            <a href="{{ route('applicant.work.index') }}"
                                class="text-xs bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">+
                                Tambah / Kelola</a>
                        </div>
                        @if ($profile?->workExperiences->count())
                            <div class="space-y-3 mb-3">
                                @foreach ($profile->workExperiences as $w)
                                    <div class="border border-gray-200 rounded-lg p-3 text-sm">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-gray-800">{{ $w->company }}</span>
                                            <span class="text-xs text-gray-400">{{ $w->start_date?->format('Y') }} –
                                                {{ $w->end_date?->format('Y') ?? 'Skr' }}</span>
                                        </div>
                                        <p class="text-gray-600 text-xs mt-0.5">{{ $w->position }}
                                            {{ $w->company_city ? '· ' . $w->company_city : '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic mb-3">Belum ada pengalaman kerja. <a
                                    href="{{ route('applicant.work.index') }}"
                                    class="text-indigo-600 hover:underline">Tambah di sini</a>.</p>
                        @endif

                        {{-- Fresh graduate toggle — always visible --}}
                        <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
                            <input type="hidden" name="fresh_graduate" value="0">
                            <input type="checkbox" name="fresh_graduate" value="1" id="fresh-grad-check"
                                @checked($isFreshGrad) onchange="toggleWorkEssays(this.checked)"
                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                            <label for="fresh-grad-check" class="text-sm text-blue-800 font-medium">
                                Saya Fresh Graduate / tidak memiliki pengalaman kerja yang relevan
                            </label>
                        </div>
                    </div>

                    {{-- Essay D — shown when NOT fresh graduate --}}
                    <div id="work-exp-essays" class="{{ $isFreshGrad ? 'hidden' : '' }} space-y-4 border-t pt-4">
                        <h4 class="font-semibold text-gray-700 text-sm">Pertanyaan Pengalaman Kerja <span
                                class="text-red-500">*</span></h4>
                        @php $workEssays = [['brief_job_description', 'Uraian singkat dari 2 jabatan terakhir yang Saudara jabat'], ['supervisor_detail', 'Siapa yang menjadi atasan Saudara?'], ['subordinate_detail', 'Berapa banyak bawahan Saudara?'], ['changes_made', 'Pernahkah melakukan perubahan / pembaharuan di perusahaan terdahulu? Perubahan apa?'], ['job_satisfaction', 'Puaskah terhadap kemajuan di pekerjaan terdahulu? Mengapa?'], ['changes_motivation', 'Apa yang paling mendorong Saudara sampai pada taraf kemajuan seperti sekarang?'], ['decision_approach', 'Bila menghadapi persoalan dalam pekerjaan, apa yang Saudara lakukan?'] ]; @endphp
                        @foreach ($workEssays as [$field, $label])
                            <div>
                                <label class="field-label">{{ $label }}</label>
                                <textarea name="essay[{{ $field }}]" rows="2" class="field-input">{{ old("essay.$field", $essay?->$field) }}</textarea>
                            </div>
                        @endforeach
                    </div>

                    {{-- Essay D — for everyone --}}
                    <div class="space-y-4 border-t pt-4">
                        <h4 class="font-semibold text-gray-700 text-sm">Pertanyaan Umum <span
                                class="text-red-500">*</span></h4>
                        @php $generalEssays = [['problems_faced', 'Masalah-masalah penting yang pernah dihadapi dan bagaimana mengatasinya?'], ['motivational_driver', 'Menurut pendapat Saudara, apa dan siapa yang paling utama mendorong Saudara sampai pada taraf kemajuan seperti sekarang?'], ['decision_making', 'Bila menghadapi persoalan dalam pekerjaan dan harus mengambil keputusan, apa yang Saudara lakukan?'],['who_you_consult', 'Bila menghadapi persoalan pribadi / pekerjaan, dengan siapa biasanya Saudara berunding?']]; @endphp
                        @foreach ($generalEssays as [$field, $label])
                            <div>
                                <label class="field-label">{{ $label }}</label>
                                <textarea name="essay[{{ $field }}]" rows="2" class="field-input">{{ old("essay.$field", $essay?->$field) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB E — MINAT & KONSEP PRIBADI --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-e" class="tab-panel hidden p-6 space-y-6">
                    <h3 class="text-base font-bold text-indigo-700">E. Minat dan Konsep Pribadi</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Gaji Minimal yang Diinginkan (Rp) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="expected_salary" min="0"
                                value="{{ old('expected_salary', $profile?->expected_salary) }}"
                                placeholder="mis. 5000000"
                                class="field-input @error('expected_salary') border-red-400 @enderror" required>
                            @error('expected_salary')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="field-label">Kapan Dapat Mulai Bekerja? <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="available_start_date"
                                value="{{ old('available_start_date', $profile?->available_start_date?->format('Y-m-d')) }}"
                                class="field-input @error('available_start_date') border-red-400 @enderror" required>
                            @error('available_start_date')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Fasilitas yang Diinginkan di Samping Gaji <span
                                    class="text-red-500">*</span></label>
                            <textarea name="desired_facilities" rows="2" class="field-input"
                                placeholder="mis. Tunjangan transport, BPJS, uang makan">{{ old('desired_facilities', $profile?->desired_facilities) }}</textarea>
                        </div>
                    </div>

                    {{-- Job type ranking — drag to reorder --}}
                    <div>
                        <label class="field-label mb-1">Ranking Jenis Pekerjaan
                            <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-400 mb-3">
                            Drag / geser baris untuk mengurutkan dari yang paling disukai (atas = urutan 1).
                        </p>

                        @php
                            // Build ordered list: saved preferences first (sorted by rank), then remaining
                            $orderedTypes = collect($jobTypes)
                                ->sortBy(function ($jt) use ($savedPrefs) {
                                    return $savedPrefs[$jt]?->rank_order ?? 999;
                                })
                                ->values()
                                ->all();
                        @endphp

                        <ul id="job-rank-list" class="space-y-1.5 select-none max-w-md">
                            @foreach ($orderedTypes as $jt)
                                <li class="job-rank-item flex items-center gap-3 bg-white border border-gray-200
                                           rounded-lg px-4 py-2.5 cursor-grab active:cursor-grabbing
                                           hover:border-indigo-300 hover:shadow-sm transition"
                                    data-job="{{ $jt }}">
                                    {{-- drag handle --}}
                                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M7 2a2 2 0 110 4 2 2 0 010-4zm6 0a2 2 0 110 4 2 2 0 010-4zM7 8a2 2 0 110 4 2 2 0 010-4zm6 0a2 2 0 110 4 2 2 0 010-4zM7 14a2 2 0 110 4 2 2 0 010-4zm6 0a2 2 0 110 4 2 2 0 010-4z" />
                                    </svg>
                                    {{-- rank badge --}}
                                    <span
                                        class="rank-badge inline-flex items-center justify-center w-6 h-6
                                                 rounded-full bg-indigo-600 text-white text-xs font-bold flex-shrink-0">
                                    </span>
                                    {{-- label --}}
                                    <span class="text-sm text-gray-700 font-medium">{{ $jt }}</span>
                                    {{-- hidden input (value updated by JS) --}}
                                    <input type="hidden" name="job_pref[{{ $jt }}]"
                                        class="job-rank-hidden">
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Essay E --}}
                    <div class="space-y-4 border-t pt-4">
                        <h4 class="font-semibold text-gray-700 text-sm">Pertanyaan Minat <span
                                class="text-red-500">*</span></h4>
                        @php $mintEssays = [['why_apply_here', 'Mengapa Saudara ingin bekerja di perusahaan kami?'], ['company_knowledge', 'Apa yang Saudara ketahui mengenai perusahaan kami?'], ['why_2_preferences', 'Mengapa Saudara memilih 2 urutan teratas pada ranking pekerjaan di atas?'], ['plan_for_position', 'Apa yang Saudara lakukan untuk dapat menduduki jabatan yang diinginkan?'], ['preferred_environment', 'Lingkungan pekerjaan yang disenangi (pabrik, kantor, lapangan, laboratorium)? Mengapa?'], ['disliked_environment', 'Lingkungan pekerjaan yang tidak disenangi? Mengapa?'], ['preferred_person_type', 'Tipe orang yang paling Saudara senangi?'], ['disliked_person_type', 'Tipe orang yang tidak Saudara senangi?'], ['difficult_decisions', 'Terhadap hal-hal apakah Saudara paling sulit mengambil keputusan? Mengapa?']]; @endphp
                        @foreach ($mintEssays as [$field, $label])
                            <div>
                                <label class="field-label">{{ $label }}</label>
                                <textarea name="essay[{{ $field }}]" rows="2" class="field-input">{{ old("essay.$field", $essay?->$field) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB F — AKTIVITAS SOSIAL --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-f" class="tab-panel hidden p-6 space-y-6">
                    <h3 class="text-base font-bold text-indigo-700">F. Aktivitas Sosial dan Kegiatan Lain</h3>

                    {{-- Company acquaintances --}}
                    <div>
                        <label class="field-label">Apakah Saudara mempunyai kenalan di Perusahaan kami? <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-6 mt-1">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="has_company_acquaintances" value="1"
                                    @checked(old('has_company_acquaintances', $profile?->has_company_acquaintances) == 1)
                                    onchange="document.getElementById('acquaintances-wrap').classList.remove('hidden')">
                                Ya
                            </label>
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="has_company_acquaintances" value="0"
                                    @checked(old('has_company_acquaintances', $profile?->has_company_acquaintances) == 0 ||
                                            $profile?->has_company_acquaintances === null)
                                    onchange="document.getElementById('acquaintances-wrap').classList.add('hidden')">
                                Tidak
                            </label>
                        </div>
                        <div id="acquaintances-wrap"
                            class="{{ $profile?->has_company_acquaintances ? '' : 'hidden' }} mt-2">
                            <label class="field-label">Sebutkan nama dan hubungannya (min. 2 orang)</label>
                            <textarea name="company_acquaintances" rows="3" class="field-input" placeholder="Nama: ..., Hubungan: ...">{{ old('company_acquaintances', $profile?->company_acquaintances) }}</textarea>
                        </div>
                    </div>

                    {{-- References --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Referensi dari Perusahaan Sebelumnya (min.
                                3 orang) <span class="text-red-500">*</span></h4>
                            <button type="button" onclick="addReferenceRow()"
                                class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-2 py-2 text-left border">Nama</th>
                                        <th class="px-2 py-2 text-left border">Jabatan</th>
                                        <th class="px-2 py-2 text-left border">Alamat Kantor</th>
                                        <th class="px-2 py-2 text-left border">No. Telp</th>
                                        <th class="px-2 py-2 text-left border">Hubungan</th>
                                        <th class="px-2 py-2 border w-8"></th>
                                    </tr>
                                </thead>
                                <tbody id="reference-body">
                                    @foreach ($profile?->references ?? [] as $ri => $ref)
                                        <tr>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="references[{{ $ri }}][name]"
                                                    value="{{ $ref->name }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="references[{{ $ri }}][position]"
                                                    value="{{ $ref->position }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="references[{{ $ri }}][work_address]"
                                                    value="{{ $ref->work_address }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="references[{{ $ri }}][phone]"
                                                    value="{{ $ref->phone }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="references[{{ $ri }}][relation]"
                                                    value="{{ $ref->relation }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><button type="button"
                                                    onclick="this.closest('tr').remove()"
                                                    class="text-red-500 text-xs">✕</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Vehicles --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-700 text-sm">Kendaraan Pribadi <span
                                    class="text-red-500">*</span></h4>
                            <button type="button" onclick="addVehicleRow()"
                                class="text-xs bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">+
                                Tambah</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs border border-gray-200 rounded">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-2 py-2 text-left border">Merek / Type Kendaraan</th>
                                        <th class="px-2 py-2 text-left border">CC / Kapasitas</th>
                                        <th class="px-2 py-2 text-left border w-20">Tahun</th>
                                        <th class="px-2 py-2 text-left border w-32">Kepemilikan</th>
                                        <th class="px-2 py-2 border w-8"></th>
                                    </tr>
                                </thead>
                                <tbody id="vehicle-body">
                                    @foreach ($profile?->vehicles ?? [] as $vi => $veh)
                                        <tr>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="vehicles[{{ $vi }}][brand_type]"
                                                    value="{{ $veh->brand_type }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="vehicles[{{ $vi }}][cc]"
                                                    value="{{ $veh->cc }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1"><input type="text"
                                                    name="vehicles[{{ $vi }}][year]"
                                                    value="{{ $veh->year }}"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                                            <td class="border px-1 py-1">
                                                <select name="vehicles[{{ $vi }}][ownership]"
                                                    class="w-full text-xs border-0 focus:ring-1 rounded">
                                                    @foreach (['Pribadi', 'Orang Tua', 'Saudara'] as $own)
                                                        <option value="{{ $own }}"
                                                            @selected($veh->ownership === $own)>{{ $own }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="border px-1 py-1"><button type="button"
                                                    onclick="this.closest('tr').remove()"
                                                    class="text-red-500 text-xs">✕</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Text fields F --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Hobby / Kegemaran <span class="text-red-500">*</span></label>
                            <input type="text" name="hobbies" value="{{ old('hobbies', $profile?->hobbies) }}"
                                class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Cara Mengisi Waktu Luang <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="free_time_activities"
                                value="{{ old('free_time_activities', $profile?->free_time_activities) }}"
                                class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Surat Kabar / Majalah / Buku yang Disukai <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="favorite_reading"
                                value="{{ old('favorite_reading', $profile?->favorite_reading) }}"
                                class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Topik / Pokok yang Paling Disukai <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="favorite_topics"
                                value="{{ old('favorite_topics', $profile?->favorite_topics) }}"
                                class="field-input">
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Perjalanan ke Luar Negeri (kapan dan untuk keperluan apa?) <span
                                    class="text-red-500">*</span></label>
                            <textarea name="international_travel" rows="2" class="field-input"
                                placeholder="mis. 2019 — Singapura untuk konferensi, atau Tidak pernah">{{ old('international_travel', $profile?->international_travel) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Organisasi yang Pernah Diikuti & Jabatan <span
                                    class="text-red-500">*</span></label>
                            <textarea name="organizational_activities" rows="2" class="field-input"
                                placeholder="mis. BEM Universitas (2017–2019) — Ketua Divisi Sosial">{{ old('organizational_activities', $profile?->organizational_activities) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{-- TAB G — LAIN-LAIN --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                <div id="tab-g" class="tab-panel hidden p-6 space-y-4">
                    <h3 class="text-base font-bold text-indigo-700">G. Lain-lain</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Kekuatan / Strengths (mental / psikologis) <span
                                    class="text-red-500">*</span></label>
                            <textarea name="strengths" rows="3" class="field-input">{{ old('strengths', $profile?->strengths) }}</textarea>
                        </div>
                        <div>
                            <label class="field-label">Kelemahan / Weaknesses (mental / psikologis) <span
                                    class="text-red-500">*</span></label>
                            <textarea name="weaknesses" rows="3" class="field-input">{{ old('weaknesses', $profile?->weaknesses) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Pernah sakit yang lama sembuh? Jika pernah, sebutkan <span
                                    class="text-red-500">*</span></label>
                            <textarea name="past_illness" rows="2" class="field-input"
                                placeholder="mis. TBC (2018, sudah sembuh), atau Tidak pernah">{{ old('past_illness', $profile?->past_illness) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Gangguan jasmani tetap / yang kerap mengganggu <span
                                    class="text-red-500">*</span></label>
                            <textarea name="permanent_physical_condition" rows="2" class="field-input"
                                placeholder="mis. Rabun jauh (pakai kacamata), atau Tidak ada">{{ old('permanent_physical_condition', $profile?->permanent_physical_condition) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="field-label">Adakah keluarga yang mendapat gangguan kesehatan atau mental?
                                <span class="text-red-500">*</span></label>
                            <textarea name="family_health_issues" rows="2" class="field-input"
                                placeholder="mis. Tidak ada, atau Kakak (gangguan ginjal)">{{ old('family_health_issues', $profile?->family_health_issues) }}</textarea>
                        </div>
                    </div>

                    {{-- Emergency contact --}}
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-700 text-sm mb-3">Kontak Darurat (tidak tinggal serumah)
                            <span class="text-red-500">*</span>
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="field-label">Nama <span class="text-red-500">*</span></label>
                                <input type="text" name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name', $profile?->emergency_contact_name) }}"
                                    class="field-input @error('emergency_contact_name') border-red-400 @enderror"
                                    required>
                                @error('emergency_contact_name')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="field-label">No. Telepon <span class="text-red-500">*</span></label>
                                <input type="text" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $profile?->emergency_contact_phone) }}"
                                    class="field-input @error('emergency_contact_phone') border-red-400 @enderror"
                                    required>
                                @error('emergency_contact_phone')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="field-label">Hubungan <span class="text-red-500">*</span></label>
                                <input type="text" name="emergency_contact_relation"
                                    value="{{ old('emergency_contact_relation', $profile?->emergency_contact_relation) }}"
                                    placeholder="mis. Ayah, Kakak, Paman"
                                    class="field-input @error('emergency_contact_relation') border-red-400 @enderror"
                                    required>
                                @error('emergency_contact_relation')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Save button --}}
                <div class="px-6 pb-6 flex justify-end gap-3 border-t pt-4">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 font-medium text-sm transition">
                        Simpan Data Diri
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <style>
            .field-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 500;
                color: #374151;
                margin-bottom: 0.375rem;
            }

            .field-input {
                display: block;
                width: 100%;
                border-radius: 0.375rem;
                border: 1px solid #d1d5db;
                box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
                font-size: 0.875rem;
                line-height: 1.5;
                padding: 0.5rem 0.75rem;
                color: #111827;
                background-color: #ffffff;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
                box-sizing: border-box;
            }

            .field-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgb(99 102 241 / 0.15);
            }

            .field-input.border-red-400 {
                border-color: #f87171;
            }

            .field-input[readonly],
            .field-input.cursor-not-allowed {
                background-color: #f9fafb;
                color: #6b7280;
                cursor: not-allowed;
            }

            .field-error {
                display: block;
                color: #ef4444;
                font-size: 0.75rem;
                margin-top: 0.25rem;
            }

            /* Job ranking drag styles */
            .sortable-ghost {
                opacity: 0.4;
                background: #e0e7ff;
                border-color: #6366f1;
            }

            .sortable-chosen {
                background: #f5f3ff;
                border-color: #6366f1;
                box-shadow: 0 4px 12px rgb(99 102 241 / 0.2);
            }

            .sortable-drag {
                opacity: 1 !important;
                box-shadow: 0 8px 24px rgb(0 0 0 / 0.15);
            }

            #job-rank-list .job-rank-item {
                user-select: none;
            }
        </style>
        <script>
            // ── Tab switching ──
            function showTab(id) {
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('border-indigo-600', 'text-indigo-600');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                document.getElementById(id).classList.remove('hidden');
                const btn = document.getElementById('btn-' + id);
                btn.classList.remove('border-transparent', 'text-gray-500');
                btn.classList.add('border-indigo-600', 'text-indigo-600');
            }

            // ── Age from DOB ──
            const dobInput = document.getElementById('dob-input');
            const ageDisplay = document.getElementById('age-display');

            function calcAge(dob) {
                if (!dob) {
                    ageDisplay.textContent = '';
                    return;
                }
                const today = new Date();
                const birth = new Date(dob);
                let age = today.getFullYear() - birth.getFullYear();
                const m = today.getMonth() - birth.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
                ageDisplay.textContent = 'Usia: ' + age + ' tahun (per tahun ini)';
            }
            if (dobInput) {
                dobInput.addEventListener('change', e => calcAge(e.target.value));
                calcAge(dobInput.value);
            }

            // ── Marital since date ──
            function toggleMaritalDate(val) {
                const wrap = document.getElementById('marital-since-wrap');
                const label = document.getElementById('marital-since-label');
                const map = {
                    'Bertunangan': 'Bertunangan sejak',
                    'Menikah': 'Menikah sejak',
                    'Cerai Hidup': 'Bercerai sejak',
                    'Cerai Mati': 'Cerai (pasangan meninggal) sejak'
                };
                if (map[val]) {
                    wrap.classList.remove('hidden');
                    label.textContent = map[val];
                } else {
                    wrap.classList.add('hidden');
                }
            }

            // ── Family rows ──
            let familyIdx =
                {{ count($profile?->immediateFamilyMembers ?? []) + count($profile?->originFamilyMembers ?? []) }};
            const educLevels = @json($educationLevels);

            function addFamilyRow(type) {
                const tbody = document.getElementById(type + '-family-body');
                const idx = familyIdx++;
                const opts = educLevels.map(l => `<option value="${l}">${l}</option>`).join('');
                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <input type="hidden" name="family[${idx}][family_type]" value="${type}">
                    <td class="border px-1 py-1"><input type="text" name="family[${idx}][relation]" class="w-full text-xs border-0 focus:ring-1 rounded" placeholder="${type==='immediate'?'Istri/Suami/Anak':'Ayah/Ibu/Kakak'}"></td>
                    <td class="border px-1 py-1"><input type="text" name="family[${idx}][name]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><select name="family[${idx}][gender]" class="w-full text-xs border-0 focus:ring-1 rounded"><option value="L">L</option><option value="P">P</option></select></td>
                    <td class="border px-1 py-1"><input type="text" name="family[${idx}][place_of_birth]" placeholder="Tempat" class="w-full text-xs border-0 focus:ring-1 rounded mb-1"><input type="date" name="family[${idx}][date_of_birth]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><select name="family[${idx}][education]" class="w-full text-xs border-0 focus:ring-1 rounded"><option value="">-</option>${opts}</select></td>
                    <td class="border px-1 py-1"><input type="text" name="family[${idx}][occupation]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button></td>
                </tr>`);
            }

            // ── Training rows ──
            let trainingIdx = {{ count($profile?->trainings ?? []) }};

            function addTrainingRow() {
                const tbody = document.getElementById('training-body');
                const idx = trainingIdx++;
                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td class="border px-1 py-1"><input type="text" name="trainings[${idx}][name]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="trainings[${idx}][organizer]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="trainings[${idx}][place]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="trainings[${idx}][year]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="trainings[${idx}][notes]" placeholder="Perusahaan / Pribadi" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button></td>
                </tr>`);
            }

            // ── Language rows ──
            let langIdx = {{ count($profile?->languageSkills ?? []) }};
            const levels = ['S. Baik', 'Baik', 'Cukup', 'Kurang'];

            function addLangRow() {
                const tbody = document.getElementById('lang-body');
                const idx = langIdx++;
                const radios = (prefix) => levels.map(l =>
                    `<td class="border px-1 py-1 text-center"><input type="radio" name="languages[${idx}][${prefix}]" value="${l}"></td>`
                ).join('');
                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td class="border px-1 py-1"><input type="text" name="languages[${idx}][language]" class="w-full text-xs border-0 focus:ring-1 rounded" placeholder="Inggris"></td>
                    ${radios('written_level')}
                    ${radios('spoken_level')}
                    <td class="border px-1 py-1"><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button></td>
                </tr>`);
            }

            // ── Reference rows ──
            let refIdx = {{ count($profile?->references ?? []) }};

            function addReferenceRow() {
                const tbody = document.getElementById('reference-body');
                const idx = refIdx++;
                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td class="border px-1 py-1"><input type="text" name="references[${idx}][name]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="references[${idx}][position]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="references[${idx}][work_address]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="references[${idx}][phone]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="references[${idx}][relation]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button></td>
                </tr>`);
            }

            // ── Fresh graduate toggle ──
            function toggleWorkEssays(isFreshGrad) {
                const section = document.getElementById('work-exp-essays');
                if (section) section.classList.toggle('hidden', isFreshGrad);
            }

            // ── Job ranking — SortableJS drag-to-reorder ──
            function updateRankBadges() {
                document.querySelectorAll('#job-rank-list .job-rank-item').forEach((li, i) => {
                    li.querySelector('.rank-badge').textContent = i + 1;
                    li.querySelector('.job-rank-hidden').value = i + 1;
                });
            }
            updateRankBadges(); // set on page load

            // Load SortableJS from CDN then init
            (function() {
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js';
                s.onload = function() {
                    Sortable.create(document.getElementById('job-rank-list'), {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        onEnd: updateRankBadges,
                    });
                };
                document.head.appendChild(s);
            })();

            // ── Vehicle rows ──
            let vehicleIdx = {{ count($profile?->vehicles ?? []) }};

            function addVehicleRow() {
                const tbody = document.getElementById('vehicle-body');
                const idx = vehicleIdx++;
                tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td class="border px-1 py-1"><input type="text" name="vehicles[${idx}][brand_type]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="vehicles[${idx}][cc]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1"><input type="text" name="vehicles[${idx}][year]" class="w-full text-xs border-0 focus:ring-1 rounded"></td>
                    <td class="border px-1 py-1">
                        <select name="vehicles[${idx}][ownership]" class="w-full text-xs border-0 focus:ring-1 rounded">
                            <option>Pribadi</option><option>Orang Tua</option><option>Saudara</option>
                        </select>
                    </td>
                    <td class="border px-1 py-1"><button type="button" onclick="this.closest('tr').remove()" class="text-red-500 text-xs">✕</button></td>
                </tr>`);
            }
        </script>
    @endpush
</x-layouts.applicant>
