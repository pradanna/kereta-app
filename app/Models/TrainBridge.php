<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainBridge extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'track_id',
        'sub_track_id',
        'stakes',
        'corridor',
        'reference_number',
        'bridge_type',
        'building_type',
        'span',
        'installed_date',
        'replaced_date',
        'strengthened_date',
        'volume',
        'bolt',
        'bearing',
        'description',
        'created_by',
        'updated_by',
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

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
