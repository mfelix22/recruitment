<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuPackage extends Model
{
    protected $fillable = ['code', 'name'];

    public function items()
    {
        return $this->belongsToMany(McuItem::class, 'mcu_item_packages');
    }

    public function matrices()
    {
        return $this->hasMany(McuMatrix::class);
    }

    public function results()
    {
        return $this->hasMany(McuResult::class);
    }
}
