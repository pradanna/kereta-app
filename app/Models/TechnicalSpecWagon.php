<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalSpecWagon extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ts_wagons';
    protected $fillable = [
        'wagon_sub_type_id',
        'loading_weight',
        'empty_weight',
        'maximum_speed',
        'long',
        'width',
        'height_from_rail',
        'axle_load',
        'boogie_distance',
        'usability',
        'description',
        'created_by',
        'updated_by',
    ];

    public function facility_wagon()
    {
        return $this->belongsTo(FacilityWagon::class, 'facility_wagon_id');
    }

    public function wagon_sub_type()
    {
        return $this->belongsTo(WagonSubType::class, 'wagon_sub_type_id');
    }

    public function tech_documents()
    {
        return $this->hasMany(TechnicalSpecWagonDocument::class, 'ts_wagon_id');
    }

    public function tech_images()
    {
        return $this->hasMany(TechnicalSpecWagonImage::class, 'ts_wagon_id');
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
