<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainBridge extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'stakes',
        'corridor',
        'bridge_type',
        'building_type',
        'span',
        'installed_date',
        'replaced_date',
        'strengthened_date',
        'volume',
        'bolt'
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }
}
