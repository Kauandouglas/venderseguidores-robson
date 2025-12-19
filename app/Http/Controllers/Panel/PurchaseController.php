<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\Web\PurchaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Auth::user()->purchases()->when(request()->search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('order_id', $search)
                    ->orWhere('name', 'LIKE', "%$search%")
                    ->orWhere('whatsapp', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('instagram', 'LIKE', "%$search%");
            });
        })->when(request()->status, function ($query, $status) {
            $query->where('status', $status);
        })->with('service')->latest('id')->paginate(15);

        return view('panel.purchases.index', [
            'purchases' => $purchases
        ]);
    }

    public function sendOrder(Request $request, PurchaseService $purchaseService)
    {
        $purchase = Auth::user()->purchases()->findOrFail($request->purchase);
        $purchaseService->sendOrder($purchase);

        return redirect()->back();
    }
}
