<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod',
        'name',
        'image',
    ];

    public function types(): HasMany
    {
        return $this->hasMany(GroupMenu::class);
    }
}
