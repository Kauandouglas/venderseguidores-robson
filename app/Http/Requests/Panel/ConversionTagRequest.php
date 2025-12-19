<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConversionTagRequest extends FormRequest
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
            'pixel_facebook_ads' => 'nullable|numeric|max:191',
            'pixel_analytics' => 'max:191',
            'pixel_google_ads' => 'max:191',
            'code_event_ads' => 'max:191',
        ];
    }
}
