<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecTrain extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_certification_id',
        'train_type_id',
        'empty_weight',
        'maximum_speed',
        'passenger_capacity',
        'air_conditioner',
        'long',
        'width',
        'height',
        'coupler_height',
        'axle_load',
        'spoor_width',
    ];

    public function facility_certification()
    {
        return $this->belongsTo(FacilityCertification::class, 'facility_certification_id');
    }

    public function train_type()
    {
        return $this->belongsTo(TrainType::class, 'train_type_id');
    }
}
