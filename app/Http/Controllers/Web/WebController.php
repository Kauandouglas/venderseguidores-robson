<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        $plans = Plan::all();

        return view('web.home', [
            'plans' => $plans
        ]);
    }
}
