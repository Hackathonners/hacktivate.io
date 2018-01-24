<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'gender' => ['required', Rule::in(['f', 'm', 'o'])],
            'birthdate' => 'required|date',
            'location' => 'required|string|max:50',
            'phone_number' => ['required', 'string', 'regex:/(\+(\d{3}))?\d{9}/'],
            'school' => 'required|string',
            'major' => 'required|string',
            'study_level' => 'required|string',
            'bio' => 'required|string|min:0|max:255',
            'special_needs' => 'nullable|string|min:0|max:255',
            'dietary_restrictions' => 'nullable|string|min:0|max:255',
        ];
    }
}
