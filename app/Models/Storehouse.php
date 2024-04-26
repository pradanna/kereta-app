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
        'longitude',
        'description',
        'created_by',
        'updated_by',
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

    public function specialEquipment()
    {
        return $this->hasMany(FacilitySpecialEquipment::class, 'storehouse_id');
    }

    public function getCountSpecialEquipmentAttribute()
    {
        return count($this->specialEquipment()->get());
    }

    public function getCountLocomotiveAttribute()
    {
        return count($this->locomotives()->get());
    }

    public function getCountTrainAttribute()
    {
        return count($this->trains()->get());
    }

    public function getCountUsualTrainAttribute()
    {
        return count($this->trains()->where('engine_type', 'train')->get());
    }

    public function getCountElectricTrainAttribute()
    {
        return count($this->trains()->where('engine_type', 'electric-train')->get());
    }

    public function getCountDieselTrainAttribute()
    {
        return count($this->trains()->where('engine_type', 'diesel-train')->get());
    }


    public function getCountWagonAttribute()
    {
        return count($this->wagons()->get());
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
