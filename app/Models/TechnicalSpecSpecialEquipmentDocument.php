<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecSpecialEquipmentDocument extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_se_documents';

    protected $fillable = [
        'ts_special_equipment_id',
        'document'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecSpecialEquipment::class, 'ts_special_equipment_id');
    }
}
