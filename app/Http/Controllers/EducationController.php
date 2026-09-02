<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    private function profile()
    {
        return auth()->user()->applicantProfile;
    }

    public function index()
    {
        $educations = $this->profile()?->educations ?? collect();
        $levels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        return view('applicant.education.index', compact('educations', 'levels'));
    }

    public function create()
    {
        $levels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        return view('applicant.education.form', ['education' => null, 'levels' => $levels]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'level'         => ['required', 'string'],
            'institution'   => ['required', 'string', 'max:200'],
            'major'         => ['nullable', 'string', 'max:100'],
            'year_start'    => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'year_end'      => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'gpa'           => ['nullable', 'numeric', 'min:0', 'max:4'],
            'still_studying' => ['boolean'],
        ]);
        $data['still_studying'] = $request->boolean('still_studying');

        $profile = $this->profile() ?? auth()->user()->applicantProfile()->create();
        $profile->educations()->create($data);

        return redirect()->route('applicant.education.index')->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    public function edit(Education $education)
    {
        abort_unless($education->applicantProfile->user_id === auth()->id(), 403);
        $levels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        return view('applicant.education.form', compact('education', 'levels'));
    }

    public function update(Request $request, Education $education)
    {
        abort_unless($education->applicantProfile->user_id === auth()->id(), 403);

        $data = $request->validate([
            'level'         => ['required', 'string'],
            'institution'   => ['required', 'string', 'max:200'],
            'major'         => ['nullable', 'string', 'max:100'],
            'year_start'    => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'year_end'      => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'gpa'           => ['nullable', 'numeric', 'min:0', 'max:4'],
            'still_studying' => ['boolean'],
        ]);
        $data['still_studying'] = $request->boolean('still_studying');

        $education->update($data);

        return redirect()->route('applicant.education.index')->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function destroy(Education $education)
    {
        abort_unless($education->applicantProfile->user_id === auth()->id(), 403);
        $education->delete();
        return redirect()->route('applicant.education.index')->with('success', 'Pendidikan dihapus.');
    }

    // stub – not used
    public function show(Education $education)
    {
        return redirect()->route('applicant.profile.edit');
    }
}
