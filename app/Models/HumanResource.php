<?php

namespace App\Models;

use App\Helper\Formula;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'name',
        'birth_place',
        'date_of_birth',
        'identity_number',
        'type',
        'certification_unit',
        'certification_number',
        'expired_date',
        'description',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function getExpiredInAttribute()
    {
        $expired_date = Carbon::parse($this->expired_date);
        $now = Carbon::now();
        return $now->diffInDays($expired_date, false);
    }

    public function getStatusAttribute()
    {
        if ($this->getExpiredInAttribute() <= Formula::ExpirationLimit) {
            return 'invalid';
        }
        return 'valid';
    }
}
