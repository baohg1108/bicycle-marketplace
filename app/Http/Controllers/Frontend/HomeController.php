<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\HeroBanner;
use App\Models\PopularCategory;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    //
    public function index(): View
    {
        $featuredCategories   = Category::withCount("products")->whereIsFeatured(true)->take(15)->get();
        $sliders              = Slider::whereIsActive(true)->get();
        $heroBanner           = HeroBanner::first();
        $popularCategoriesIds = PopularCategory::first()?->categories ?? [];
        $popularCategories    = Category::whereIn("id", $popularCategoriesIds)->get();
        $popularProducts      = $this->productsByCategory($popularCategoriesIds);
        $flashSale            = FlashSale::first();
        $flashSaleProducts    = Product::whereIn("id", $flashSale->products)->get();

        return view("frontend.home.index", compact('featuredCategories', 'sliders', "heroBanner", "popularCategories", "popularProducts", "flashSale", "flashSaleProducts"));
    }

    public function productsByCategory(array $categoryIds)
    {

        $results = [];

        foreach ($categoryIds as $categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $ids     = [$category->id];
                $ids     = array_merge($ids, $category->allChildrenIds());
                $product = Product::whereHas("categories", function ($query) use ($ids) {
                    $query->whereIn("categories.id", $ids);
                })->whereIsFeatured(true)->take(12)->get();
                $results[$categoryId] = $product;
            }
        }
        return $results;
    }
}
