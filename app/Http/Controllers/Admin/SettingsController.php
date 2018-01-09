<?php

namespace App\Http\Controllers\Admin;

use App\Alexa\Models\Settings;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateRequest;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('settings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Settings\UpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        DB::transaction(function () use ($request) {
            if ($request->has('projects_submission_start_at')) {
                $minimum_date = $request->input('projects_submission_start_at');
            } else {
                $minimum_date = app('settings')->projects_submission_start_at;
            }
            $this->validate($request, [
                'projects_submission_end_at' => 'after:'.$minimum_date,
            ]);

            app('settings')->update($request->all());
        });
        // flash('Settings were successfully updated.')->success();

        return redirect()->route('settings.edit')->with('status', 'Settings were successfully updated.');
    }
}