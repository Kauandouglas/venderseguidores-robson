<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
            'payment_method_id' => [
                'required',
                Rule::exists('payment_methods', 'id'),
            ],
            'access_token' => 'required_if:payment_method_id,1|max:191',
            'public_key' => 'max:191',
            'option' => 'required',
        ];
    }
}
