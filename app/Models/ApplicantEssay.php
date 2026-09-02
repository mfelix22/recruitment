<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantEssay extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        // Section C
        'why_chose_major',
        'best_education',
        'worst_education',
        'karya_ilmiah',
        'favorite_subject',
        'education_funder',
        // Section D (conditional on non-fresh-grad)
        'brief_job_description',
        'supervisor_detail',
        'subordinate_detail',
        'problems_faced',
        'changes_made',
        'job_satisfaction',
        'changes_motivation',
        'decision_approach',
        'who_you_consult',
        // Section D (for everyone)
        'motivational_driver',
        'decision_making',
        // Section E
        'why_apply_here',
        'company_knowledge',
        'why_2_preferences',
        'plan_for_position',
        'preferred_environment',
        'disliked_environment',
        'preferred_person_type',
        'disliked_person_type',
        'difficult_decisions',
    ];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
