<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitySpecialEquipment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'ownership',
        'new_facility_number',
        'old_facility_number',
        'service_expired_date',
        'testing_number',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
