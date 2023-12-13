<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageAccident extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'direct_passage_id',
        'date',
        'train_name',
        'accident_type',
        'injured',
        'died',
        'damaged_description',
        'description',
    ];

    public function direct_passage()
    {
        return $this->belongsTo(DirectPassage::class, 'direct_passage_id');
    }

    public function images()
    {
        return $this->hasMany(DirectPassageImage::class, 'accident_id');
    }
}
