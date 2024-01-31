<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecSpecialEquipment extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_special_equipment';

    protected $fillable = [
        'special_equipment_type_id',
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
        'usability',
        'description',
        'created_by',
        'updated_by',
    ];

    public function special_equipment_type()
    {
        return $this->belongsTo(SpecialEquipmentType::class, 'special_equipment_type_id');
    }

    public function tech_documents()
    {
        return $this->hasMany(TechnicalSpecSpecialEquipmentDocument::class, 'ts_special_equipment_id');
    }

    public function tech_images()
    {
        return $this->hasMany(TechnicalSpecSpecialEquipmentImage::class, 'ts_special_equipment_id');
    }

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
