<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\PaymentRequest;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function edit()
    {
        $paymentMethods = PaymentMethod::all();
        $payment = Auth::user()->payment()->first();
        if ($payment) {
            $paymentData = json_decode($payment->data, true);
        } else {
            $paymentData = [
                'option' => [],
                'public_key' => null,
                'access_token' => null

            ];
        }

        return view('panel.payments.edit', [
            'paymentMethods' => $paymentMethods,
            'payment' => $payment,
            'paymentData' => $paymentData
        ]);
    }

    public function update(PaymentRequest $request)
    {
        $data = [
            'option' => $request->option,
            'public_key' => $request->public_key,
            'access_token' => $request->access_token,
        ];

        $payment = Auth::user()->payment()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'payment_method_id' => $request->payment_method_id,
                'data' => json_encode($data)
            ]
        );

        return response()->json('Pagamento editado com sucesso!');
    }
}
