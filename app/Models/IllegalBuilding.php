<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllegalBuilding extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'track_id',
        'sub_track_id',
        'district_id',
        'stakes',
        'surface_area',
        'building_area',
        'distance_from_rail',
        'illegal_building',
        'demolished',
        'description',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images()
    {
        return $this->hasMany(IllegalBuildingImage::class, 'illegal_building_id');
    }
}
