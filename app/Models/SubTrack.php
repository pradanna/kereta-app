<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTrack extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'track_id',
        'code',
        'name'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }
}
