<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Live search API (for dropdown suggestions)
     */
    public function liveSearch(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'products' => [],
                'count' => 0
            ]);
        }

        $products = Product::with('productImages')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($product) {
                $firstImage = $product->productImages->first();
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'slug' => $product->slug ?? $product->id,
                    'image' => $firstImage ? asset('storage/' . $firstImage->image) : 'https://via.placeholder.com/100',
                    'stock' => $product->stock ?? 0,
                ];
            });

        return response()->json([
            'success' => true,
            'products' => $products,
            'count' => $products->count()
        ]);
    }

    /**
     * Full search page
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('shop.index');
        }

        $products = Product::with('productImages', 'category')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(12);

        return view('shop.search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}
