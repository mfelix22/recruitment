{{--
    Shared form partial for create/edit lowongan.
    Variables: $job (nullable), $action, $method, $educationLevels, $experienceLevels, $employmentTypes
--}}
<div class="space-y-6">

    {{-- Row 1: Judul & Posisi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Judul Lowongan <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}"
                placeholder="cth. Staf IT Jaringan"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-400 @enderror"
                required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi Spesifik</label>
            <input type="text" name="position" value="{{ old('position', $job->position ?? '') }}"
                placeholder="cth. Network Engineer"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    {{-- Row 2: Departemen & Lokasi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Departemen</label>
            <input type="text" name="department" value="{{ old('department', $job->department ?? '') }}"
                placeholder="cth. Teknologi Informasi"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kerja</label>
            <input type="text" name="location" value="{{ old('location', $job->location ?? '') }}"
                placeholder="cth. Jakarta Selatan"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    {{-- Row 3: Kualifikasi Pendidikan & Tingkat Pengalaman --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Minimum</label>
            <select name="min_education"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih jenjang --</option>
                @foreach ($educationLevels as $level)
                    <option value="{{ $level }}"
                        {{ old('min_education', $job->min_education ?? '') === $level ? 'selected' : '' }}>
                        {{ $level }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Pengalaman</label>
            <select name="experience_level"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Pilih tingkat --</option>
                @foreach ($experienceLevels as $lvl)
                    <option value="{{ $lvl }}"
                        {{ old('experience_level', $job->experience_level ?? '') === $lvl ? 'selected' : '' }}>
                        {{ $lvl }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Row 4: Pengalaman (tahun) & Jenis Pekerjaan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman (Tahun)</label>
            <input type="text" name="experience_years"
                value="{{ old('experience_years', $job->experience_years ?? '') }}"
                placeholder="cth. 1-2 tahun, Tidak diperlukan"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jenis Pekerjaan <span class="text-red-500">*</span>
            </label>
            <select name="employment_type" required
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 @error('employment_type') border-red-400 @enderror">
                @foreach ($employmentTypes as $type)
                    <option value="{{ $type }}"
                        {{ old('employment_type', $job->employment_type ?? 'Full Time') === $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
            @error('employment_type')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Row 5: Jumlah Posisi & Batas Waktu --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Jumlah Posisi Tersedia <span class="text-red-500">*</span>
            </label>
            <input type="number" name="open_positions" min="1"
                value="{{ old('open_positions', $job->open_positions ?? 1) }}"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 @error('open_positions') border-red-400 @enderror"
                required>
            @error('open_positions')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Pendaftaran</label>
            <input type="date" name="deadline"
                value="{{ old('deadline', isset($job->deadline) ? $job->deadline->format('Y-m-d') : '') }}"
                class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
            <p class="text-gray-400 text-xs mt-1">Kosongkan jika tidak ada batas waktu.</p>
        </div>
    </div>

    {{-- Deskripsi Pekerjaan --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Deskripsi Jabatan <span class="text-red-500">*</span>
        </label>
        <textarea name="job_description" rows="6" required
            placeholder="Tuliskan tugas dan tanggung jawab pemegang jabatan ini..."
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 @error('job_description') border-red-400 @enderror">{{ old('job_description', $job->job_description ?? '') }}</textarea>
        @error('job_description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Persyaratan --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Persyaratan</label>
        <textarea name="requirements" rows="4" placeholder="Tuliskan persyaratan khusus yang dibutuhkan..."
            class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">{{ old('requirements', $job->requirements ?? '') }}</textarea>
    </div>

    {{-- Status Aktif --}}
    <div class="flex items-center gap-3">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1"
            {{ old('is_active', $job->is_active ?? true) ? 'checked' : '' }}
            class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="is_active" class="text-sm text-gray-700">
            Publikasikan lowongan ini (tampil di daftar lowongan)
        </label>
    </div>

    {{-- Buttons --}}
    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
            {{ $submitLabel ?? 'Simpan' }}
        </button>
        <a href="{{ route('employer.lowongan.index') }}" class="text-sm text-gray-600 hover:text-gray-800 px-4 py-2.5">
            Batal
        </a>
    </div>

</div>
