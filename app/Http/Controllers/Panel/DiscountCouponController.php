<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\DiscountCouponRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountCouponController extends Controller
{
    public function index()
    {
        $discountCoupons = Auth::user()->discountCoupons()->latest('id')->paginate(15);

        return view('panel.discountCoupons.index', [
            'discountCoupons' => $discountCoupons
        ]);
    }

    public function create()
    {
        return view('panel.discountCoupons.create');
    }

    public function store(DiscountCouponRequest $request)
    {
        $discountCoupons = Auth::user()->discountCoupons()->create($request->all());

        return response()->json('Cadastrado com sucesso!');
    }

    public function destroy(Request $request)
    {
        $discountCoupon = Auth::user()->discountCoupons()->findOrFail($request->discountCoupon);
        $discountCoupon->delete();

        return redirect()->back()->withErrors('Cupom deletado com sucesso!');
    }
}
