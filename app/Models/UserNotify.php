<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'unique_token',
        'subject',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
