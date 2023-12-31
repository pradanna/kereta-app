<?php

namespace App\Models;

use App\Helper\Formula;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossingPermission extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'stakes',
        'decree_number',
        'decree_date',
        'intersection',
        'building_type',
        'agency',
        'expired_date'
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
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
