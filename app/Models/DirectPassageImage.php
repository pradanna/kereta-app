<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'direct_passage_id',
        'image'
    ];

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }
}
