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
          'factor_followers' => 'required|numeric',
          'factor_gists' => 'required|numeric',
          'factor_number_repositories' => 'required|numeric',
          'factor_repository_contributions' => 'required|numeric',
          'factor_repository_stars' => 'required|numeric',
          'factor_repository_watchers' => 'required|numeric',
          'factor_repository_forks' => 'required|numeric',
          'factor_repository_size' => 'required|numeric',
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
            'applications_start_at' => 'begin date of the applications submission period',
            'applications_end_at' => 'end date of applications submission period',
            'min_team_members' => 'min number of members per team',
            'max_team_members' => 'max number of members per team',
            'factor_followers' => 'factor for each user follower',
            'factor_gists' => 'factor for each user gists',
            'factor_number_repositories' => 'factor for each user public repository',
            'factor_repository_contributions' => 'factor for each contribution in users public repositories',
            'factor_repository_stars' => 'factor for each star in users public repositories',
            'factor_repository_watchers' => 'factor for watcher star in users public repositories',
            'factor_repository_forks' => 'factor for each fork in users public repositories',
            'factor_repository_size' => 'factor for the size of each users public repositories',
        ];
    }
}
