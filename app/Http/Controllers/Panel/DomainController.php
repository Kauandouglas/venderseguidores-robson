<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    public function create()
    {
        $domain = Auth::user()->domain()->first();

        return view('panel.domains.create', [
            'domain' => $domain
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->domain = $request->domain;
        $user->update();

        return redirect()->back()->withSuccess('Dominio cadastrado com sucesso!');
    }
}
