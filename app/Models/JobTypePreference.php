<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTypePreference extends Model
{
    public const JOB_TYPES = [
        'Marketing',
        'Administrasi',
        'Production / Manufacturing',
        'Service / Maintenance',
        'PPC',
        'Engineering',
        'Finance',
        'Accounting / Pembukuan',
        'General Affairs',
        'Personnel / Training',
        'Humas',
        'Konsultasi / Riset',
    ];

    protected $fillable = [
        'applicant_profile_id',
        'job_type',
        'rank_order',
    ];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
