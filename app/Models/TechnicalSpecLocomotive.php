<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecLocomotive extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_locomotive_id',
        'empty_weight',
        'house_power',
        'maximum_speed',
        'fuel_consumption',
        'long',
        'width',
        'height',
        'coupler_height',
        'wheel_diameter',
    ];

    public function facility_locomotive()
    {
        return $this->belongsTo(FacilityLocomotive::class, 'facility_locomotive_id');
    }

}
