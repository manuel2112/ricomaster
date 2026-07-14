<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAssociated extends Model
{
    use HasFactory;

    protected $fillable = [
        'associated_id',
        'type_menu_id',
        'menu_id',
        'count',
        'price',
        'day_order',
        'order_number',
    ];

    public function associated(): BelongsTo
    {
        return $this->belongsTo(Associated::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function type_menu(): BelongsTo
    {
        return $this->belongsTo(TypeMenu::class);
    }
}
