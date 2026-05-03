<?php

/** check user has permission */

use App\Models\Cart;
use App\Models\Category;
use App\Models\ShippingRule;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

if (!function_exists('hasPermission')) {
    function hasPermission(array $permissions): bool
    {
        if (auth('admin')->user()->hasRole('Super Admin')) return true;

        return auth('admin')->user()->hasAnyPermission($permissions);
    }
}


/** get user */
if (!function_exists('user')) {
    function user(): User | null
    {
        return Auth::user('web');
    }
}