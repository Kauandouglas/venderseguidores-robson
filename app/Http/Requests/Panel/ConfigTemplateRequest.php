<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConfigTemplateRequest extends FormRequest
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
            'nav_button' => 'max:191',
            'header_title' => 'max:191',
            'header_button' => 'max:191',
            'header_image' => 'nullable|image|max:15000',
            'service_image_1' => 'nullable|image|max:15000',
            'service_title_1' => 'max:191',
            'service_image_2' => 'nullable|image|max:15000',
            'service_title_2' => 'max:191',
            'service_image_3' => 'nullable|image|max:15000',
            'service_title_3' => 'max:191',
            'basic_title' => 'max:191',
            'about_image' => 'nullable|image|max:15000',
            'about_title' => 'max:191',
            'about_button' => 'max:191',
            'contact_title' => 'max:191',
            'footer_title' => 'max:191'
        ];
    }
}
