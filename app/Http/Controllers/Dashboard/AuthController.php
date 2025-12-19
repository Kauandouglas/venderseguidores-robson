<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PlanPurchase;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        $userCount = User::users()->count();
        $storeConfigCount = User::has('systemSettings')->has('apiProviders')->count();
        $purchasesSum = Purchase::success()->sum('price');
        $planPurchasesCount = PlanPurchase::active()->count();

        $purchases = Purchase::select(DB::raw("COUNT(*) as count"),
                DB::raw("DATE_FORMAT(purchases.created_at,'%Y-%m-%d') as date_format"))
            ->success()
            ->whereMonth('created_at', request()->monthOrder ?? date('m'))
            ->whereYear('created_at', date('Y'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();
        $sumPurchases = Purchase::select(DB::raw("SUM(price) as sum"),
                DB::raw("DATE_FORMAT(purchases.created_at,'%Y-%m-%d') as date_format"))
            ->success()
            ->whereMonth('created_at', request()->monthOrder ?? date('m'))
            ->whereYear('created_at', date('Y'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();

        $count = [];
        $date = [];

        foreach ($purchases as $purchase) {
            $count[] = $purchase->count;
            $date[] = date('d/m/Y', strtotime($purchase->date_format));
        }

        $sum = [];

        foreach ($sumPurchases as $sumPurchase) {
            $sum[] = $sumPurchase->sum;
        }


        $users = User::select(DB::raw("COUNT(*) as count"),
            DB::raw("DATE_FORMAT(users.created_at,'%Y-%m-%d') as date_format"))
            ->users()
            ->whereMonth('created_at', request()->monthOrder ?? date('m'))
            ->whereYear('created_at', date('Y'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();

        $countUser = [];
        $dateUser = [];

        foreach ($users as $user) {
            $countUser[] = $user->count;
            $dateUser[] = date('d/m/Y', strtotime($user->date_format));
        }

        return view('dashboard.index', [
            'purchaseCount' => json_encode($count),
            'purchaseDate' => json_encode($date),
            'sumPurchases' => json_encode($sum),
            'countUser' => json_encode($countUser),
            'dateUser' => json_encode($dateUser),
            'userCount' => $userCount,
            'storeConfigCount' => $storeConfigCount,
            'purchasesSum' => $purchasesSum,
            'planPurchasesCount' => $planPurchasesCount
        ]);
    }

    public function formLogin()
    {
        if (Auth::check() && Auth::user()->role == 1) {
            return redirect()->route('dashboard.index');
        }

        return view('dashboard.auth.form_login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!Auth::attempt($credentials, true)) {
            return redirect()->back()->withErrors('Email ou senha inválidos');
        }

        if (!$this->verifyLevel()) {
            return redirect()->back()->withErrors('Não é possivel usar essa conta para realizar o login.');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.index');
    }

    private function verifyLevel()
    {
        if (Auth::user()->role != 1) {
            Auth::logout();
            return false;
        }

        return true;
    }
}
