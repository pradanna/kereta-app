<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecTrain extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_trains';

    protected $fillable = [
        'train_type_id',
        'empty_weight',
        'maximum_speed',
        'passenger_capacity',
        'air_conditioner',
        'long',
        'width',
        'height',
        'coupler_height',
        'axle_load',
        'spoor_width',
    ];

    public function train_type()
    {
        return $this->belongsTo(TrainType::class, 'train_type_id');
    }

    public function tech_documents()
    {
        return $this->hasMany(TechnicalSpecTrainDocument::class, 'ts_train_id');
    }

    public function tech_images()
    {
        return $this->hasMany(TechnicalSpecTrainImage::class, 'ts_train_id');
    }
}
