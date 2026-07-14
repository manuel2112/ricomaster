<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientFinal extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp',
        'name',
        'associated_id',
        'mount',
    ];

    public function associated(): BelongsTo
    {
        return $this->belongsTo(Associated::class);
    }
}
