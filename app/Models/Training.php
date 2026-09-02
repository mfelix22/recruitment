<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'name',
        'organizer',
        'place',
        'year',
        'notes',
        'sort_order',
    ];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }
}
