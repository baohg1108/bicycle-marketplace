<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AlertService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PaymentSettingController extends Controller implements HasMiddleware
{
    public static function Middleware(): array
    {
        return [
            new Middleware('permission:Payment Setting'),
        ];
    }

    public function index(): View
    {
        return view('admin.payment-setting.sections.paypal-settings');
    }

    public function paypalSettings(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'paypal_status'    => ['required', 'string', 'max:255'],
            'paypal_mode'      => ['required', 'string', 'max:255'],
            'paypal_currency'  => ['required', 'string', 'max:255'],
            'paypal_rate'      => ['required', 'numeric'],
            'paypal_client_id' => ['required', 'string', 'max:255'],
            'paypal_secret'    => ['required', 'string', 'max:255'],
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

    public function stripe(): View
    {
        return view('admin.payment-setting.sections.stripe-settings');
    }

    public function stripeSettings(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'stripe_status'    => ['required', 'string', 'max:255'],
            'stripe_mode'      => ['required', 'string', 'max:255'],
            'stripe_currency'  => ['required', 'string', 'max:255'],
            'stripe_rate'      => ['required', 'numeric'],
            'stripe_client_id' => ['required', 'string', 'max:255'],
            'stripe_secret'    => ['required', 'string', 'max:255'],
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

    public function razorpay(): View
    {
        return view('admin.payment-setting.sections.razorpay-settings');
    }

    public function razorpaySettings(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'razorpay_status'    => ['required', 'string', 'max:255'],
            'razorpay_currency'  => ['required', 'string', 'max:255'],
            'razorpay_rate'      => ['required', 'numeric'],
            'razorpay_client_id' => ['required', 'string', 'max:255'],
            'razorpay_secret'    => ['required', 'string', 'max:255'],
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
