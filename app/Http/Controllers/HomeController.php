<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('productImages')->latest()->take(8)->get();
        $sliders = Slider::where('is_active', true)->orderBy('order')->get();

        return view('home', compact('products', 'categories', 'sliders'));
    }
}
