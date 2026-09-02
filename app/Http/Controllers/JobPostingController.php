<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    private array $educationLevels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
    private array $experienceLevels = ['Fresh Graduate', 'Junior', 'Mid', 'Senior', 'Manajer'];
    private array $employmentTypes = ['Full Time', 'Part Time', 'Kontrak', 'Magang', 'Freelance'];

    /** Applicant: browse active jobs */
    public function index(Request $request)
    {
        $query = JobPosting::active()->with('employer')->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->cari . '%')
                    ->orWhere('position', 'like', '%' . $request->cari . '%')
                    ->orWhere('department', 'like', '%' . $request->cari . '%')
                    ->orWhere('location', 'like', '%' . $request->cari . '%');
            });
        }

        if ($request->filled('jenis')) {
            $query->where('employment_type', $request->jenis);
        }

        $jobs = $query->paginate(10)->withQueryString();

        return view('applicant.lowongan.index', compact('jobs'));
    }

    /** Applicant: view single job */
    public function show(JobPosting $jobPosting)
    {
        if (! $jobPosting->is_active) {
            abort(404);
        }

        $alreadyApplied = false;
        if (auth()->check()) {
            $alreadyApplied = $jobPosting->applications()
                ->where('applicant_id', auth()->id())
                ->exists();
        }

        return view('applicant.lowongan.show', compact('jobPosting', 'alreadyApplied'));
    }

    // ─── HRD methods ──────────────────────────────────────────────────────────

    /** HRD: list own job postings */
    public function employerIndex()
    {
        $jobs = JobPosting::where('employer_id', auth()->id())
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('hrd.lowongan.index', compact('jobs'));
    }

    /** HRD: show create form */
    public function create()
    {
        return view('hrd.lowongan.create', [
            'educationLevels'  => $this->educationLevels,
            'experienceLevels' => $this->experienceLevels,
            'employmentTypes'  => $this->employmentTypes,
        ]);
    }

    /** HRD: save new job posting */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'position'         => ['nullable', 'string', 'max:255'],
            'department'       => ['nullable', 'string', 'max:255'],
            'location'         => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'in:Fresh Graduate,Junior,Mid,Senior,Manajer'],
            'experience_years' => ['nullable', 'string', 'max:50'],
            'employment_type'  => ['required', 'in:Full Time,Part Time,Kontrak,Magang,Freelance'],
            'min_education'    => ['nullable', 'in:SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3'],
            'open_positions'   => ['required', 'integer', 'min:1'],
            'deadline'         => ['nullable', 'date', 'after:today'],
            'job_description'  => ['required', 'string'],
            'requirements'     => ['nullable', 'string'],
        ]);

        $validated['employer_id'] = auth()->id();
        $validated['is_active']   = $request->boolean('is_active', true);

        JobPosting::create($validated);

        return redirect()->route('employer.lowongan.index')
            ->with('success', 'Lowongan berhasil dibuat.');
    }

    /** HRD: show edit form */
    public function edit(JobPosting $lowongan)
    {
        $this->authorizeOwner($lowongan);

        return view('hrd.lowongan.edit', [
            'job'              => $lowongan,
            'educationLevels'  => $this->educationLevels,
            'experienceLevels' => $this->experienceLevels,
            'employmentTypes'  => $this->employmentTypes,
        ]);
    }

    /** HRD: save edits */
    public function update(Request $request, JobPosting $lowongan)
    {
        $this->authorizeOwner($lowongan);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'position'         => ['nullable', 'string', 'max:255'],
            'department'       => ['nullable', 'string', 'max:255'],
            'location'         => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'in:Fresh Graduate,Junior,Mid,Senior,Manajer'],
            'experience_years' => ['nullable', 'string', 'max:50'],
            'employment_type'  => ['required', 'in:Full Time,Part Time,Kontrak,Magang,Freelance'],
            'min_education'    => ['nullable', 'in:SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3'],
            'open_positions'   => ['required', 'integer', 'min:1'],
            'deadline'         => ['nullable', 'date'],
            'job_description'  => ['required', 'string'],
            'requirements'     => ['nullable', 'string'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $lowongan->update($validated);

        return redirect()->route('employer.lowongan.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /** HRD: delete job posting */
    public function destroy(JobPosting $lowongan)
    {
        $this->authorizeOwner($lowongan);
        $lowongan->delete();

        return redirect()->route('employer.lowongan.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    private function authorizeOwner(JobPosting $job): void
    {
        if ($job->employer_id !== auth()->id()) {
            abort(403);
        }
    }
}
