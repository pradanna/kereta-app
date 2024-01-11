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
        'station_class',
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

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
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
