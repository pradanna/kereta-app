<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'track_id',
        'sub_track_id',
        'city_id',
        'name',
        'stakes',
        'width',
        'road_construction',
        'road_name',
        'guarded_by',
        'is_closed',
        'is_not_found',
        'is_underpass',
        'arrangement_proposal',
        'accident_history',
        'latitude',
        'longitude',
        'description',
        'technical_documentation',
        'elevation',
        'road_class',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function direct_passage_guard()
    {
        return $this->hasMany(DirectPassageGuard::class, 'direct_passage_id');
    }

    public function getCountGuardAttribute()
    {
        return count($this->direct_passage_guard()->get());
    }

    public function sign_equipment()
    {
        return $this->hasOne(DirectPassageSignEquipment::class, 'direct_passage_id');
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

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function images()
    {
        return $this->hasMany(DirectPassageImage::class, 'direct_passage_id');
    }

    public function accidents()
    {
        return $this->hasMany(DirectPassageAccident::class, 'direct_passage_id');
    }

    public function getCountAccidentAttribute()
    {
        return $this->accidents()->count();
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
