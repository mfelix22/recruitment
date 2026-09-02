<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id',
        'desired_position',
        'nik',
        'phone',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'marital_status',
        'marital_since',
        'photo',
        // Section A extras
        'blood_type',
        'height_cm',
        'weight_kg',
        'nationality',
        'ktp_issued_place',
        'ktp_phone',
        'sim_no',
        'sim_issued_place',
        'domisili_address',
        'domisili_phone',
        // Section B
        'house_status',
        'willing_to_relocate',
        'other_dependents',
        // Section E
        'expected_salary',
        'desired_facilities',
        'available_start_date',
        'has_company_acquaintances',
        'company_acquaintances',
        'company_preferences',
        // Section F
        'hobbies',
        'free_time_activities',
        'favorite_reading',
        'favorite_topics',
        'international_travel',
        'organizational_activities',
        // Section G
        'strengths',
        'weaknesses',
        'past_illness',
        'permanent_physical_condition',
        'family_health_issues',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth'             => 'date',
            'marital_since'             => 'date',
            'available_start_date'      => 'date',
            'willing_to_relocate'       => 'boolean',
            'has_company_acquaintances' => 'boolean',
            'company_preferences'       => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class)->where('address_type', 'ktp');
    }

    public function domisiliAddress()
    {
        return $this->hasOne(Address::class)->where('address_type', 'domisili');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class)->orderByDesc('year_end');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class)->orderByDesc('start_date');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function immediateFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('family_type', 'immediate');
    }

    public function originFamilyMembers()
    {
        return $this->hasMany(FamilyMember::class)->where('family_type', 'origin');
    }

    public function languageSkills()
    {
        return $this->hasMany(LanguageSkill::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class)->orderBy('sort_order');
    }

    public function references()
    {
        return $this->hasMany(ApplicantReference::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function jobTypePreferences()
    {
        return $this->hasMany(JobTypePreference::class)->orderBy('rank_order');
    }

    public function essay()
    {
        return $this->hasOne(ApplicantEssay::class);
    }

    /**
     * Phase 1 — basic info required on first login.
     * Checked before the applicant can access any page.
     */
    public function isBasicComplete(): bool
    {
        return $this->nik !== null
            && $this->phone !== null
            && $this->date_of_birth !== null
            && $this->gender !== null
            && $this->educations()->exists();
    }

    /**
     * Phase 2 — full form required before submitting an application.
     */
    public function isComplete(): bool
    {
        return $this->nik !== null
            && $this->phone !== null
            && $this->date_of_birth !== null
            && $this->blood_type !== null
            && $this->emergency_contact_name !== null
            && $this->address()->exists()
            && $this->educations()->exists();
    }
}
