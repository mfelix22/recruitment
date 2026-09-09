<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;

class SavedJobController extends Controller
{
    /** Applicant: list saved jobs */
    public function index()
    {
        $savedJobs = auth()->user()->savedJobs()->latest('saved_jobs.created_at')->paginate(10);

        $appliedIds = auth()->user()->applications()->pluck('job_posting_id');

        return view('applicant.lowongan.saved', compact('savedJobs', 'appliedIds'));
    }

    /** Applicant: toggle save/unsave a job posting */
    public function toggle(JobPosting $jobPosting)
    {
        $user = auth()->user();

        if ($user->savedJobs()->where('job_posting_id', $jobPosting->id)->exists()) {
            $user->savedJobs()->detach($jobPosting->id);

            return back()->with('success', 'Lowongan dihapus dari daftar tersimpan.');
        }

        $user->savedJobs()->attach($jobPosting->id);

        return back()->with('success', 'Lowongan disimpan. Lihat di menu "Lowongan Tersimpan".');
    }
}
