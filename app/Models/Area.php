<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'service_unit_id',
        'name',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function service_unit()
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }
}
