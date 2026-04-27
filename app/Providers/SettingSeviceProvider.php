<?php

namespace App\Providers;

use App\Services\SettingSevice;
use Illuminate\Support\ServiceProvider;

class SettingSeviceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingSevice::class, fn () => new SettingSevice());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $settings = $this->app->make(SettingSevice::class);
        $settings->setSettings();
    }
}