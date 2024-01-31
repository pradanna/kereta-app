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
        'area_id',
        'track_id',
        'sub_track_id',
        'stakes',
        'decree_number',
        'decree_date',
        'intersection',
        'building_type',
        'agency',
        'expired_date',
        'description',
        'created_by',
        'updated_by',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
