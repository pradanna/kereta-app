<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'name',
        'stakes',
        'width',
        'road_construction',
        'road_name',
        'city_id',
        'is_verified_by_operator',
        'is_verified_by_unit_track_and_bridge',
        'is_verified_by_institution',
        'is_verified_by_independent',
        'is_verified_by_unguarded',
        'is_illegal',
        'is_closed',
        'is_not_found',
        'is_underpass',
        'description',
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
