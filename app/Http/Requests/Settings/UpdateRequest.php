<?php

namespace App\Http\Requests\Settings;

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
          'applications_start_at' => 'required|date|before:applications_end_at',
          'applications_end_at' => 'required|date|after:applications_start_at',
          'min_team_members' => 'required|numeric|min:1|max_field:max_team_members',
          'max_team_members' => 'required|numeric|min_field:min_team_members',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'applications_start_at' => 'begin date of the applications submission period.',
            'applications_end_at' => 'end date of applications submission period.',
            'min_team_members' => 'min number of members per team.',
            'max_team_members' => 'max number of members per team.',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'min_members_team.*' => 'The minimum number of members must between 0 and the maximum number of members.',
            'max_members_team.*' => 'The maximum number of members must bigger than the minimum number of members.',
        ];
    }
}
