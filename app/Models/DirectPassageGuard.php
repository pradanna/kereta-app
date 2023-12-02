<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageGuard extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'direct_passage_id',
        'human_resource_id',
    ];

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }

    public function human_resource()
    {
        return $this->belongsTo(DirectPassageHumanResource::class, 'human_resource_id');
    }
}
