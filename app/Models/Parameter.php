<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_hour_start',
        'bill_hour_end',
        'bill_price_default',
        'campaign_hour_start',
        'campaign_hour_end',
        'campaign_price_default',
    ];
}
