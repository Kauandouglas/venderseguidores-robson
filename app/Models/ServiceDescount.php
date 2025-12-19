<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDescount extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_min',
        'percent',
    ];

    public function setPriceMinAttribute($value)
    {
        $this->attributes['price_min'] = floatval($this->convertStringDouble($value));
    }

    private function convertStringDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }
}
