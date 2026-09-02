<x-layouts.hrd>
    <x-slot name="heading">Ubah Lowongan</x-slot>

    <div class="mt-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('employer.lowongan.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h3 class="text-lg font-semibold text-gray-800">{{ $job->title }}</h3>
            </div>

            <form method="POST" action="{{ route('employer.lowongan.update', $job) }}">
                @csrf
                @method('PUT')

                @include('hrd.lowongan._form', [
                    'job' => $job,
                    'educationLevels' => $educationLevels,
                    'experienceLevels' => $experienceLevels,
                    'employmentTypes' => $employmentTypes,
                    'submitLabel' => 'Simpan Perubahan',
                ])
            </form>

        </div>
    </div>
</x-layouts.hrd>
