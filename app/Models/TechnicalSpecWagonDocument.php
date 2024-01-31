<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecWagonDocument extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_wagon_documents';

    protected $fillable = [
        'ts_wagon_id',
        'document',
        'name'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecWagonDocument::class, 'ts_wagon_id');
    }
}
