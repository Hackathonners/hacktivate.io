<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
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
            $updateFields = $request->all();
            $updateFields['applications_start_at'] = Carbon::parse($updateFields['applications_start_at']);
            $updateFields['applications_end_at'] = Carbon::parse($updateFields['applications_end_at']);

            app('settings')->update($updateFields);
        });

        return redirect()->route('settings.edit')->with('status', 'Settings were successfully updated.');
    }
}
