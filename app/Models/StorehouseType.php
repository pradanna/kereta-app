<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorehouseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'marker_icon'
    ];
}
