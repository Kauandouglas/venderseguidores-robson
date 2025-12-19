<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SignedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_payment' => 'required|in:card,pix',
            'transaction_amount' => 'required_if:type_payment,card',
            'token' => 'required_if:type_payment,card',
            'payment_method_id' => 'required_if:type_payment,card',
            'issuer_id' => 'required_if:type_payment,card|numeric',
            'payer' => 'required_if:type_payment,card',

            // Pix
            'name' => 'required_if:type_payment,pix',
            'document' => 'required_if:type_payment,pix|numeric|cpf'
        ];
    }
}
