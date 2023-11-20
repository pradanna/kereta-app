<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function areas()
    {
        return $this->hasMany(Area::class, 'service_unit_id');
    }

    public function resorts()
    {
        return $this->hasMany(Resort::class, 'service_unit_id');
    }

    public function getDisasterAreasAttribute()
    {
        $resorts = $this->resorts()->with(['disaster_areas'])->get();
        $value = 0;
        foreach ($resorts as $resort) {
            $value += count($resort->disaster_areas);
        }
        return $value;
    }
}
