<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTool extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'resort_id',
        'type',
        'qty',
        'unit',
        'description',
        'latitude',
        'longitude',
        'stakes',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }
}
