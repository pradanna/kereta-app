<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageSignEquipment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'direct_passage_id',
        'locomotive_flute',
        'crossing_gate',
        'non_crossing_gate',
        'warning',
        'critical_distance_450',
        'critical_distance_300',
        'critical_distance_100',
        'stop_sign',
        'vehicle_entry_ban',
        'shock_line',
    ];

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }
}
