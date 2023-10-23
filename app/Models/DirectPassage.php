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
        'city_id',
        'name',
        'stakes',
        'width',
        'road_construction',
        'road_name',
        'is_closed',
        'is_not_found',
        'is_underpass',
        'arrangement_proposal',
        'accident_history',
        'latitude',
        'longitude',
        'description',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function direct_passage_guard()
    {
        return $this->hasOne(DirectPassageGuard::class, 'direct_passage_id');
    }

    public function sign_equipment()
    {
        return $this->hasOne(DirectPassageSignEquipment::class, 'direct_passage_id');
    }

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
