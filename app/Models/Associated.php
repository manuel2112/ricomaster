<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associated extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod',
        'name',
        'rut',
        'social_name',
        'address',
        'commune',
        'map',
        'whatsapp',
        'menu_normal_associated',
        'menu_special_associated',
        'menu_normal_final',
        'menu_special_final',
        'is_active',
        'mount',
        'send',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'send' => 'boolean',
    ];
}
