<x-layouts.hrd>
    <x-slot name="heading">Supporting File</x-slot>

    <div class="mt-4 space-y-5">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Supporting File / Onboarding Documents</h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola daftar dokumen yang harus diunggah pelamar saat Onboarding
                </p>
            </div>
            <button onclick="openModal('modal-tambah')"
                class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                + Add Data
            </button>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-12">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Description</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Format File</th>
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase w-36">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($documents as $i => $doc)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $doc->description }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($doc->status === 'mandatory')
                                    <span
                                        class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">Mandatory</span>
                                @else
                                    <span
                                        class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">Optional</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="inline-block bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded uppercase">{{ $doc->format_file }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        onclick="openEditModal({{ $doc->id }}, {{ json_encode($doc->description) }}, '{{ $doc->status }}', '{{ $doc->format_file }}', {{ $doc->sort_order }})"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                        Edit
                                    </button>
                                    <form action="{{ route('employer.dokumen.destroy', $doc) }}" method="POST"
                                        onsubmit="return confirm('Hapus dokumen ini? Semua file yang sudah diupload oleh pelamar untuk dokumen ini akan ikut terhapus.')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1.5 rounded font-medium transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-400">
                                Belum ada dokumen. Klik "+ Add Data" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== Modal: Tambah ===== --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-800">Add Supporting Document</h3>
                <button onclick="closeModal('modal-tambah')"
                    class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>
            <form action="{{ route('employer.dokumen.store') }}" method="POST" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Description <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="description" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500"
                        placeholder="e.g. KTP / Kartu Identitas">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Status Type <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="mandatory" checked
                                class="text-red-500 focus:ring-red-400">
                            <span class="text-sm font-medium text-red-600">Mandatory</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="optional"
                                class="text-green-500 focus:ring-green-400">
                            <span class="text-sm font-medium text-green-600">Optional</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Format File <span
                            class="text-red-500">*</span></label>
                    <select name="format_file" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                        @foreach ($formats as $fmt)
                            <option value="{{ $fmt }}" class="uppercase">{{ strtoupper($fmt) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Urutan (Sort Order)</label>
                    <input type="number" name="sort_order" value="0" min="0"
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modal-tambah')"
                        class="text-gray-600 text-sm px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== Modal: Edit ===== --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h3 class="font-semibold text-gray-800">Edit Supporting Document</h3>
                <button onclick="closeModal('modal-edit')"
                    class="text-gray-400 hover:text-gray-600 text-xl leading-none">&times;</button>
            </div>
            <form id="form-edit" action="" method="POST" class="px-6 py-5 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Description <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="edit-description" name="description" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-2">Status Type <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" id="edit-mandatory" name="status" value="mandatory"
                                class="text-red-500 focus:ring-red-400">
                            <span class="text-sm font-medium text-red-600">Mandatory</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" id="edit-optional" name="status" value="optional"
                                class="text-green-500 focus:ring-green-400">
                            <span class="text-sm font-medium text-green-600">Optional</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Format File <span
                            class="text-red-500">*</span></label>
                    <select id="edit-format" name="format_file" required
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                        @foreach ($formats as $fmt)
                            <option value="{{ $fmt }}">{{ strtoupper($fmt) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Urutan (Sort Order)</label>
                    <input type="number" id="edit-sort-order" name="sort_order" min="0"
                        class="w-full rounded-lg border-gray-300 text-sm focus:ring-teal-500 focus:border-teal-500">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modal-edit')"
                        class="text-gray-600 text-sm px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const updateRoute = @json(route('employer.dokumen.update', ['dokumen' => '__ID__']));

            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function openEditModal(id, description, status, formatFile, sortOrder) {
                document.getElementById('edit-description').value = description;
                document.getElementById('edit-sort-order').value = sortOrder;

                // Status radio
                document.getElementById('edit-mandatory').checked = (status === 'mandatory');
                document.getElementById('edit-optional').checked = (status === 'optional');

                // Format file select
                const sel = document.getElementById('edit-format');
                for (let opt of sel.options) {
                    opt.selected = (opt.value === formatFile);
                }

                // Set form action
                document.getElementById('form-edit').action = updateRoute.replace('__ID__', id);

                openModal('modal-edit');
            }

            // Close modals on backdrop click
            ['modal-tambah', 'modal-edit'].forEach(id => {
                document.getElementById(id).addEventListener('click', function(e) {
                    if (e.target === this) closeModal(id);
                });
            });
        </script>
    @endpush
</x-layouts.hrd>
