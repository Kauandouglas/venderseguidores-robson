<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getConvertDateAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->created_at));
    }

    public function setErrorAttribute($value)
    {
        $this->attributes['error'] = json_encode($value, true);
    }

    public function getStatusStringAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Pendente';
            case 'approved':
                return 'Enviado';
        }

        return 'Error';
    }

    public function getConvertChargeAttribute()
    {
        return number_format($this->charge, 2, ',', '.');
    }

    public function scopeSuccess($query)
    {
        $query->where('status', 'approved');
    }
}
