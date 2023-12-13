<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageAccidentImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'accident_id',
        'image'
    ];

    public function accident()
    {
        return $this->belongsTo(DirectPassageAccident::class, 'accident_id');
    }
}
