<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterArea extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'resort_id',
        'sub_track_id',
        'disaster_type_id',
        'block',
        'latitude',
        'longitude',
        'lane',
        'handling',
        'description',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function disaster_type()
    {
        return $this->belongsTo(DisasterType::class, 'disaster_type_id');
    }
}
