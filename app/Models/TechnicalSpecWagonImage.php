<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecWagonImage extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_wagon_images';

    protected $fillable = [
        'ts_wagon_id',
        'image'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecWagonImage::class, 'ts_wagon_id');
    }
}
