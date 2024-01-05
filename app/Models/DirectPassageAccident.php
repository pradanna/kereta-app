<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageAccident extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'track_id',
        'sub_track_id',
        'city_id',
        'direct_passage_id',
        'stakes',
        'date',
        'train_name',
        'accident_type',
        'injured',
        'died',
        'latitude',
        'longitude',
        'damaged_description',
        'chronology',
        'description',
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }

    public function images()
    {
        return $this->hasMany(DirectPassageAccidentImage::class, 'accident_id');
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
