<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecLocomotiveImage extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_locomotive_images';

    protected $fillable = [
        'ts_locomotive_id',
        'image'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecLocomotive::class, 'ts_locomotive_id');
    }
}
