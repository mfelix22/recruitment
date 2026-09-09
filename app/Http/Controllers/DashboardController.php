<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /** HRD dashboard with pipeline stats */
    public function employer()
    {
        $employerId = auth()->id();

        $totalLowongan = JobPosting::where('employer_id', $employerId)->count();
        $lowonganAktif = JobPosting::where('employer_id', $employerId)->active()->count();

        $baseQuery = Application::whereHas(
            'jobPosting',
            fn($q) => $q->where('employer_id', $employerId)
        );

        $totalLamaran = (clone $baseQuery)->count();
        $lamaranBaru  = (clone $baseQuery)->where('status', 'Menunggu')->count();

        // Applications per pipeline stage (ordered by STATUSES)
        $statusCounts = (clone $baseQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusBreakdown = collect(Application::STATUSES)
            ->map(fn($status) => [
                'status' => $status,
                'total'  => (int) ($statusCounts[$status] ?? 0),
            ]);

        // Applications per job posting
        $perLowongan = JobPosting::where('employer_id', $employerId)
            ->withCount([
                'applications',
                'applications as pending_count' => fn($q) => $q->where('status', 'Menunggu'),
            ])
            ->latest()
            ->take(6)
            ->get();

        $lamaranTerbaru = (clone $baseQuery)
            ->with(['applicant', 'jobPosting'])
            ->latest()
            ->limit(5)
            ->get();

        return view('hrd.dashboard', compact(
            'totalLowongan',
            'lowonganAktif',
            'totalLamaran',
            'lamaranBaru',
            'statusBreakdown',
            'perLowongan',
            'lamaranTerbaru',
        ));
    }
}
