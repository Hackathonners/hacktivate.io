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
          'projects_submission_start_at' => 'date',
          'projects_submission_end_at' => 'required|date',
          'min_members_team' => 'required|numeric|min:1|max_field:max_members_team',
          'max_members_team' => 'required|numeric|min_field:min_members_team',
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
            'projects_submission_start_at' => 'begin date of the submitting applications period',
            'projects_submission_end_at' => 'end date of the submitting applications period',
            'min_members_team' => 'min number of members per team',
            'max_members_team' => 'max number of members per team',
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
            'projects_submission_end_at.*' => 'The projects submission end date must be a date greater than the projects submission start date.',
        ];
    }
}
