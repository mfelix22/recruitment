<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'family_type',
        'relation',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'education',
        'occupation',
    ];

    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
