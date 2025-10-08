<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // Show all products or products by category
    public function index(Request $request, Category $category = null)
    {
        $query = Product::with('productImages');

        // Filter by category if provided
        if ($category) {
            $query->where('category_id', $category->id);
        }

        // 🔍 Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 🏷️ Sorting
        if ($request->sort === 'low_high') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'high_low') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        // ✅ Paginate
        $products = $query->paginate(12);

        // All categories for sidebar/menu
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories', 'category'));
    }

    // Show single product page
    public function show($id)
    {
        $product = Product::with('productImages')->findOrFail($id);
        return view('product-details', compact('product'));
    }
}
