<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Rekrutmen') }} – Karir & Lowongan Kerja</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- ─── NAVBAR ──────────────────────────────────────────────────────────── --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2">
                    <img src="/hartonogroup_dark.png" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ auth()->user()->isEmployer() ? route('employer.dashboard') : route('applicant.dashboard') }}"
                            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium text-gray-500 hover:text-red-600 transition px-3 py-1.5">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition px-3 py-1.5">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg transition shadow-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ─── HERO ────────────────────────────────────────────────────────────── --}}
    <section class="bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <p class="text-blue-200 text-sm font-medium uppercase tracking-widest mb-3">Portal Karir Resmi</p>
            <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-4">Temukan Karir<br>Impian Anda</h1>
            <p class="text-blue-100 text-lg max-w-xl mx-auto mb-8">
                Bergabunglah bersama kami dan jadilah bagian dari tim yang terus berkembang.
                Lihat lowongan terbaru dan lamar langsung.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ auth()->user()->isEmployer() ? route('employer.dashboard') : route('applicant.jobs.index') }}"
                        class="inline-block bg-white text-blue-700 font-semibold px-7 py-3 rounded-xl shadow hover:shadow-md transition text-sm">
                        Lihat Semua Lowongan →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-block bg-white text-blue-700 font-semibold px-7 py-3 rounded-xl shadow hover:shadow-md transition text-sm">Daftar
                        Sekarang</a>
                    <a href="{{ route('login') }}"
                        class="inline-block bg-blue-800 hover:bg-blue-900 text-white font-semibold px-7 py-3 rounded-xl transition text-sm">Sudah
                        punya akun? Masuk</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ─── JOB LISTINGS ───────────────────────────────────────────────────── --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Lowongan Terbaru</h2>
                <p class="text-gray-500 text-sm mt-1">Posisi yang sedang dibuka</p>
            </div>
            @auth
                @if (!auth()->user()->isEmployer())
                    <a href="{{ route('applicant.jobs.index') }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">Lihat semua →</a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">Masuk untuk melamar →</a>
            @endauth
        </div>

        @if ($jobs->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="font-medium">Belum ada lowongan yang dibuka</p>
                <p class="text-sm mt-1">Pantau terus halaman ini untuk info lowongan terbaru</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($jobs as $job)
                    <div
                        class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col">
                        <div class="flex items-start justify-between mb-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-xs font-medium px-2.5 py-1 rounded-full
                        {{ $job->employment_type === 'Full Time' ? 'bg-green-100 text-green-700' : ($job->employment_type === 'Magang' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $job->employment_type }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-base leading-tight mb-1">{{ $job->title }}</h3>
                        @if ($job->department)
                            <p class="text-xs text-gray-400 mb-3">{{ $job->department }}</p>
                        @endif
                        <div class="space-y-1.5 mb-4 flex-1">
                            @if ($job->location)
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $job->location }}
                                </div>
                            @endif
                            @if ($job->experience_level)
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    {{ $job->experience_level }}@if ($job->experience_years)
                                        · {{ $job->experience_years }} thn
                                    @endif
                                </div>
                            @endif
                            @if ($job->deadline)
                                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                    <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Deadline: {{ $job->deadline->translatedFormat('d M Y') }}
                                </div>
                            @endif
                        </div>
                        @auth
                            @if (!auth()->user()->isEmployer())
                                <a href="{{ route('applicant.jobs.show', $job) }}"
                                    class="block text-center text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                    Lihat Detail
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                                class="block text-center text-sm font-medium border border-blue-600 text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg transition">
                                Masuk untuk melamar
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ─── FOOTER ──────────────────────────────────────────────────────────── --}}
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div
            class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-400">© {{ date('Y') }} {{ config('app.name', 'Rekrutmen') }}. Hak cipta
                dilindungi.</p>
            @guest
                <div class="flex gap-4 text-sm">
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-blue-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600 transition">Daftar</a>
                </div>
            @endguest
        </div>
    </footer>

</body>

</html>
