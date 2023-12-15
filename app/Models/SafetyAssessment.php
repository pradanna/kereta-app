<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyAssessment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'sub_track_id',
        'district_id',
        'stakes',
        'recommendation_number',
        'organizer',
        'description',
        'job_scope',
        'follow_up',
    ];

    public function sub_track()
    {
        return $this->belongsTo(SubTrack::class, 'sub_track_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
