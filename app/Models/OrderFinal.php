<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderFinal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_final_id',
        'associated_id',
        'menu_id',
        'count',
        'price',
        'day_order',
        'order_number',
        'type_menu_id',
        'campaign_id',
    ];

    public function client_final(): BelongsTo
    {
        return $this->belongsTo(ClientFinal::class);
    }

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
