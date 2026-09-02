<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public const STATUSES = [
        'Menunggu',
        'Sedang Ditinjau',
        'Dipanggil Interview',
        'Proses Seleksi',
        'Menunggu MCU',
        'Onboarding',
        'Diterima',
        'Tidak Diterima',
    ];

    // Statuses that count as "still in progress"
    public const ACTIVE_STATUSES = [
        'Menunggu',
        'Sedang Ditinjau',
        'Dipanggil Interview',
        'Proses Seleksi',
        'Menunggu MCU',
        'Onboarding',
    ];

    protected $fillable = [
        'applicant_id',
        'job_posting_id',
        'status',
        'cover_letter',
        'employer_notes',
        'interview_at',
        'interview_location',
        'interview_notes',
    ];

    protected $casts = [
        'interview_at' => 'datetime',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Diterima'            => 'green',
            'Tidak Diterima'      => 'red',
            'Dipanggil Interview' => 'blue',
            'Proses Seleksi'      => 'purple',
            'Menunggu MCU'        => 'orange',
            'Onboarding'          => 'teal',
            'Sedang Ditinjau'     => 'yellow',
            default               => 'gray',   // Menunggu
        };
    }

    public function getStatusStepAttribute(): int
    {
        return match ($this->status) {
            'Menunggu'            => 1,
            'Sedang Ditinjau'     => 2,
            'Dipanggil Interview' => 3,
            'Proses Seleksi'      => 4,
            'Menunggu MCU'        => 5,
            'Onboarding'          => 6,
            'Diterima'            => 7,
            'Tidak Diterima'      => 7,
            default               => 1,
        };
    }

    public function isFinished(): bool
    {
        return in_array($this->status, ['Diterima', 'Tidak Diterima'], true);
    }

    public function mcuResult()
    {
        return $this->hasOne(McuResult::class);
    }

    public function applicantDocuments()
    {
        return $this->hasMany(ApplicantDocument::class);
    }
}
