<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\Tag;
use App\Services\AlertService;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Label;

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
            'id' => $product->id,
            'redirect_url' => route('admin.products.edit', $product->id) .'#product-images',
            'status'  => 'success',
            'message' => 'Product created successfully',
        ]);
    }

    public function edit(int $id)
    {
        $product    = Product::findOrFail($id);
        $productCategoryIds = $product->categories->pluck('id')->toArray();
        $productTagIds = $product->tags->pluck('id')->toArray();
        $stores     = Store::select(["name", "id"])->get();
        $brands     = Brand::select(["name", "id"])->where("is_active", 1)->get();
        $tags       = Tag::where("is_active", 1)->get();
        $categories = Category::getNested();

        $attributesWithValues = $product?->attributeWithValues ?? [];
        // dd($attributesWithValues);
        return view("admin.product.edit", compact("stores", "brands", "tags", 'categories', 'product', 'productCategoryIds', 'productTagIds', 'attributesWithValues'));
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

    function update(ProductUpdateRequest $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->description = $request->content;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->special_price = $request->special_price;
        $product->special_price_start = $request->from_date;
        $product->special_price_end = $request->to_date;
        $product->qty = $request->quantity;
        $product->manage_stock = $request->has('manage_stock') ? 'yes' : 'no';
        $product->in_stock = $request->stock_status == 'in_stock' ? 1 : 0;
        $product->status = $request->status;
        $product->store_id = $request->store;
        $product->brand_id = $request->brand;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->is_hot = $request->has('is_hot') ? 1 : 0;
        $product->is_new = $request->has('is_new') ? 1 : 0;
        $product->save();

        /** Attach categories */
        $product->categories()->sync($request->categories);

        /** Attach tags */
        $product->tags()->sync($request->tags);

        AlertService::created();

        return response()->json([
            'id' => $product->id,
            'status' => 'success',
            'message' => 'Product updated successfully',
            'redirect_url' => route('admin.products.index')
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

    function storeAttributes(Request $request, Product $product)
{
    $request->validate([
        'attribute_name' => ['required', 'string', 'max:255'],
        'attribute_type' => ['required', 'string', 'in:text,color'],
    ]);

    DB::beginTransaction();

    try {
        if($request->filled('attribute_id')) {
            $this->updateExistingAttribute($request, $product);
        }else {
            $this->createNewAttribute($request, $product);
        }

        DB::commit();
        } catch (\Throwable $th) {
        DB::rollBack();
        return response()->json(['error' => $th->getMessage()], 500);
    }

        return $this->buildSuccessResponse($product);
    }

    function createNewAttribute(Request $request, Product $product) {
        $attribute = new Attribute();
        $attribute->name = $request->attribute_name;
        $attribute->type = $request->attribute_type;
        $attribute->save();

        $this->addAttributeValue($attribute, $request, $product);

    }


    function updateExistingAttribute(Request $request, Product $product)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);
        $attribute->name = $request->attribute_name;
        $attribute->type = $request->attribute_type;
        $attribute->save();

        // remove existing relations and values
        $this->clearAttributeData($attribute, $product);

        // add new attribute
        $this->addAttributeValue($attribute, $request, $product);
    }

    function clearAttributeData(Attribute $attribute, Product $product)
    {
        DB::table('product_attribute_values')
        ->where('product_id', $product->id)
        ->where('attribute_id', $attribute->id)
        ->delete();

        AttributeValue::where('attribute_id', $attribute->id)->delete();
    }

    function addAttributeValue(Attribute $attribute, Request $request, Product $product)
    {
        $labels = $request->label ?? [];

        foreach($labels as $index => $label){
            if(empty($label)) continue;
            
            $attributeValue = new AttributeValue();
            $attributeValue->attribute_id = $attribute->id;
            $attributeValue->value = $label;
            $attributeValue->color = $request->color_value[$index] ?? null;
            $attributeValue->save();

            // link to product
            DB::table('product_attribute_values')->insert([
                'product_id' => $product->id,
                'attribute_id' => $attribute->id,
                'attribute_value_id' => $attributeValue->id
            ]);
        }
    }

    function buildSuccessResponse(Product $product)
   {
        $product->refresh();

        $attributes = $product->attributeWithValues;


        $html = '';

        foreach ($attributes as $attribute) {

            $html .= view('admin.product.partials.attribute', compact('attribute', 'product'))->render();
        }

        return response()->json([
            'message' => 'Attribute generated successfully',
            'html' => $html
            
        ]);
    }

    function destroyAttribute(int $productId, int $attributeId)
    {
       try {
         $product = Product::findOrFail($productId);
        $attribute = Attribute::findOrFail($attributeId);

            $this->clearAttributeData($attribute, $product);

            $product->refresh();

            $attributes = $product->attributeWithValues;

            $attribute->delete();


            $html = '';

            foreach ($attributes as $attribute) {

                $html .= view('admin.product.partials.attribute', compact('attribute', 'product'))->render();
            }

            return response()->json([
                'message' => 'Attribute deleted successfully',
                'html' => $html
            ]);
       } catch(\Throwable $th){
        return response()->json(['error' => $th->getMessage()], 500);
       }
    }
}