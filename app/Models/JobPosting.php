<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $fillable = [
        'employer_id',
        'title',
        'position',
        'department',
        'location',
        'experience_level',
        'experience_years',
        'employment_type',
        'job_description',
        'requirements',
        'min_education',
        'open_positions',
        'deadline',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'deadline'  => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhere('deadline', '>=', now()->toDateString());
            });
    }
}
