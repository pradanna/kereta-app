<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecSpecialEquipmentImage extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_se_equipment_images';

    protected $fillable = [
        'ts_special_equipment_id',
        'image'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecSpecialEquipment::class, 'ts_special_equipment_id');
    }
}
