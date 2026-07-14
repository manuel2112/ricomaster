<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'week',
        'year',
        'first_day',
        'actual',
        'programmed',
        'is_past',
    ];

    protected $casts = [
        'actual' => 'boolean',
        'programmed' => 'boolean',
        'is_past' => 'boolean',
    ];

    public function bill(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
