<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Carbon\Carbon;
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

        // Calendar events: interviews + job deadlines this month
        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $events = collect();

        (clone $baseQuery)
            ->whereNotNull('interview_at')
            ->whereBetween('interview_at', [$monthStart, $monthEnd->copy()->endOfDay()])
            ->with(['applicant:id,name', 'jobPosting:id,title'])
            ->get()
            ->each(fn($i) => $events->push([
                'date'  => $i->interview_at,
                'type'  => 'interview',
                'label' => $i->applicant->name,
                'sub'   => $i->jobPosting->title,
                'time'  => $i->interview_at->format('H:i'),
                'url'   => route('employer.applications.show', $i),
            ]));

        JobPosting::where('employer_id', $employerId)
            ->whereNotNull('deadline')
            ->whereBetween('deadline', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->get()
            ->each(fn($j) => $events->push([
                'date'  => $j->deadline,
                'type'  => 'deadline',
                'label' => $j->title,
                'sub'   => 'Batas pendaftaran',
                'time'  => null,
                'url'   => route('employer.lowongan.edit', $j),
            ]));

        $byDate = $events->groupBy(fn($e) => $e['date']->toDateString());

        // Build weeks (Monday-first grid covering the whole month)
        $calendar = [];
        $cursor   = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $lastDay  = $monthEnd->copy()->endOfWeek(Carbon::MONDAY);

        while ($cursor <= $lastDay) {
            $week = [];
            for ($d = 0; $d < 7; $d++) {
                $week[] = [
                    'date'    => $cursor->copy(),
                    'inMonth' => $cursor->month === $monthStart->month,
                    'isToday' => $cursor->isToday(),
                    'events'  => $byDate->get($cursor->toDateString(), collect()),
                ];
                $cursor->addDay();
            }
            $calendar[] = $week;
        }

        // Agenda: today + next 7 days
        $agenda = $events
            ->filter(fn($e) => $e['date']->isToday()
                || $e['date']->between(now(), now()->addDays(7)->endOfDay()))
            ->sortBy('date')
            ->values();

        return view('hrd.dashboard', compact(
            'totalLowongan',
            'lowonganAktif',
            'totalLamaran',
            'lamaranBaru',
            'statusBreakdown',
            'perLowongan',
            'lamaranTerbaru',
            'calendar',
            'agenda',
        ));
    }

    /** Applicant dashboard with application status tracker */
    public function applicant()
    {
        $user = auth()->user();

        $applications = $user->applications()
            ->with('jobPosting')
            ->latest()
            ->take(4)
            ->get();

        $activeCount = $user->applications()
            ->whereIn('status', Application::ACTIVE_STATUSES)
            ->count();

        return view('applicant.dashboard', compact('applications', 'activeCount'));
    }
}
