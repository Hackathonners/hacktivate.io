<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
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
        $minimum_date = Carbon::now()->subYears(18)->toDateString();

        return [
            'phone_number' => 'string',
            'gender' => Rule::in(['f', 'm', 'o']),
            'birthdate' => 'required|date|before:'.$minimum_date,
            'phone_number' => 'regex:/(\+(\d{3}))?\d{9}/',
            'dietary_restrictions' => 'string|min:0|max:255',
            'school' => 'required|string',
            'major' => 'required|string',
            'study_level' => 'required|string',
            'special_needs' => 'string|min:0|max:255',
            'bio' => 'required|string|min:0|max:255',
        ];
    }
}
