<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitySpecialEquipment extends Model
{
    use HasFactory, Uuids;

    protected $table = 'facility_special_equipments';

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

    public function getExpiredInAttribute()
    {
        $expired_date = Carbon::parse($this->service_expired_date);
        $now = Carbon::now();
        return $now->diffInDays($expired_date);
    }

    public function getStatusAttribute()
    {
        if ($this->getExpiredInAttribute() < 0) {
            return 'invalid';
        }
        return 'valid';
    }
}
