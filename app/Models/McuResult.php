<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuResult extends Model
{
    protected $fillable = [
        'application_id',
        'mcu_package_id',
        'result',
        'notes',
        'scheduled_date',
        'completed_date',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_date'  => 'date',
            'completed_date'  => 'date',
        ];
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function package()
    {
        return $this->belongsTo(McuPackage::class, 'mcu_package_id');
    }

    public function isLulus(): bool
    {
        return $this->result === 'Lulus';
    }
}
