<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'pixel_facebook_ads',
        'pixel_analytics',
        'pixel_google_ads',
        'code_event_ads'
    ];
}
