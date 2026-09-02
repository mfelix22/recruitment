<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use App\Models\ApplicantEssay;
use App\Models\FamilyMember;
use App\Models\JobTypePreference;
use App\Models\LanguageSkill;
use App\Models\Training;
use App\Models\ApplicantReference;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicantProfileController extends Controller
{
    public function edit()
    {
        $user    = auth()->user();
        $profile = $user->applicantProfile()->with([
            'addresses',
            'educations',
            'workExperiences',
            'immediateFamilyMembers',
            'originFamilyMembers',
            'languageSkills',
            'trainings',
            'references',
            'vehicles',
            'jobTypePreferences',
            'essay',
        ])->first();

        $provinces       = __('app.provinces');
        $religions       = __('app.religions');
        $educationLevels = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];

        return view(
            'applicant.profile.edit',
            compact('profile', 'provinces', 'religions', 'educationLevels')
        );
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'desired_position'            => ['nullable', 'string', 'max:150'],
            'nik'                        => ['required', 'string', 'size:16', Rule::unique('applicant_profiles', 'nik')->ignore($user->applicantProfile?->id)],
            'name'                       => ['required', 'string', 'max:100'],
            'phone'                      => ['required', 'string', 'max:20'],
            'place_of_birth'             => ['required', 'string', 'max:100'],
            'date_of_birth'              => ['required', 'date'],
            'gender'                     => ['required', 'in:Laki-laki,Perempuan'],
            'religion'                   => ['required', 'string'],
            'marital_status'             => ['required', 'in:Belum Menikah,Bertunangan,Menikah,Cerai Hidup,Cerai Mati'],
            'marital_since'              => ['nullable', 'date'],
            'blood_type'                 => ['required', 'string', 'max:5'],
            'height_cm'                  => ['required', 'integer', 'min:50', 'max:250'],
            'weight_kg'                  => ['required', 'integer', 'min:20', 'max:300'],
            'nationality'                => ['required', 'string', 'max:50'],
            'ktp_issued_place'           => ['nullable', 'string', 'max:100'],
            'sim_no'                     => ['nullable', 'string', 'max:50'],
            'sim_issued_place'           => ['nullable', 'string', 'max:100'],
            'photo'                      => ['nullable', 'image', 'max:2048'],
            // KTP address
            'street'                     => ['required', 'string'],
            'rt_rw'                      => ['nullable', 'string', 'max:10'],
            'kelurahan'                  => ['nullable', 'string', 'max:100'],
            'kecamatan'                  => ['nullable', 'string', 'max:100'],
            'kabupaten'                  => ['required', 'string', 'max:100'],
            'province'                   => ['required', 'string', 'max:100'],
            'postal_code'                => ['nullable', 'string', 'max:10'],
            // New Option-B fields
            'domisili_address'           => ['nullable', 'string'],
            'domisili_phone'             => ['nullable', 'string', 'max:30'],
            'ktp_phone'                  => ['nullable', 'string', 'max:30'],
            'house_status'               => ['nullable', 'string', 'max:50'],
            'willing_to_relocate'        => ['boolean'],
            'other_dependents'           => ['nullable', 'string'],
            'expected_salary'            => ['nullable', 'integer', 'min:0'],
            'desired_facilities'         => ['nullable', 'string'],
            'available_start_date'       => ['nullable', 'date'],
            'has_company_acquaintances'  => ['required', 'boolean'],
            'company_acquaintances'      => ['nullable', 'string'],
            'company_preferences'        => ['nullable', 'array'],
            'company_preferences.*'      => ['string'],
            'hobbies'                    => ['nullable', 'string'],
            'free_time_activities'       => ['nullable', 'string'],
            'favorite_reading'           => ['nullable', 'string'],
            'favorite_topics'            => ['nullable', 'string'],
            'international_travel'       => ['nullable', 'string'],
            'organizational_activities'  => ['nullable', 'string'],
            'strengths'                  => ['nullable', 'string'],
            'weaknesses'                 => ['nullable', 'string'],
            'past_illness'               => ['nullable', 'string'],
            'permanent_physical_condition' => ['nullable', 'string'],
            'family_health_issues'       => ['nullable', 'string'],
            'emergency_contact_name'     => ['required', 'string', 'max:100'],
            'emergency_contact_phone'    => ['required', 'string', 'max:30'],
            'emergency_contact_relation' => ['required', 'string', 'max:50'],
            // Job preferences
            'job_pref'                   => ['nullable', 'array'],
            'job_pref.*'                 => ['nullable', 'integer', 'min:1', 'max:12'],
            // Inline tables
            'family'                     => ['nullable', 'array'],
            'trainings'                  => ['nullable', 'array'],
            'languages'                  => ['nullable', 'array'],
            'references'                 => ['nullable', 'array'],
            'vehicles'                   => ['nullable', 'array'],
            'essay'                      => ['nullable', 'array'],
        ]);

        $user->update(['name' => $request->name]);

        // Photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $old = $user->applicantProfile?->photo;
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $profileData = $request->only([
            'desired_position',
            'nik',
            'phone',
            'place_of_birth',
            'date_of_birth',
            'gender',
            'religion',
            'marital_status',
            'marital_since',
            'blood_type',
            'height_cm',
            'weight_kg',
            'nationality',
            'ktp_issued_place',
            'sim_no',
            'sim_issued_place',
            'house_status',
            'other_dependents',
            'expected_salary',
            'domisili_address',
            'domisili_phone',
            'ktp_phone',
            'desired_facilities',
            'available_start_date',
            'company_acquaintances',
            'company_preferences',
            'hobbies',
            'free_time_activities',
            'favorite_reading',
            'favorite_topics',
            'international_travel',
            'organizational_activities',
            'strengths',
            'weaknesses',
            'past_illness',
            'permanent_physical_condition',
            'family_health_issues',
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relation',
        ]);
        $profileData['willing_to_relocate']       = $request->boolean('willing_to_relocate');
        $profileData['has_company_acquaintances'] = $request->boolean('has_company_acquaintances');
        if ($photoPath) {
            $profileData['photo'] = $photoPath;
        }

        $profile = ApplicantProfile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        // KTP address (address_type = 'ktp')
        $profile->addresses()->updateOrCreate(
            ['applicant_profile_id' => $profile->id, 'address_type' => 'ktp'],
            array_merge(
                $request->only(['street', 'rt_rw', 'kelurahan', 'kecamatan', 'kabupaten', 'province', 'postal_code']),
                ['address_type' => 'ktp']
            )
        );

        // Family members
        if ($request->has('family')) {
            $profile->familyMembers()->delete();
            foreach ($request->input('family', []) as $row) {
                if (!empty($row['name'])) {
                    $profile->familyMembers()->create($row);
                }
            }
        }

        // Language skills
        if ($request->has('languages')) {
            $profile->languageSkills()->delete();
            foreach ($request->input('languages', []) as $row) {
                if (!empty($row['language'])) {
                    $profile->languageSkills()->create($row);
                }
            }
        }

        // Trainings
        if ($request->has('trainings')) {
            $profile->trainings()->delete();
            foreach ($request->input('trainings', []) as $i => $row) {
                if (!empty($row['name'])) {
                    $profile->trainings()->create(array_merge($row, ['sort_order' => $i]));
                }
            }
        }

        // References
        if ($request->has('references')) {
            $profile->references()->delete();
            foreach ($request->input('references', []) as $row) {
                if (!empty($row['name'])) {
                    $profile->references()->create($row);
                }
            }
        }

        // Vehicles
        if ($request->has('vehicles')) {
            $profile->vehicles()->delete();
            foreach ($request->input('vehicles', []) as $row) {
                if (!empty($row['brand_type'])) {
                    $profile->vehicles()->create($row);
                }
            }
        }

        // Job type preferences
        if ($request->has('job_pref')) {
            $profile->jobTypePreferences()->delete();
            foreach ($request->input('job_pref', []) as $jobType => $rank) {
                if ($rank && in_array($jobType, JobTypePreference::JOB_TYPES)) {
                    $profile->jobTypePreferences()->create([
                        'job_type'   => $jobType,
                        'rank_order' => (int) $rank,
                    ]);
                }
            }
        }

        // Essay answers
        if ($request->has('essay')) {
            ApplicantEssay::updateOrCreate(
                ['applicant_profile_id' => $profile->id],
                $request->input('essay', [])
            );
        }

        return redirect()->route('applicant.profile.edit')
            ->with('success', 'Formulir lamaran berhasil disimpan.');
    }
}
