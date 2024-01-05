<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IllegalBuildingImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'illegal_building_id',
        'image'
    ];

    public function illegal_building()
    {
        return $this->belongsTo(IllegalBuilding::class, 'illegal_building_id');
    }
}
