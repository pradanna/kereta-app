<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSafety extends Model
{
    use HasFactory, Uuids;
    protected $fillable = [
        'work_unit',
        'supervision_consultant',
        'contractor',
        'work_package',
        'period',
        'performance',
        'description',
    ];
}
