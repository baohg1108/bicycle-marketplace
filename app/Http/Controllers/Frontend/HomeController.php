<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\HeroBanner;
use App\Models\PopularCategory;
use App\Models\Product;
use App\Models\ProductSection;
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
        $productSections      = ProductSection::first();

        $productSectionsIds = [
            $productSections?->category_one,
            $productSections?->category_two,
            $productSections?->category_three,
        ];

        // $hotProducts = Product::with('primaryImage')->withAvg('reviews', 'rating')->whereIsHot(true)->latest()->take(4)->get();
        // $newProducts = Product::with('primaryImage')->withAvg('reviews', 'rating')->whereIsNew(true)->latest()->take(4)->get();
        // $featuredProducts = Product::with('primaryImage')->withAvg('reviews', 'rating')->whereIsFeatured(true)->latest()->take(4)->get();
        // $topRatedProducts = Product::with('primaryImage')->whereHas('reviews')->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc')->take(4)->get();

        $hotProducts      = Product::with('primaryImage')->whereIsHot(true)->latest()->take(4)->get();
        $newProducts      = Product::with('primaryImage')->whereIsNew(true)->latest()->take(4)->get();
        $featuredProducts = Product::with('primaryImage')->whereIsFeatured(true)->latest()->take(4)->get();

        $productSectionsProducts = $this->productsByCategory($productSectionsIds, false);

        return view("frontend.home.index", compact('featuredCategories', 'sliders', "heroBanner", "popularCategories", "popularProducts", "flashSale", "flashSaleProducts", "productSections", "productSectionsProducts", "hotProducts", "newProducts", "featuredProducts"));
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
