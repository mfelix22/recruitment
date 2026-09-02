<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class McuItem extends Model
{
    protected $fillable = ['description', 'sort_order'];

    public function packages()
    {
        return $this->belongsToMany(McuPackage::class, 'mcu_item_packages');
    }
}
