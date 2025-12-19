<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingTransportir extends Model
{
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo(\App\Models\Driver::class, 'driver_id');
    }

    public function transportir()
    {
        return $this->belongsTo(\App\Models\Transportir::class, 'transportir_id');
    }
}
