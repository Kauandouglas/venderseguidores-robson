<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'api_provider_id',
        'api_service',
        'type',
        'name',
        'quantity',
        'price',
        'dynamic_pricing',
        'description'
    ];

    public function apiProvider()
    {
        return $this->belongsTo(ApiProvider::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval($this->convertStringDouble($value));
    }

    public function getConvertPriceAttribute()
    {
        return number_format($this->price, 2, ',', '.');
    }

    private function convertStringDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }

    public function showcaseDescriptions()
    {
        return preg_split('/\r\n|\r|\n/', $this->attributes['description']);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
