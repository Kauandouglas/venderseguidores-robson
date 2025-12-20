<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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
       // Validação customizada
        $validator = Validator::make($request->all(), [
            'domain' => [
                'required',
                'string',
                'regex:/^(?!www\.)([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', // Domínio sem www e sem protocolo
            ],
        ], [
            'domain.regex' => 'Informe apenas o domínio, sem https:// ou www.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Se passou na validação, salva ou atualiza
        $domain = Auth::user()->domain()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['domain' => strtolower($request->domain)]
        );

        return redirect()->back()->withSuccess('Domínio cadastrado com sucesso!');
    }
}
