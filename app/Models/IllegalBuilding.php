<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllegalBuilding extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'district_id',
        'stakes',
        'surface_area',
        'building_area',
        'distance_from_rail',
        'illegal_building',
        'demolished',
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
