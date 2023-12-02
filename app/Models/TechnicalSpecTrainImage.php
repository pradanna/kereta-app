<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecTrainImage extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_train_images';

    protected $fillable = [
        'ts_train_id',
        'image'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecTrainImage::class, 'ts_train_id');
    }
}
