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
        'api_rate',
        'type_social',
        'type',
        'name',
        'quantity',
        'price',
        'dynamic_pricing',
        'description',
        'order',
        'sync_price',
        'sync_margin_percent'
    ];

    protected $casts = [
        'sync_price' => 'boolean',
        'sync_margin_percent' => 'float'
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
        // Normaliza removendo caracteres estranhos, preservando apenas dígitos e separadores
        $value = preg_replace('/[^0-9.,]/', '', $param);

        // Se não houver separador, retorne apenas os dígitos
        $lastSeparatorPos = max(strrpos($value, ','), strrpos($value, '.'));
        if ($lastSeparatorPos === false) {
            return preg_replace('/[^0-9]/', '', $value);
        }

        // Separa a parte inteira e a decimal considerando o último separador como separador decimal
        $integerPart = substr($value, 0, $lastSeparatorPos);
        $decimalPart = substr($value, $lastSeparatorPos + 1);

        // Remove qualquer separador que tenha ficado na parte inteira/decimal
        $integerPart = preg_replace('/[^0-9]/', '', $integerPart);
        $decimalPart = preg_replace('/[^0-9]/', '', $decimalPart);

        return $integerPart . '.' . $decimalPart;
    }

    public function showcaseDescriptions()
    {
        return preg_split('/\r\n|\r|\n/', $this->attributes['description']);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    /**
     * Recalcula o preço de venda com base no custo do provedor e margem.
     */
    public function recalcPriceFromProvider(): void
    {
        if (!$this->sync_price) {
            return;
        }

        if (!$this->api_rate || !$this->quantity || $this->quantity <= 0) {
            return;
        }

        $cost = ($this->api_rate / 1000) * $this->quantity;
        $marginPercent = $this->sync_margin_percent ?? 0;

        $this->price = $cost * (1 + ($marginPercent / 100));
        $this->save();
    }
}
