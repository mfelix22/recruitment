<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    private function profile()
    {
        return auth()->user()->applicantProfile;
    }

    public function index()
    {
        $works = $this->profile()?->workExperiences ?? collect();
        return view('applicant.work.index', compact('works'));
    }

    public function create()
    {
        return view('applicant.work.form', ['work' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company'            => ['required', 'string', 'max:200'],
            'position'           => ['required', 'string', 'max:100'],
            'start_date'         => ['required', 'date'],
            'end_date'           => ['nullable', 'date', 'after_or_equal:start_date'],
            'still_working'      => ['boolean'],
            'job_description'    => ['nullable', 'string'],
            'salary_total'       => ['nullable', 'string', 'max:100'],
            'facilities'         => ['nullable', 'string', 'max:255'],
            'supervisor_name'    => ['nullable', 'string', 'max:100'],
            'subordinates_count' => ['nullable', 'integer', 'min:0'],
            'achievement'        => ['nullable', 'string'],
            'reason_for_leaving' => ['nullable', 'string', 'max:255'],
        ]);
        $data['still_working'] = $request->boolean('still_working');
        if ($data['still_working']) $data['end_date'] = null;

        $profile = $this->profile() ?? auth()->user()->applicantProfile()->create();
        $profile->workExperiences()->create($data);

        return redirect()->route('applicant.work.index')->with('success', 'Pengalaman kerja berhasil ditambahkan.');
    }

    public function edit(WorkExperience $workExperience)
    {
        abort_unless($workExperience->applicantProfile->user_id === auth()->id(), 403);
        return view('applicant.work.form', ['work' => $workExperience]);
    }

    public function update(Request $request, WorkExperience $workExperience)
    {
        abort_unless($workExperience->applicantProfile->user_id === auth()->id(), 403);

        $data = $request->validate([
            'company'            => ['required', 'string', 'max:200'],
            'position'           => ['required', 'string', 'max:100'],
            'start_date'         => ['required', 'date'],
            'end_date'           => ['nullable', 'date', 'after_or_equal:start_date'],
            'still_working'      => ['boolean'],
            'job_description'    => ['nullable', 'string'],
            'salary_total'       => ['nullable', 'string', 'max:100'],
            'facilities'         => ['nullable', 'string', 'max:255'],
            'supervisor_name'    => ['nullable', 'string', 'max:100'],
            'subordinates_count' => ['nullable', 'integer', 'min:0'],
            'achievement'        => ['nullable', 'string'],
            'reason_for_leaving' => ['nullable', 'string', 'max:255'],
        ]);
        $data['still_working'] = $request->boolean('still_working');
        if ($data['still_working']) $data['end_date'] = null;

        $workExperience->update($data);

        return redirect()->route('applicant.work.index')->with('success', 'Pengalaman kerja berhasil diperbarui.');
    }

    public function destroy(WorkExperience $workExperience)
    {
        abort_unless($workExperience->applicantProfile->user_id === auth()->id(), 403);
        $workExperience->delete();
        return redirect()->route('applicant.work.index')->with('success', 'Pengalaman kerja dihapus.');
    }

    public function show(WorkExperience $workExperience)
    {
        return redirect()->route('applicant.profile.edit');
    }
}
