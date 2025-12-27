<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    protected $fillable = [
        'name',
        'status',
        'social_network',
    ];

    public function getStatusStringAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Desativado';
            case 1:
                return 'Ativo';
        }
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
