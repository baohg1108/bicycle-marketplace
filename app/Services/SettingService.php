<?php
namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function setSettings()
    {
        $settings = $this->getSettings();
        config()->set('settings', $settings);
    }

    public function clearCashedSettings()
    {
        Cache::forget('settings');
    }
}
