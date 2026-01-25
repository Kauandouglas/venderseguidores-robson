<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('user_id', Auth::id()),
            ],
            'api_provider_id' => [
                'required',
                Rule::exists('api_providers', 'id')->where('user_id', Auth::id()),
            ],
            'api_service' => 'required',
            'name' => 'required|max:191',
            'quantity' => 'required_if:dynamic_pricing,0',
            'price' => 'required|max:10',
            'dynamic_pricing' => 'boolean',
            'sync_price' => 'boolean',
            'sync_margin_percent' => 'nullable|numeric|min:0|max:1000'
        ];
    }
}
