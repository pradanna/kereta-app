<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'app_menu_id',
        'is_granted_create',
        'is_granted_update',
        'is_granted_delete'
    ];

    protected $casts = [
        'is_granted_create' => 'boolean',
        'is_granted_update' => 'boolean',
        'is_granted_delete' => 'boolean'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function app_menu()
    {
        return $this->belongsTo(AppMenu::class, 'app_menu_id');
    }
}
