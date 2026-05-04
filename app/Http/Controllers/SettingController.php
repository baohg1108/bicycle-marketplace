<?php

namespace App\Http\Controllers;

use App\Services\AlertService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SettingSevice;

class SettingController extends Controller
{
    function index(): View
    {
        return view('admin.settings.sections.general-settings');
    }

    function generalSettings(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'string', 'max:255'],
            'size_currency' => ['nullable', 'string', 'max:255'],
            'size_currency_icon' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settings = app()->make(SettingSevice::class);
        $settings->clearCashedSettings();

        AlertService::updated();

        return redirect()->back();
    }
}
