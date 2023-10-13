<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityWagon extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'storehouse_id',
        'wagon_sub_type_id',
        'ownership',
        'facility_number',
        'facility_period',
        'service_start_date',
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

    public function wagon_sub_type()
    {
        return $this->belongsTo(WagonSubType::class, 'wagon_sub_type_id');
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
