<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SystemSettingRequest extends FormRequest
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
            'template_id' => [
                'required',
                Rule::exists('templates', 'id'),
            ],
            'title' => 'required|max:191',
            'logo' => 'nullable|image|max:15000',
            'favicon' => 'nullable|image|max:15000',
            'phone' => 'nullable|celular_com_ddd',
            'email' => 'nullable|email|max:191',
            'notify_popup_status' => 'nullable|in:1',
            'notify_popup_title' => 'nullable|max:191'
        ];
    }
}
