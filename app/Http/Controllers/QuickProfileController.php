<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use App\Models\Education;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuickProfileController extends Controller
{
    private array $educationLevels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];

    public function show()
    {
        $user    = auth()->user();
        $profile = $user->applicantProfile()->with(['address', 'educations', 'workExperiences'])->first();

        // If already complete, redirect to dashboard
        if ($profile && $profile->isBasicComplete()) {
            return redirect()->route('applicant.dashboard');
        }

        $provinces       = __('app.provinces');
        $religions       = __('app.religions');
        $educationLevels = $this->educationLevels;

        return view('applicant.setup', compact('profile', 'provinces', 'religions', 'educationLevels'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            // Basic identity
            'nik'            => ['required', 'string', 'size:16', Rule::unique('applicant_profiles', 'nik')->ignore($user->applicantProfile?->id)],
            'phone'          => ['required', 'string', 'max:20'],
            'gender'         => ['required', 'in:Laki-laki,Perempuan'],
            'place_of_birth' => ['required', 'string', 'max:100'],
            'date_of_birth'  => ['required', 'date', 'before:today'],
            'religion'       => ['required', 'string', 'max:30'],
            'marital_status' => ['required', 'in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati'],
            // Address
            'street'         => ['required', 'string', 'max:255'],
            'province'       => ['required', 'string', 'max:100'],
            'kabupaten'      => ['required', 'string', 'max:100'],
            // Education (required at least 1)
            'edu_level'      => ['required', 'in:' . implode(',', $this->educationLevels)],
            'edu_institution' => ['required', 'string', 'max:255'],
            'edu_major'      => ['nullable', 'string', 'max:100'],
            'edu_year_start' => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'edu_year_end'   => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'edu_gpa'        => ['nullable', 'numeric', 'min:0', 'max:4'],
            // Work status
            'work_status'    => ['required', 'in:fresh_graduate,has_experience'],
            // Work experience (only validated when has_experience)
            'work_company'   => ['required_if:work_status,has_experience', 'nullable', 'string', 'max:255'],
            'work_position'  => ['required_if:work_status,has_experience', 'nullable', 'string', 'max:100'],
            'work_start_date' => ['required_if:work_status,has_experience', 'nullable', 'date'],
            'work_still_here' => ['nullable', 'boolean'],
            'work_end_date'  => [
                'nullable',
                'date',
                Rule::requiredIf(fn() => $request->input('work_status') === 'has_experience' && ! $request->boolean('work_still_here')),
            ],
            'work_job_description'    => ['required_if:work_status,has_experience', 'nullable', 'string'],
            'work_reason_for_leaving' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(fn() => $request->input('work_status') === 'has_experience' && ! $request->boolean('work_still_here')),
            ],
        ]);

        // ── 1. Save / update ApplicantProfile ────────────────────────────────
        $profile = $user->applicantProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nik'            => $validated['nik'],
                'phone'          => $validated['phone'],
                'gender'         => $validated['gender'],
                'place_of_birth' => $validated['place_of_birth'],
                'date_of_birth'  => $validated['date_of_birth'],
                'religion'       => $validated['religion'],
                'marital_status' => $validated['marital_status'],
            ]
        );

        // ── 2. Save address ──────────────────────────────────────────────────
        $profile->address()->updateOrCreate(
            ['applicant_profile_id' => $profile->id],
            [
                'street'    => $validated['street'],
                'province'  => $validated['province'],
                'kabupaten' => $validated['kabupaten'],
            ]
        );

        // ── 3. Save education (create only if none exists yet) ───────────────
        if (! $profile->educations()->exists()) {
            Education::create([
                'applicant_profile_id' => $profile->id,
                'level'                => $validated['edu_level'],
                'institution'          => $validated['edu_institution'],
                'major'                => $validated['edu_major'] ?? null,
                'year_start'           => $validated['edu_year_start'],
                'year_end'             => $validated['edu_year_end'] ?? null,
                'gpa'                  => $validated['edu_gpa'] ?? null,
            ]);
        }

        // ── 4. Save work experience (only if has_experience and none exists) ──
        $isFreshGraduate = $validated['work_status'] === 'fresh_graduate';
        $stillWorking    = $request->boolean('work_still_here');

        if ($isFreshGraduate) {
            $profile->workExperiences()->delete();
        } elseif (! $profile->workExperiences()->exists()) {
            WorkExperience::create([
                'applicant_profile_id' => $profile->id,
                'company'              => $validated['work_company'],
                'position'             => $validated['work_position'] ?? null,
                'start_date'           => $validated['work_start_date'] ?? null,
                'end_date'             => $stillWorking ? null : ($validated['work_end_date'] ?? null),
                'still_working'        => $stillWorking,
                'job_description'      => $validated['work_job_description'] ?? null,
                'reason_for_leaving'   => $stillWorking ? null : ($validated['work_reason_for_leaving'] ?? null),
            ]);
        }

        $welcomeMsg = $isFreshGraduate
            ? 'Profil berhasil disimpan! Selamat datang, ' . $user->name . '. Semangat mencari pengalaman pertama! 🎓'
            : 'Profil berhasil disimpan! Selamat datang, ' . $user->name . '.';

        return redirect()->route('applicant.dashboard')->with('success', $welcomeMsg);
    }
}
