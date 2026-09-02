<x-layouts.applicant>
    <x-slot name="heading">Lamaran Saya</x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($applications as $app)
                @php
                    $color = $app->status_color;
                    $colorMap = [
                        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                        'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
                    ];
                    $badge = $colorMap[$color] ?? $colorMap['gray'];
                @endphp
                <a href="{{ route('applicant.applications.show', $app) }}"
                    class="block bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition border border-transparent hover:border-blue-200">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400 mb-0.5">
                                {{ $app->created_at->translatedFormat('d F Y') }}
                            </p>
                            <h3 class="font-semibold text-gray-800 truncate">
                                {{ $app->jobPosting->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $app->jobPosting->position }}</p>

                            {{-- Mini progress bar --}}
                            @if (!$app->isFinished())
                                <div class="mt-3 flex items-center gap-1">
                                    @foreach (range(1, 4) as $s)
                                        <div
                                            class="flex-1 h-1 rounded-full
                                            {{ $s <= $app->status_step ? 'bg-blue-500' : 'bg-gray-200' }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="shrink-0 text-right">
                            <span
                                class="inline-block {{ $badge['bg'] }} {{ $badge['text'] }} text-xs font-medium px-2.5 py-1 rounded-full">
                                {{ $app->status }}
                            </span>
                            <p class="text-xs text-gray-400 mt-2">
                                {{ $app->jobPosting->location ?? '' }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-400">
                    <p class="text-4xl mb-3">📄</p>
                    <p class="font-medium">Belum ada lamaran</p>
                    <p class="text-sm mt-1">Mulai lamar lowongan yang tersedia</p>
                    <a href="{{ route('applicant.jobs.index') }}"
                        class="mt-4 inline-block bg-blue-600 text-white text-sm px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        Lihat Lowongan
                    </a>
                </div>
            @endforelse

            @if ($applications->hasPages())
                <div>{{ $applications->links() }}</div>
            @endif

        </div>
    </div>
</x-layouts.applicant>
