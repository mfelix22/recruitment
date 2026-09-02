<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantReference extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'name',
        'work_address',
        'phone',
        'position',
        'relation',
    ];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
