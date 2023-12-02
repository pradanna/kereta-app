<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storehouse extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name',
        'storehouse_type_id',
        'area_id',
        'city_id',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function storehouse_type()
    {
        return $this->belongsTo(StorehouseType::class, 'storehouse_type_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function images()
    {
        return $this->hasMany(StorehouseImage::class, 'storehouse_id');
    }

    public function locomotives()
    {
        return $this->hasMany(FacilityLocomotive::class, 'storehouse_id');
    }

    public function trains()
    {
        return $this->hasMany(FacilityTrain::class, 'storehouse_id');
    }

    public function wagons()
    {
        return $this->hasMany(FacilityWagon::class, 'storehouse_id');
    }

    public function getCountLocomotiveAttribute()
    {
        return count($this->locomotives()->get());
    }

    public function getCountTrainAttribute()
    {
        return count($this->trains()->get());
    }

    public function getCountWagonAttribute()
    {
        return count($this->wagons()->get());
    }
}
