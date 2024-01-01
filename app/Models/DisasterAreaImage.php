<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisasterAreaImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'disaster_area_id',
        'image'
    ];

    public function disaster_area()
    {
        return $this->belongsTo(DisasterArea::class, 'disaster_area_id');
    }
}
