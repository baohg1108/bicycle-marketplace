<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    //
    public function index(): View
    {
        $featuredCategories = Category::withCount("products")->whereIsFeatured(true)->take(15)->get();
        $sliders            = Slider::whereIsActive(true)->get();
        return view("frontend.home.index", compact('featuredCategories', 'sliders'));
    }
}
