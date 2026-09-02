<x-layouts.hrd>
    <x-slot name="heading">Matrix MCU</x-slot>
    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Matrix MCU</h1>
                <p class="text-sm text-gray-500 mt-0.5">Mapping posisi jabatan ke paket MCU yang sesuai</p>
            </div>
            <button onclick="openModal('modal-tambah')"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Nav MCU --}}
        <div class="flex gap-2">
            <a href="{{ route('employer.mcu.paket.index') }}"
                class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm px-4 py-1.5 rounded-lg">
                Package List
            </a>
            <a href="{{ route('employer.mcu.matrix.index') }}"
                class="bg-blue-600 text-white text-sm px-4 py-1.5 rounded-lg font-medium">
                Matrix MCU
            </a>
        </div>

        {{-- Search --}}
        <form method="GET" class="flex gap-3">
            <input type="text" name="cari" value="{{ request('cari') }}"
                placeholder="Cari kode, departemen, atau posisi..."
                class="flex-1 rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
            <button type="submit"
                class="bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700">Cari</button>
            @if (request('cari'))
                <a href="{{ route('employer.mcu.matrix.index') }}"
                    class="text-sm text-gray-400 hover:text-gray-600 self-center">Reset</a>
            @endif
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-10">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kode</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Perusahaan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Departemen</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Sub-Seksi</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Posisi Jabatan
                        </th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Paket</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($matrices as $i => $row)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 text-gray-400">{{ $matrices->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-blue-600">{{ $row->code }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row->company ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row->department ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $row->sub_section ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700 font-medium uppercase text-xs">
                                {{ $row->employee_position }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                    {{ $row->package?->code ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        onclick="openEditModal(
                                        {{ $row->id }},
                                        '{{ addslashes($row->code) }}',
                                        '{{ addslashes($row->company) }}',
                                        '{{ addslashes($row->department) }}',
                                        '{{ addslashes($row->sub_section) }}',
                                        '{{ addslashes($row->employee_position) }}',
                                        {{ $row->mcu_package_id ?? 'null' }}
                                    )"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('employer.mcu.matrix.destroy', $row) }}" method="POST"
                                        onsubmit="return confirm('Hapus entri ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-400">
                                Belum ada data matrix. Klik "Tambah Data" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($matrices->hasPages())
            <div>{{ $matrices->links() }}</div>
        @endif
    </div>

    {{-- ─── Modal Tambah ─── --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Tambah Matrix MCU</h3>
                <button onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form action="{{ route('employer.mcu.matrix.store') }}" method="POST" class="space-y-3">
                @csrf
                @include('hrd.mcu.matrix._form')
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modal-tambah')"
                        class="border border-gray-200 text-gray-600 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Modal Edit ─── --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Edit Matrix MCU</h3>
                <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form id="form-edit" method="POST" class="space-y-3">
                @csrf @method('PUT')
                @include('hrd.mcu.matrix._form', ['prefixId' => 'edit-'])
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modal-edit')"
                        class="border border-gray-200 text-gray-600 text-sm px-4 py-2 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-medium px-5 py-2 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openEditModal(id, code, company, department, subSection, position, pkgId) {
            const f = document.getElementById('form-edit');
            f.action = '/hrd/mcu/matrix/' + id;
            f.querySelector('[data-field="code"]').value = code;
            f.querySelector('[data-field="company"]').value = company;
            f.querySelector('[data-field="department"]').value = department;
            f.querySelector('[data-field="sub_section"]').value = subSection;
            f.querySelector('[data-field="employee_position"]').value = position;
            f.querySelector('[data-field="mcu_package_id"]').value = pkgId || '';
            openModal('modal-edit');
        }

        ['modal-tambah', 'modal-edit'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) closeModal(id);
            });
        });
    </script>
</x-layouts.hrd>
