<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\AlertService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): View
    {
        return view('admin.settings.sections.general-settings');
    }

    public function generalSettings(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'site_name'          => ['required', 'string', 'max:255'],
            'site_email'         => ['nullable', 'email', 'max:255'],
            'site_phone'         => ['nullable', 'string', 'max:255'],
            'size_currency'      => ['nullable', 'string', 'max:255'],
            'size_currency_icon' => ['nullable', 'string', 'max:255'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $settings = app()->make(SettingService::class);
        $settings->clearCashedSettings();

        AlertService::updated();

        return redirect()->back();
    }
}
