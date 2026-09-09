<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\SupportingDocument;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\OnboardingInvitationMail;
use App\Mail\InterviewInvitationMail;
use App\Http\Controllers\McuResultController;
use App\Exports\ApplicationsExport;
use App\Notifications\ApplicationStatusUpdated;
use App\Notifications\NewApplicationReceived;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /** Applicant: list own applications */
    public function index()
    {
        $applications = Application::where('applicant_id', Auth::id())
            ->with('jobPosting.employer')
            ->latest()
            ->paginate(10);

        return view('applicant.lamaran.index', compact('applications'));
    }

    /** Applicant: view one application detail */
    public function show(Application $application)
    {
        $this->authorize('view', $application);

        $application->load('jobPosting');

        return view('applicant.lamaran.show', compact('application'));
    }

    /** Applicant: submit application */
    public function store(Request $request, JobPosting $jobPosting)
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->applicantProfile;

        // Check profile completeness inline — stay on the job page
        if (! $profile || ! $profile->isComplete()) {
            $missing = [];
            if (! $profile || ! $profile->blood_type)             $missing[] = 'golongan darah';
            if (! $profile || ! $profile->emergency_contact_name) $missing[] = 'kontak darurat';
            if (! $profile || ! $profile->address()->exists())     $missing[] = 'alamat tinggal';
            if (! $profile || ! $profile->educations()->exists())  $missing[] = 'riwayat pendidikan';

            $list = implode(', ', $missing);
            return back()->with('error', 'Profil belum lengkap. Silakan isi: ' . $list . ' di halaman Data Diri sebelum melamar.');
        }

        $alreadyApplied = $jobPosting->applications()
            ->where('applicant_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Anda sudah melamar untuk lowongan ini.');
        }

        $validated = $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:2000'],
        ]);

        $application = Application::create([
            'applicant_id'   => Auth::id(),
            'job_posting_id' => $jobPosting->id,
            'cover_letter'   => $validated['cover_letter'] ?? null,
            'status'         => 'Menunggu',
        ]);

        try {
            $jobPosting->loadMissing('employer');
            $jobPosting->employer?->notify(new NewApplicationReceived($application->load('applicant', 'jobPosting')));
        } catch (\Exception $e) {
            logger()->error('New application notification failed: ' . $e->getMessage());
        }

        return redirect()->route('applicant.applications.index')
            ->with('success', 'Lamaran berhasil dikirim! Kami akan menghubungi Anda.');
    }

    /** Applicant: withdraw own application (before it enters interview stage) */
    public function withdraw(Application $application)
    {
        $this->authorize('withdraw', $application);

        if (! in_array($application->status, ['Menunggu', 'Sedang Ditinjau'], true)) {
            return back()->with('error', 'Lamaran tidak dapat dibatalkan karena sudah diproses lebih lanjut.');
        }

        $application->delete();

        return redirect()->route('applicant.applications.index')
            ->with('success', 'Lamaran berhasil dibatalkan.');
    }

    // ─── HRD methods ──────────────────────────────────────────────────────────

    /** HRD: list all incoming applications */
    public function employerIndex(Request $request)
    {
        $query = Application::whereHas('jobPosting', function ($q) {
            $q->where('employer_id', Auth::id());
        })->with(['applicant.applicantProfile', 'jobPosting'])->latest();

        if ($request->filled('lowongan')) {
            $query->where('job_posting_id', $request->lowongan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15)->withQueryString();

        $myJobs = JobPosting::where('employer_id', Auth::id())
            ->pluck('title', 'id');

        $statuses = Application::STATUSES;

        return view('hrd.lamaran.index', compact('applications', 'myJobs', 'statuses'));
    }

    /** HRD: export applications to Excel (respects current filters) */
    public function exportExcel(Request $request)
    {
        $filename = 'lamaran-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new ApplicationsExport(
                employerId: Auth::id(),
                jobPostingId: $request->filled('lowongan') ? (int) $request->lowongan : null,
                status: $request->filled('status') ? $request->status : null,
            ),
            $filename
        );
    }

    /** HRD: view applicant detail */
    public function employerShow(Application $application)
    {
        $this->authorize('viewEmployer', $application);

        $application->load([
            'applicant.applicantProfile.address',
            'applicant.applicantProfile.educations',
            'applicant.applicantProfile.workExperiences',
            'jobPosting',
            'mcuResult.package',
            'applicantDocuments.supportingDocument',
        ]);

        return view('hrd.lamaran.show', compact('application'));
    }

    /** HRD: update application status */
    public function updateStatus(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status'             => ['required', 'in:' . implode(',', Application::STATUSES)],
            'employer_notes'     => ['nullable', 'string', 'max:1000'],
            'interview_at'       => ['nullable', 'date'],
            'interview_mode'     => ['nullable', 'in:online,offline'],
            'interview_location' => ['nullable', 'string', 'max:500'],
            'interview_notes'    => ['nullable', 'string', 'max:1000'],
        ]);

        if (! array_key_exists('interview_mode', $validated)) {
            $validated['interview_mode'] = $application->interview_mode ?? 'offline';
        }

        $application->update($validated);

        // Auto-assign MCU package when status moves to Menunggu MCU
        if ($validated['status'] === 'Menunggu MCU' && ! $application->mcuResult()->exists()) {
            McuResultController::autoAssign($application);
        }

        // Send notification emails on key status changes
        try {
            $application->loadMissing('applicant', 'jobPosting');
            $application->applicant?->notify(
                new ApplicationStatusUpdated($application, $validated['status'])
            );

            if ($validated['status'] === 'Dipanggil Interview' && ! empty($validated['interview_at'])) {
                Mail::to($application->applicant->email)
                    ->send(new InterviewInvitationMail($application));
            }

            if ($validated['status'] === 'Onboarding') {
                Mail::to($application->applicant->email)
                    ->send(new OnboardingInvitationMail($application));
            }
        } catch (\Exception $e) {
            logger()->error('Status email notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    /** HRD: update status via AJAX (Kanban drag) */
    public function updateStatusAjax(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Application::STATUSES)],
        ]);

        $application->update(['status' => $validated['status']]);

        // Auto-assign MCU
        if ($validated['status'] === 'Menunggu MCU' && ! $application->mcuResult()->exists()) {
            McuResultController::autoAssign($application);
        }

        try {
            $application->loadMissing('applicant', 'jobPosting');
            $application->applicant?->notify(
                new ApplicationStatusUpdated($application, $validated['status'])
            );

            if ($validated['status'] === 'Onboarding') {
                Mail::to($application->applicant->email)->send(new OnboardingInvitationMail($application));
            }
        } catch (\Exception $e) {
            logger()->error('Kanban status email failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'status' => $application->status]);
    }

    /** HRD: download applicant profile as PDF */
    public function downloadPdf(Application $application)
    {
        $this->authorize('downloadPdf', $application);

        $application->load([
            'applicant.applicantProfile.address',
            'applicant.applicantProfile.domisiliAddress',
            'applicant.applicantProfile.educations',
            'applicant.applicantProfile.workExperiences',
            'applicant.applicantProfile.immediateFamilyMembers',
            'applicant.applicantProfile.originFamilyMembers',
            'applicant.applicantProfile.languageSkills',
            'applicant.applicantProfile.trainings',
            'applicant.applicantProfile.references',
            'applicant.applicantProfile.vehicles',
            'applicant.applicantProfile.jobTypePreferences',
            'applicant.applicantProfile.essay',
            'jobPosting',
        ]);

        $pdf = Pdf::loadView('pdf.applicant-profile', compact('application'))
            ->setPaper('a4', 'portrait');

        $filename = 'DataDiri-' . str_replace(' ', '_', $application->applicant->name) . '.pdf';

        return $pdf->download($filename);
    }

    /** HRD: Kanban board */
    public function kanban()
    {
        $applications = Application::whereHas('jobPosting', function ($q) {
            $q->where('employer_id', Auth::id());
        })->with(['applicant', 'jobPosting'])->latest()->get();

        // Build ordered columns for all statuses
        $columns = collect(Application::STATUSES)->mapWithKeys(function ($status) use ($applications) {
            return [$status => $applications->where('status', $status)->values()];
        });

        return view('hrd.lamaran.kanban', compact('columns'));
    }
}
