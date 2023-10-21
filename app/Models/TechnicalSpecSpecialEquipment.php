<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecSpecialEquipment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_special_equipment_id',
        'empty_weight',
        'maximum_speed',
        'air_conditioner',
        'long',
        'width',
        'height',
        'coupler_height',
        'axle_load',
        'spoor_width',
    ];

    public function facility_special_equipment()
    {
        return $this->belongsTo(FacilitySpecialEquipment::class, 'facility_special_equipment_id');
    }
}
