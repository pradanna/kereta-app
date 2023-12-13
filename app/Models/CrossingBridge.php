<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossingBridge extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'stakes',
        'recommendation_number',
        'responsible_person',
        'long',
        'width',
        'road_class',
        'description'
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }
}
