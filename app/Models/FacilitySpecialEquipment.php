<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitySpecialEquipment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'special_equipment_type_id',
        'area_id',
        'storehouse_id',
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

    public function storehouse()
    {
        return $this->belongsTo(Storehouse::class, 'storehouse_id');
    }

    public function special_equipment_type()
    {
        return $this->belongsTo(SpecialEquipmentType::class, 'special_equipment_type_id');
    }

    public function getExpiredInAttribute()
    {
        $expired_date = Carbon::parse($this->service_expired_date);
        $now = Carbon::now();
        return $now->diffInDays($expired_date, false);
    }

    public function getStatusAttribute()
    {
        if ($this->getExpiredInAttribute() < 0) {
            return 'invalid';
        }
        return 'valid';
    }
}
