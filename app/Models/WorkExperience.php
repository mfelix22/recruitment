<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'company',
        'company_phone',
        'company_city',
        'business_field',
        'position',
        'start_date',
        'end_date',
        'still_working',
        'job_description',
        'salary_total',
        'facilities',
        'supervisor_name',
        'subordinates_count',
        'achievement',
        'reason_for_leaving',
    ];

    protected function casts(): array
    {
        return [
            'start_date'    => 'date',
            'end_date'      => 'date',
            'still_working' => 'boolean',
        ];
    }

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }

    public function getPeriodAttribute(): string
    {
        $start = $this->start_date?->translatedFormat('M Y');
        $end   = $this->still_working ? 'Sekarang' : ($this->end_date?->translatedFormat('M Y') ?? '-');

        return $start . ' - ' . $end;
    }
}
