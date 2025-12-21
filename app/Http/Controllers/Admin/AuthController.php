<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Mostrar formulário de login
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Processar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email deve ser válido',
            'password.required' => 'A senha é obrigatória',
        ]);

        // Verificar se o usuário existe e é admin (role = 1)
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'As credenciais fornecidas estão incorretas.',
            ])->withInput($request->only('email'));
        }

        // Verificar se é admin
        if ($user->role != 1) {
            return back()->withErrors([
                'email' => 'Você não tem permissão para acessar o painel administrativo.',
            ])->withInput($request->only('email'));
        }

        // Fazer login
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('admin.dashboard')->with('success', 'Login realizado com sucesso!');
    }

    /**
     * Fazer logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Você foi desconectado com sucesso!');
    }
}

