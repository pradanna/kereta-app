<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecTrainDocument extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_train_documents';

    protected $fillable = [
        'ts_train_id',
        'document'
    ];

    public function technical_spec()
    {
        return $this->belongsTo(TechnicalSpecTrainDocument::class, 'ts_train_id');
    }
}
