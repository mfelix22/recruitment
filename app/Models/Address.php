<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'applicant_profile_id',
        'address_type',
        'street',
        'rt_rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'province',
        'postal_code',
        'phone',
    ];

    public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->street,
            $this->rt_rw ? 'RT/RW ' . $this->rt_rw : null,
            $this->kelurahan,
            $this->kecamatan,
            $this->kabupaten,
            $this->province,
            $this->postal_code,
        ]);

        return implode(', ', $parts);
    }
}
