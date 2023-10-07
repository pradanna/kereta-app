<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecWagon extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'facility_certification_id',
        'wagon_sub_type_id',
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

    public function facility_certification()
    {
        return $this->belongsTo(FacilityCertification::class, 'facility_certification_id');
    }

    public function wagon_sub_type()
    {
        return $this->belongsTo(WagonSubType::class, 'wagon_sub_type_id');
    }
}
