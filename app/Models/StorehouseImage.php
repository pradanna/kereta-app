<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorehouseImage extends Model
{
    use HasFactory, Uuids;


    protected $fillable = [
        'storehouse_id',
        'image'
    ];

    public function storehouse()
    {
        return $this->belongsTo(Storehouse::class, 'storehouse_id');
    }
}
