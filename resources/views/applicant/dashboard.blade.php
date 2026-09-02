<x-layouts.applicant>
    <x-slot name="heading">Beranda Pelamar</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    Selamat datang, {{ auth()->user()->name }}!
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    Lengkapi profil Anda untuk mulai melamar pekerjaan.
                </p>
            </div>

            {{-- Quick links --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('applicant.profile.edit') }}"
                    class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-blue-500 hover:shadow-md transition">
                    <p class="font-semibold text-gray-800 text-sm">Data Diri</p>
                    <p class="text-gray-400 text-xs mt-1">Lengkapi informasi pribadi Anda</p>
                </a>
                <a href="{{ route('applicant.jobs.index') }}"
                    class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-green-500 hover:shadow-md transition">
                    <p class="font-semibold text-gray-800 text-sm">Lowongan Kerja</p>
                    <p class="text-gray-400 text-xs mt-1">Cari dan lamar pekerjaan</p>
                </a>
                <a href="{{ route('applicant.applications.index') }}"
                    class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-yellow-500 hover:shadow-md transition">
                    <p class="font-semibold text-gray-800 text-sm">Lamaran Saya</p>
                    <p class="text-gray-400 text-xs mt-1">Pantau status lamaran Anda</p>
                </a>
            </div>

        </div>
    </div>
</x-layouts.applicant>
