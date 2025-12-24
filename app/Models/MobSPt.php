<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobSPt extends Model
{
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
