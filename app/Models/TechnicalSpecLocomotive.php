<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecLocomotive extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_certification_id',
        'locomotive_type_id',
        'type',
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

    public function facility_certification()
    {
        return $this->belongsTo(FacilityCertification::class, 'facility_certification_id');
    }

    public function locomotive_type()
    {
        return $this->belongsTo(LocomotiveType::class, 'locomotive_type_id');
    }
}
