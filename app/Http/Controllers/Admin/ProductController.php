<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    //
    public function index(): View
    {
        return view("admin.product.index");
    }
    public function create(): View
    {
        $stores = Store::select(["name", "id"])->get();
        $brands = Brand::select(["name", "id"])->where("is_active", 1)->get();
        $tags   = Tag::where("is_active", 1)->get();
        return view("admin.product.create", compact("stores", "brands", "tags"));
    }
}
