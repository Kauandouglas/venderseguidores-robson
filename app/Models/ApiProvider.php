<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'balance',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getConvertBalanceAttribute()
    {
        return number_format($this->balance, 2, ',', '.');
    }

    public function getStatusStringAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Desativado';
            case 1:
                return 'Ativo';
        }
    }
}
