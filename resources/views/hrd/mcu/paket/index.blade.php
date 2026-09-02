<x-layouts.hrd>
    <x-slot name="heading">Paket MCU</x-slot>
    <div class="space-y-5">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Package List MCU</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola item pemeriksaan dan paket MCU</p>
            </div>
            <button onclick="openModal('modal-tambah')"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Item
            </button>
        </div>

        {{-- Flash --}}
        {{-- @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif --}}

        {{-- Nav MCU --}}
        <div class="flex gap-2">
            <a href="{{ route('employer.mcu.paket.index') }}"
                class="bg-blue-600 text-white text-sm px-4 py-1.5 rounded-lg font-medium">
                Package List
            </a>
            <a href="{{ route('employer.mcu.matrix.index') }}"
                class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm px-4 py-1.5 rounded-lg">
                Matrix MCU
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-10">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Deskripsi
                            Pemeriksaan
                        </th>
                        @foreach ($packages as $pkg)
                            <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase">
                                Paket {{ $pkg->code }}
                            </th>
                        @endforeach
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $i => $item)
                        @php $itemPackageIds = $item->packages->pluck('id')->toArray(); @endphp
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $item->description }}</td>
                            @foreach ($packages as $pkg)
                                <td class="px-3 py-3 text-center">
                                    @if (in_array($pkg->id, $itemPackageIds))
                                        <span class="text-green-500 text-lg font-bold">✓</span>
                                    @else
                                        <span class="text-red-400 text-lg">✕</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->description) }}', {{ json_encode($itemPackageIds) }})"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('employer.mcu.paket.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Hapus item ini?')">
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
                            <td colspan="{{ $packages->count() + 3 }}" class="px-4 py-10 text-center text-gray-400">
                                Belum ada item pemeriksaan. Klik "Tambah Item" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Tambah --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Tambah Item MCU</h3>
                <button onclick="closeModal('modal-tambah')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form action="{{ route('employer.mcu.paket.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Pemeriksaan</label>
                    <input type="text" name="description" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Physical Conditions">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Termasuk dalam Paket</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($packages as $pkg)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="packages[]" value="{{ $pkg->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Paket {{ $pkg->code }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
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

    {{-- Modal: Edit --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Edit Item MCU</h3>
                <button onclick="closeModal('modal-edit')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <form id="form-edit" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Deskripsi Pemeriksaan</label>
                    <input type="text" id="edit-description" name="description" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Termasuk dalam Paket</label>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($packages as $pkg)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="packages[]" value="{{ $pkg->id }}"
                                    data-pkg-id="{{ $pkg->id }}"
                                    class="edit-pkg-check rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Paket {{ $pkg->code }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
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

        function openEditModal(itemId, description, packageIds) {
            document.getElementById('edit-description').value = description;
            document.getElementById('form-edit').action = '/hrd/mcu/paket/' + itemId;

            document.querySelectorAll('.edit-pkg-check').forEach(cb => {
                cb.checked = packageIds.includes(parseInt(cb.dataset.pkgId));
            });

            openModal('modal-edit');
        }
        // Close modal on backdrop click
        ['modal-tambah', 'modal-edit'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) closeModal(id);
            });
        });
    </script>
</x-layouts.hrd>
