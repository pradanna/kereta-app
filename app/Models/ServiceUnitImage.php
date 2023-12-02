<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnitImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'service_unit_id',
        'image'
    ];

    public function service_unit()
    {
        return $this->belongsTo(ServiceUnit::class, 'service_unit_id');
    }
}
