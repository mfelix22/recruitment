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
                    <p class="text-gray-400 text-xs mt-1">
                        {{ $activeCount > 0 ? $activeCount . ' lamaran sedang diproses' : 'Pantau status lamaran Anda' }}
                    </p>
                </a>
            </div>

            {{-- Status tracker --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Status Lamaran</h3>
                    @if ($applications->isNotEmpty())
                        <a href="{{ route('applicant.applications.index') }}"
                            class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                    @endif
                </div>

                @if ($applications->isEmpty())
                    <div class="px-6 py-10 text-center text-gray-400">
                        <p class="font-medium text-sm">Belum ada lamaran</p>
                        <p class="text-xs mt-1">Mulai lamar lowongan yang tersedia</p>
                        <a href="{{ route('applicant.jobs.index') }}"
                            class="mt-4 inline-block bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                            Lihat Lowongan
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-50">
                        @foreach ($applications as $app)
                            @php
                                $color = $app->status_color;
                                $colorMap = [
                                    'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                    'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                    'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                    'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                                    'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                                    'teal' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700'],
                                    'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                    'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                                ];
                                $badge = $colorMap[$color] ?? $colorMap['gray'];
                            @endphp
                            <a href="{{ route('applicant.applications.show', $app) }}"
                                class="block px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">
                                            {{ $app->jobPosting->title }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $app->jobPosting->position }}
                                            &middot; dilamar {{ $app->created_at->diffForHumans() }}
                                        </p>
                                        @if ($app->status === 'Dipanggil Interview' && $app->interview_at)
                                            <p class="text-xs text-blue-600 mt-1">
                                                Interview: {{ $app->interview_at->translatedFormat('d F Y, H:i') }}
                                                @if ($app->interview_location)
                                                    &middot; {{ $app->interview_location }}
                                                @endif
                                            </p>
                                        @endif

                                        @if (!$app->isFinished())
                                            <div class="mt-3 flex items-center gap-1 max-w-xs">
                                                @foreach (range(1, 7) as $s)
                                                    <div
                                                        class="flex-1 h-1 rounded-full
                                                        {{ $s <= $app->status_step ? 'bg-blue-500' : 'bg-gray-200' }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <span
                                        class="shrink-0 inline-block {{ $badge['bg'] }} {{ $badge['text'] }} text-xs font-medium px-2.5 py-1 rounded-full">
                                        {{ $app->status }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-layouts.applicant>
