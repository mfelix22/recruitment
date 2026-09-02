<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light">
    <title>{{ config('app.name') }} - HRD</title>
    {{-- Prevent white-flash / paint artifact when OS is in dark mode --}}
    <style>
        html {
            background-color: #f1f5f9;
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

<body class="font-sans antialiased bg-gray-100">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        <aside class="w-64 bg-blue-800 text-white flex flex-col flex-shrink-0">
            <div class="px-6 py-5 border-b border-blue-700 flex flex-col items-start gap-2">
                <img src="/hartonogroup.png" alt="{{ config('app.name') }}" class="h-10 w-auto object-contain">
                <p class="text-blue-300 text-xs">Panel HRD</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('employer.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.dashboard') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Beranda
                </a>

                <a href="{{ route('employer.lowongan.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.lowongan.*') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kelola Lowongan
                </a>

                <a href="{{ route('employer.applications.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.applications.index') || request()->routeIs('employer.applications.show') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Data Pelamar
                </a>

                <a href="{{ route('employer.applications.kanban') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.applications.kanban') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                    Kanban
                </a>

                <a href="{{ route('employer.mcu.paket.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.mcu.*') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    MCU
                </a>

                <a href="{{ route('employer.dokumen.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                      {{ request()->routeIs('employer.dokumen.*') ? 'bg-blue-600 text-white' : 'text-blue-100 hover:bg-blue-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Supporting File
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-blue-700">
                <p class="text-blue-200 text-xs truncate">{{ auth()->user()->name }}</p>
                <p class="text-blue-400 text-xs mt-0.5">HRD Panel</p>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top bar --}}
            <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between flex-shrink-0">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $heading ?? 'Dashboard HRD' }}
                </h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</span>
                    <span class="text-gray-300">|</span>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 font-medium">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Flash messages --}}
            <div class="px-6 pt-4">
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm mb-4">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto px-6 pb-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
