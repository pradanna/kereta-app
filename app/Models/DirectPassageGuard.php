<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageGuard extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'direct_passage_id',
        'is_verified_by_operator',
        'is_verified_by_unit_track_and_bridge',
        'is_verified_by_institution',
        'is_verified_by_unguarded',
        'is_illegal',
    ];

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }
}
