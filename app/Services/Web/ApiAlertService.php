<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Auth;

class ApiAlertService
{
    public function count()
    {
        return Auth::user()->apiProviders()->whereNotNull('key')->count();
    }
}
