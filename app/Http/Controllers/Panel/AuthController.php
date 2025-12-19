<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        $purchases = User::withSum(['purchases as purchases_in_month' => function($query) {
            $query->where('status', 'approved')->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->select(DB::raw('SUM(price) as total_price'));
        }], 'price')->whereNotIn('id', ['359'])->orderBy('purchases_in_month', 'desc')->get();

        foreach ($purchases as $i => $purchase) {
           if($purchase->id == Auth::id()){
               $positionRank = $i + 1;
               break;
           }
        }

        $purchases = Auth::user()->purchases()
            ->select(DB::raw("COUNT(*) as count"),
                DB::raw("DATE_FORMAT(purchases.created_at,'%Y-%m-%d') as date_format"))
            ->success()
            ->whereMonth('created_at', request()->monthOrder ?? date('m'))
            ->whereYear('created_at', date('Y'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();
        $sumPurchases = Auth::user()->purchases()
            ->select(DB::raw("SUM(price) as sum"),
                DB::raw("DATE_FORMAT(purchases.created_at,'%Y-%m-%d') as date_format"))
            ->success()
            ->whereMonth('created_at', request()->monthOrder ?? date('m'))
            ->whereYear('created_at', date('Y'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();
        $purchaseSum = Auth::user()->purchases()->success()->whereMonth('created_at', request()->monthOrder ?? date('m'))->whereYear('created_at', date('Y'))->sum('price');
        $purchaseChargeSum = Auth::user()->purchases()->success()->whereMonth('created_at', request()->monthOrder ?? date('m'))->whereYear('created_at', date('Y'))->sum('charge');
        $purchaseCount = Auth::user()->purchases()->success()->whereMonth('created_at', request()->monthOrder ?? date('m'))->whereYear('created_at', date('Y'))->count();

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

        return view('panel.index', [
            'purchaseCount' => json_encode($count),
            'purchaseDate' => json_encode($date),
            'purchaseSum' => $purchaseSum,
            'purchaseChargeSum' => $purchaseChargeSum,
            'purchaseTotalCount' => $purchaseCount,
            'sumPurchases' => json_encode($sum),
            'positionRank' => $positionRank ?? 0
        ]);
    }

    public function formLogin()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return redirect()->route('panel.index');
        }

        return view('panel.auth.login');
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

        return redirect()->route('panel.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.home');
    }

    private function verifyLevel()
    {
        if (Auth::user()->role != 2) {
            Auth::logout();
            return false;
        }

        return true;
    }
}
