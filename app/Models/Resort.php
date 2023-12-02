<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'service_unit_id',
        'name',
    ];

    public function service_unit()
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }

    public function disaster_areas()
    {
        return $this->hasMany(DisasterArea::class, 'resort_id');
    }
}
