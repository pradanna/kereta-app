<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WagonType extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name'
    ];
}