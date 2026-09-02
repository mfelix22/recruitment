<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'applicant_profile_id',
        'level',
        'institution',
        'place',
        'major',
        'gpa',
        'year_start',
        'year_end',
        'still_studying',
    ];

    protected function casts(): array
    {
        return [
            'still_studying' => 'boolean',
            'gpa' => 'decimal:2',
        ];
    }

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }

    public function getYearRangeAttribute(): string
    {
        if ($this->still_studying) {
            return $this->year_start . ' - Sekarang';
        }

        return $this->year_start . ' - ' . ($this->year_end ?? '-');
    }
}
