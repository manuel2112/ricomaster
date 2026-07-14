<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_id',
        'client_id',
        'is_send',
    ];

    protected $casts = [
        'is_send' => 'boolean',
    ];

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
