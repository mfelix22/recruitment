<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuMatrix extends Model
{
    protected $fillable = [
        'code',
        'company',
        'department',
        'sub_section',
        'employee_position',
        'mcu_package_id',
    ];

    public function package()
    {
        return $this->belongsTo(McuPackage::class, 'mcu_package_id');
    }
}
