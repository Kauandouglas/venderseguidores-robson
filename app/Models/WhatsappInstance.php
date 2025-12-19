<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instance_name',
        'status', // disconnected, connecting, connected, expired
        'qr_code',
        'session_data', // Pode armazenar dados da sessão, como token, etc.
    ];

    protected $casts = [
        'session_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
