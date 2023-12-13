<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossingPermission extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'stakes',
        'decree_number',
        'decree_date',
        'intersection',
        'building_type',
        'agency',
        'expired_date'
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }
}
