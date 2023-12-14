<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayStation extends Model
{
    use HasFactory,Uuids;

    protected $fillable = [
        'area_id',
        'district_id',
        'name',
        'nickname',
        'stakes',
        'height',
        'latitude',
        'longitude',
        'type',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
