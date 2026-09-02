{{-- Shared form fields for Matrix MCU (used in both Tambah and Edit modals) --}}
@php $p = $prefixId ?? ''; @endphp

<div>
    <label class="block text-xs font-medium text-gray-600 mb-1">Kode <span class="text-red-500">*</span></label>
    <input type="text" name="code" data-field="code"
        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
        placeholder="Contoh: GIS-PROD051" required>
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Perusahaan</label>
        <input type="text" name="company" data-field="company"
            class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Contoh: GIS">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Departemen</label>
        <input type="text" name="department" data-field="department"
            class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
            placeholder="Contoh: Production">
    </div>
</div>

<div>
    <label class="block text-xs font-medium text-gray-600 mb-1">Sub-Seksi</label>
    <input type="text" name="sub_section" data-field="sub_section"
        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
        placeholder="Contoh: SECTION B - POWDER COATING">
</div>

<div>
    <label class="block text-xs font-medium text-gray-600 mb-1">Posisi Jabatan <span
            class="text-red-500">*</span></label>
    <input type="text" name="employee_position" data-field="employee_position"
        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
        placeholder="Contoh: FRAME PREPARATION" required>
</div>

<div>
    <label class="block text-xs font-medium text-gray-600 mb-1">Paket MCU <span class="text-red-500">*</span></label>
    <select name="mcu_package_id" data-field="mcu_package_id" required
        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
        <option value="">-- Pilih Paket --</option>
        @foreach ($packages as $pkg)
            <option value="{{ $pkg->id }}">Paket {{ $pkg->code }}</option>
        @endforeach
    </select>
</div>
