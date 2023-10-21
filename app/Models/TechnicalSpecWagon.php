<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecWagon extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_wagon_id',
        'loading_weight',
        'empty_weight',
        'maximum_speed',
        'long',
        'width',
        'height_from_rail',
        'axle_load',
        'bogie_distance',
        'usability',
    ];

    public function facility_wagon()
    {
        return $this->belongsTo(FacilityWagon::class, 'facility_wagon_id');
    }
}
