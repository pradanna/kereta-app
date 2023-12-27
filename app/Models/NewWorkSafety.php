<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewWorkSafety extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'project_name',
        'location',
        'consultant',
        'document',
        'description'
    ];

    public function documents()
    {
        return $this->hasMany(NewWorkSafetyDocument::class, 'new_work_safety_id');
    }
}
