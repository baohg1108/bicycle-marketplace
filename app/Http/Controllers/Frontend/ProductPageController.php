<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class ProductPageController extends Controller
{
    function index() : View
    {

        $products = Product::with(['images' => function ($query){
            $query->limit(2);
        }, 'store:id,name', 'primaryVariant'])
        ->where('status', 'active')->where('approved_status', 'approved')->paginate(20);
        
        return view('frontend.pages.product', compact('products'));
    }

    function show(string $slug) : View 
    {
        $product = Product::with('images:id,path,product_id')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::whereHas('categories', function($query) use($product){
            $query->whereIn('categories.id', $product->categories->pluck('id')->toArray());
        })
            ->where('id', '!=', $product->id)
            ->where(['status' => 'active', 'approved_status' => 'approved'])
            ->distinct()
            ->take(6)
            ->get();

        return view('frontend.pages.product-show', compact('product', 'relatedProducts'));
    }
}