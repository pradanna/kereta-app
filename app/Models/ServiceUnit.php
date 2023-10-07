<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name'
    ];

    public function areas()
    {
        return $this->hasMany(Area::class, 'service_unit_id');
    }
}
