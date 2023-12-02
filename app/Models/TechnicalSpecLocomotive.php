<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecLocomotive extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'locomotive_type_id',
        'empty_weight',
        'house_power',
        'maximum_speed',
        'fuel_consumption',
        'long',
        'width',
        'height',
        'coupler_height',
        'wheel_diameter',
    ];

    public function locomotive_type()
    {
        return $this->belongsTo(LocomotiveType::class, 'locomotive_type_id');
    }

    public function tech_documents()
    {
        return $this->hasMany(TechnicalSpecLocomotiveDocument::class, 'ts_locomotive_id');
    }

    public function tech_images()
    {
        return $this->hasMany(TechnicalSpecLocomotiveImage::class, 'ts_locomotive_id');
    }
}
