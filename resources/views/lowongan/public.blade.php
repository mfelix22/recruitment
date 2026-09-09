<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $jobPosting->title }} – {{ config('app.name', 'Rekrutmen') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($jobPosting->job_description), 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- Navbar (same as welcome) --}}
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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-5">

        <a href="/" class="inline-block text-sm text-gray-400 hover:text-gray-600 transition">
            ← Kembali ke daftar lowongan
        </a>

        {{-- Job header --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-xs text-blue-500 font-medium uppercase tracking-wide mb-1">
                {{ $jobPosting->department ?? 'Umum' }}
            </p>
            <h1 class="text-2xl font-bold text-gray-800">{{ $jobPosting->title }}</h1>
            <p class="text-gray-500 mt-0.5">{{ $jobPosting->position }}</p>

            <div class="flex flex-wrap gap-2 mt-4">
                @if ($jobPosting->employment_type)
                    <span class="bg-blue-50 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                        {{ $jobPosting->employment_type }}
                    </span>
                @endif
                @if ($jobPosting->experience_level)
                    <span class="bg-purple-50 text-purple-700 text-xs px-2.5 py-1 rounded-full font-medium">
                        {{ $jobPosting->experience_level }}
                        @if ($jobPosting->experience_years)
                            • {{ $jobPosting->experience_years }} thn
                        @endif
                    </span>
                @endif
                @if ($jobPosting->min_education)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                        Min. {{ $jobPosting->min_education }}
                    </span>
                @endif
                @if ($jobPosting->location)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                        📍 {{ $jobPosting->location }}
                    </span>
                @endif
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-700 mb-3">Deskripsi Pekerjaan</h2>
            <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ trim($jobPosting->job_description) }}</div>
        </div>

        {{-- Persyaratan --}}
        @if ($jobPosting->requirements)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="font-semibold text-gray-700 mb-3">Persyaratan</h2>
                <ul class="list-disc list-inside text-sm text-gray-600 leading-relaxed space-y-1">
                    @foreach (preg_split('/\r?\n/', $jobPosting->requirements) as $req)
                        @php($req = preg_replace('/^[-•*]\s*/', '', trim($req)))
                        @if ($req !== '')
                            <li>{{ $req }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Info + CTA --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-2 text-sm mb-5">
                @if ($jobPosting->location)
                    <div>
                        <p class="text-xs text-gray-400">Lokasi</p>
                        <p class="text-gray-700">{{ $jobPosting->location }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-xs text-gray-400">Jumlah Posisi</p>
                    <p class="text-gray-700">{{ $jobPosting->open_positions }} orang</p>
                </div>
                @if ($jobPosting->deadline)
                    <div>
                        <p class="text-xs text-gray-400">Batas Lamaran</p>
                        <p class="text-gray-700 font-medium">
                            {{ $jobPosting->deadline->translatedFormat('d F Y') }}
                        </p>
                    </div>
                @endif
            </div>

            @auth
                @if (auth()->user()->isApplicant())
                    <a href="{{ route('applicant.jobs.show', $jobPosting) }}"
                        class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-3 rounded-lg transition">
                        Lamar Sekarang →
                    </a>
                @endif
            @else
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm py-3 rounded-lg transition">
                        Masuk untuk Melamar
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex-1 text-center border border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold text-sm py-3 rounded-lg transition">
                        Daftar Akun Baru
                    </a>
                </div>
            @endauth
        </div>

    </div>

    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-sm text-gray-400">© {{ date('Y') }} {{ config('app.name', 'Rekrutmen') }}. Hak cipta
                dilindungi.</p>
        </div>
    </footer>

</body>

</html>
