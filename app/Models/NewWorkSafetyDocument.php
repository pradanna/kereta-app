<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewWorkSafetyDocument extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'new_work_safety_id',
        'name',
        'document'
    ];

    public function new_work_safety()
    {
        return $this->belongsTo(NewWorkSafety::class, 'new_work_safety_id');
    }
}
