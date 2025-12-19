<?php

namespace App\Services\Panel;

use Illuminate\Support\Facades\Auth;

class OrderFailService
{
    public function count()
    {
        return Auth::user()->purchases()->where('status', 'canceled')->whereNotNull('error')->count();
    }
}
