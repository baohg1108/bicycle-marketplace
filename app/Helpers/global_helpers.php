<?php

/** check user has permission */

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('hasPermission')) {
    function hasPermission(array $permissions): bool
    {
        if (auth('admin')->user()->hasRole('Super Admin')) {
            return true;
        }

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
// Get nested categories
if (! function_exists('getNestedCategories')) {
    function getNestedCategories()
    {
        $categories = Category::getNested();
        return $categories;
    }
}
