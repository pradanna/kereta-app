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
        'description',
        'created_by',
        'updated_by',
    ];

    public function documents()
    {
        return $this->hasMany(NewWorkSafetyDocument::class, 'new_work_safety_id');
    }

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
