<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageSkill extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'language',
        'written_level',
        'spoken_level',
    ];

    public const LEVELS = ['S. Baik', 'Baik', 'Cukup', 'Kurang'];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
