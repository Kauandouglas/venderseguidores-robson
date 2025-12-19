<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Auth;

class SystemSetting
{
    public function first()
    {
        return Auth::user()->systemSetting()->first();
    }
}
