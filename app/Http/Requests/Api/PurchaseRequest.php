<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:pix,card,pix_direct',
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'whatsapp' => 'required|max:191',
            'service' => 'required_if:type,pix_direct|numeric|exists:services,id',
            'quantity' => 'required_if:type,pix_direct|numeric|min:100',
        ];
    }
}
