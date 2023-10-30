<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'code',
        'name'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
