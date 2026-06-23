<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;


class SettingController extends Controller
{
    public function index()
    {
        return apiSuccess(
            data: Setting::pluck('value', 'name')
        );
    }

    public function update(UpdateSettingRequest $request)
    {
        foreach ($request->validated() as $name => $value) {

            Setting::where('name', $name)
                ->update([
                    'value' => $value
                ]);
        }

        return apiSuccess(
            'Settings updated successfully',
            Setting::pluck('value', 'name')
        );
    }
}
