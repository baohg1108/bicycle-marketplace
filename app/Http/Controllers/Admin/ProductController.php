<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use FileUploadTrait;
    //
    public function index(): View
    {
        return view("admin.product.index");
    }
    public function create(): View
    {
        $stores     = Store::select(["name", "id"])->get();
        $brands     = Brand::select(["name", "id"])->where("is_active", 1)->get();
        $tags       = Tag::where("is_active", 1)->get();
        $categories = Category::getNested();
        return view("admin.product.create", compact("stores", "brands", "tags", 'categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $product                      = new Product();
        $product->name                = $request->name;
        $product->slug                = $request->slug;
        $product->short_description   = $request->short_description;
        $product->description         = $request->content;
        $product->sku                 = $request->sku;
        $product->price               = $request->price;
        $product->special_price       = $request->special_price;
        $product->special_price_start = $request->from_date;
        $product->special_price_end   = $request->to_date;
        $product->qty                 = $request->quantity;
        $product->manage_stock        = $request->has('manage_stock') ? 'yes' : 'no';
        $product->in_stock            = $request->stock_status == 'in_stock' ? 1 : 0;
        $product->status              = $request->status;
        $product->store_id            = $request->store;
        $product->brand_id            = $request->brand;
        $product->is_featured         = $request->has('is_featured') ? 1 : 0;
        $product->is_hot              = $request->has('is_hot') ? 1 : 0;
        $product->is_new              = $request->has('is_new') ? 1 : 0;
        $product->save();

        // attach categories
        $product->categories()->sync($request->categories);

        // attach tags
        $product->tags()->sync($request->tags);

        return response()->json([
            'status'  => 'success',
            'message' => 'Product created successfully',
        ]);
    }

    public function edit(int $id)
    {
        $product    = Product::findOrFail($id);
        $stores     = Store::select(["name", "id"])->get();
        $brands     = Brand::select(["name", "id"])->where("is_active", 1)->get();
        $tags       = Tag::where("is_active", 1)->get();
        $categories = Category::getNested();
        return view("admin.product.edit", compact("stores", "brands", "tags", 'categories', 'product'));
    }

    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            "file" => ["required", "image", "max:3048"],
        ]);

        $filePath = $this->uploadFile($request->file("file"));

        $productImage             = new ProductImage();
        $productImage->product_id = $product->id;
        $productImage->path       = $filePath;
        $productImage->order      = ProductImage::where("product_id", 1)->max("order") + $product->id;
        $productImage->save();

        return response()->json([
            "status"  => "success",
            "id"      => $productImage->id,
            "path"    => asset($filePath),
            "message" => "Image uploaded successfully",
        ]);
    }

    public function destroyImage(int $id)
    {
        $image = ProductImage::findOrFail($id);
        $this->deleteFile($image->path);
        $image->delete();

        return response()->json([
            "status"  => "success",
            "message" => "Image deleted successfully",
        ]);
    }

    public function imagesReorder(Request $request)
    {
        foreach ($request->images as $image) {
            ProductImage::where("id", $image["id"])->update([
                "order" => $image["order"],
            ]);
        }
    }
}
