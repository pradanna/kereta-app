<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTool extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'area_id',
        'resort_id',
        'type',
        'qty',
        'unit',
        'description',
        'latitude',
        'longitude',
        'stakes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }

    public function author_create()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function author_update()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function images()
    {
        return $this->hasMany(MaterialToolImage::class, 'material_tool_id');
    }
}
