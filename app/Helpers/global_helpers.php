<?php

/** check user has permission */

use App\Models\Cart;
use App\Models\Category;
use App\Models\ShippingRule;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
/** get cart total */
if (!function_exists('cartCount')) {
    function cartCount(): int
    {
        return Cart::where('user_id', user()?->id)->count();
    }
}




/** get cart total */
if (!function_exists('cartTotal')) {
    function cartTotal(): float
    {
        $cartTotal = 0;
        $cartItems = Cart::with('product')->where('user_id', user()->id)->get();

        foreach ($cartItems as $cartItem) {
            $cartTotal += $cartItem->product->getVariantOrProductPriceAndStock($cartItem->variant_id)['price'] * $cartItem->quantity;
        }

        return $cartTotal;
    }
}

/** get cart discount */
if (!function_exists('cartDiscount')) {
    function cartDiscount(): float
    {
        if (Session::has('coupon')) {
            $coupon =  Session::get('coupon');
            $cartTotal = cartTotal();
            $discount = $coupon['coupon_type'] == 'fixed' ? $coupon['coupon_value'] : $cartTotal * ($coupon['coupon_value'] / 100);
            $discount = min($discount, $cartTotal);

            return $discount;
        }
        return 0;
    }
}
/** get cart discount */
if (!function_exists('getPayableAmount')) {
    function getPayableAmount(): float
    {
        $cartTotal = cartTotal();
        $cartDiscount = cartDiscount();
        $shippingCharge = 0;
        if (Session::has('billing_info')) {
            $shippingCharge = ShippingRule::find(Session::get('billing_info')['shipping_method_id'])->charge;
        }

        return round(($cartTotal + $shippingCharge) - $cartDiscount, 2);
    }
}

/** truncate text */
if (!function_exists('truncate')) {
    function truncate($text, int $length = 70): string|null
    {
        return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
    }
}
