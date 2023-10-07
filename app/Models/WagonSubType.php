<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WagonSubType extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'wagon_type_id',
        'name'
    ];

    public function wagon_type()
    {
        return $this->belongsTo(WagonType::class, 'wagon_type_id');
    }
}
