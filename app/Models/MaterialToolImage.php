<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialToolImage extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'material_tool_id',
        'image'
    ];

    public function material_tool()
    {
        return $this->belongsTo(MaterialTool::class, 'material_tool_id');
    }
}
