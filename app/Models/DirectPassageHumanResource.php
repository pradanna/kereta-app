<?php

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPassageHumanResource extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name',
        'skill_card_id',
        'training_card_id',
        'card_expired',
    ];

    public function getExpiredInAttribute()
    {
        $expired_date = Carbon::parse($this->card_expired);
        $now = Carbon::now();
        return $now->diffInDays($expired_date, false);
    }
}
