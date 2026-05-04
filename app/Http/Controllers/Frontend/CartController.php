<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = Cart::with("product")->where("user_id", user()->id)->paginate(30);
        return view('frontend.pages.cart', compact('cartItems'));
    }

    public function productModal(Product $product): String
    {

        $modal = view('components.frontend.product-quick-view-modal', compact('product'))->render();

        return $modal;
    }

    public function addToCart(Request $request)
    {
        // check user login
        if (! user()) {
            throw ValidationException::withMessages([
                'message' => 'Please login to add product to cart',
            ]);
        }

        $product   = Product::findOrFail($request->product_id);
        $variantId = $request->variant_id;
        // $productInfo = $product->getVariantOrProductPriceAndStock($variantId);
        // dd($productInfo);
        // if(!$productInfo['in_stock']) {
        //     throw ValidationException::withMessages(["Product out of stock"]);
        // }

        $quantity  = $request->quantity;
        $showModal = $request->modal;

        if ($showModal === 'true') {
            return response()->json([
                'status'     => 'success',
                'modal'      => $this->productModal($product),
                'show_modal' => true,
            ]);
        }

        // check stock
        $this->checkStock($product, $variantId, $quantity);

        // Duplicate check
        if (Cart::where('user_id', user()->id)
            ->where('product_id', $product->id)
            ->when($variantId, fn($q) => $q->where('variant_id', $variantId))
            ->exists()
        ) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product already added to cart',
            ], 409);
        }

        $this->store($request, $product);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Product added to cart successfully',
            // 'cart_count' => cartCount(),
            'show_modal' => false,
        ]);
    }
    public function checkStock(Product $product, $variantId, $quantity)
    {
        if ($variantId) {
            $variant = $product->variants()->find($variantId);
            if (! $variant || ! $variant->in_stock || ($variant->manage_stock && $variant->qty < $quantity)) {
                abort(422, 'Product out of stock');
            }

            if (! $product->primaryVariant) {
                if (! $product->in_stock || ($product->manage_stock && $product->qty < $quantity)) {
                    abort(422, 'Product out of stock');
                }
            }
        }
    }

    public function store(Request $request, Product $product)
    {
        $cart             = new Cart();
        $cart->user_id    = user()->id;
        $cart->product_id = $product->id;
        $cart->variant_id = $request->variant_id;
        $cart->quantity   = $request->quantity;
        $cart->name       = $product->name;
        $cart->save();
    }
}
