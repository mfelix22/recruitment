<x-layouts.applicant>
    <x-slot name="heading">{{ $education ? 'Ubah Pendidikan' : 'Tambah Pendidikan' }}</x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">

                <form method="POST"
                    action="{{ $education ? route('applicant.education.update', $education) : route('applicant.education.store') }}">
                    @csrf
                    @if ($education)
                        @method('PUT')
                    @endif

                    <div class="space-y-4">

                        {{-- Level --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenjang Pendidikan <span
                                    class="text-red-500">*</span></label>
                            <select name="level" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('level') border-red-400 @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach ($levels as $l)
                                    <option value="{{ $l }}" @selected(old('level', $education?->level) === $l)>{{ $l }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Institution --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Sekolah / Universitas <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="institution"
                                value="{{ old('institution', $education?->institution) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('institution') border-red-400 @enderror">
                            @error('institution')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Major --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan / Program Studi</label>
                            <input type="text" name="major" value="{{ old('major', $education?->major) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>

                        {{-- Year --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun Masuk <span
                                        class="text-red-500">*</span></label>
                                <input type="number" name="year_start" min="1950" max="{{ date('Y') + 1 }}"
                                    value="{{ old('year_start', $education?->year_start) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm @error('year_start') border-red-400 @enderror">
                                @error('year_start')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                <input type="number" name="year_end" min="1950" max="{{ date('Y') + 1 }}"
                                    value="{{ old('year_end', $education?->year_end) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                                    id="year_end_field">
                                <div class="mt-1 flex items-center gap-2">
                                    <input type="hidden" name="still_studying" value="0">
                                    <input type="checkbox" id="still_studying" name="still_studying" value="1"
                                        @checked(old('still_studying', $education?->still_studying))
                                        onchange="document.getElementById('year_end_field').disabled = this.checked"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="still_studying" class="text-xs text-gray-600">Masih bersekolah /
                                        kuliah</label>
                                </div>
                            </div>
                        </div>

                        {{-- GPA --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">IPK / Nilai Akhir</label>
                            <input type="number" name="gpa" step="0.01" min="0" max="4"
                                value="{{ old('gpa', $education?->gpa) }}" placeholder="mis. 3.50"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                        </div>

                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg">
                            {{ $education ? 'Simpan Perubahan' : 'Tambahkan' }}
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
