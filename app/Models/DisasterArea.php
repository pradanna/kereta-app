<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterArea extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'track_id',
        'resort_id',
        'sub_track_id',
        'disaster_type_id',
        'location_type',
        'block',
        'latitude',
        'longitude',
        'lane',
        'handling',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }

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

    public function disaster_type()
    {
        return $this->belongsTo(DisasterType::class, 'disaster_type_id');
    }

    public function images()
    {
        return $this->hasMany(DisasterAreaImage::class, 'disaster_area_id');
    }
}
