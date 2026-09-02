<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light">
    <title>{{ config('app.name') }} - Pelamar</title>
    {{-- Prevent white-flash / paint artifact when OS is in dark mode.
         Must be inline (before any external CSS) so the browser uses
         the correct background from the very first paint. --}}
    <style>
        html {
            background-color: #f9fafb;
            color-scheme: light;
        }

        /* Hide Vite HMR dev overlay & badge (all known selectors) */
        vite-error-overlay,
        #vite-error-overlay,
        .vite-error-overlay,
        vite-plugin-checker-error-overlay,
        #vite-plugin-checker-error-overlay {
            display: none !important;
        }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        {{-- ─── Sidebar ──────────────────────────────────────────────────── --}}
        <aside class="w-60 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 shadow-sm">

            {{-- Logo --}}
            <div class="px-5 py-4 border-b border-gray-100 flex flex-col items-start gap-1">
                <img src="/hartonogroup_dark.png" alt="{{ config('app.name') }}" class="h-9 w-auto object-contain">
                <p class="text-gray-400 text-xs">Portal Karir Pelamar</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">

                {{-- Main --}}
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu Utama</p>

                <a href="{{ route('applicant.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>

                <a href="{{ route('applicant.jobs.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.jobs.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Lowongan Kerja
                </a>

                <a href="{{ route('applicant.applications.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.applications.*') || request()->routeIs('applicant.onboarding.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Lamaran Saya
                </a>

                {{-- Divider --}}
                <div class="pt-4 pb-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3">Profil Saya</p>
                </div>

                <a href="{{ route('applicant.profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.profile.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Diri
                </a>

                <a href="{{ route('applicant.education.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.education.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    Pendidikan
                </a>

                <a href="{{ route('applicant.work.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('applicant.work.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Pengalaman Kerja
                </a>

            </nav>

            {{-- User info --}}
            <div class="px-4 py-4 border-t border-gray-100">
                <p class="text-sm font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Pelamar</p>
            </div>
        </aside>

        {{-- ─── Main Content ─────────────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between flex-shrink-0">
                <div class="text-lg font-semibold text-gray-800">
                    {{ $heading ?? 'Dashboard' }}
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash messages --}}
            @if (session('success') || session('error'))
                <div class="px-6 pt-4">
                    @if (session('success'))
                        <div
                            class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm mb-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm mb-2">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
