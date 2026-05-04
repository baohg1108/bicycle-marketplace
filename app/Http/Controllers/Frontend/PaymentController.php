<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingRule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;


class PaymentController extends Controller
{
    function index(): View
    {
        $cartItems = Cart::with('product.store')
            ->where('user_id', user()->id)
            ->get()
            ->groupBy(function ($cartItem) {
                return $cartItem->product->store_id;
            });

        $groupedCartItems = $cartItems->map(function ($items, $storeId) {
            $store = $items->first()->product->store;

            return [
                'store' => $store,
                'items' => $items
            ];
        });
        $shippingCharge = ShippingRule::find(Session::get('billing_info')['shipping_method_id'])->charge;
        return view('frontend.pages.payment', compact('groupedCartItems', 'shippingCharge'));
    }
}