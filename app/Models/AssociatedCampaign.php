<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociatedCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'associated_id',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function associated(): BelongsTo
    {
        return $this->belongsTo(Associated::class);
    }
}
