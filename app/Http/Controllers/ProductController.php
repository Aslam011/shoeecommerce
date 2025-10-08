<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * ✅ Show all products (Admin)
     */
    public function index()
    {
        $products = Product::with(['productImages', 'category'])->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    /**
     * ✅ Show create product form
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * ✅ Store new product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:active,inactive',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create($request->except('images'));

        // ✅ Handle product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->productImages()->create(['image' => $path]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully!');
    }

    /**
     * ✅ Show edit product form
     */
    public function edit(Product $product)
    {
        $product->load(['productImages', 'category']);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * ✅ Update product
     */
    public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|in:active,inactive',
        'description' => 'nullable|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update product base fields
    $product->update($validated);

    // Reset main flag for existing images
    $product->productImages()->update(['is_main' => false]);

    // Case 1: Existing main image chosen
    if ($request->filled('main_image_id')) {
        $mainId = $request->main_image_id;
        $product->productImages()
            ->where('id', $mainId)
            ->update(['is_main' => true]);
    }

    // Case 2: New main image chosen
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('products', 'public');
            $isMain = ($request->main_new_index !== null && (int)$request->main_new_index === $index);

            $product->productImages()->create([
                'image' => $path,
                'is_main' => $isMain,
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
}

    /**
     * ✅ Show single product (Frontend)
     */
    public function show($id)
    {
        $product = Product::with(['productImages', 'category'])->findOrFail($id);
        return view('shop.show', compact('product'));
    }

    /**
     * ✅ Delete product
     */
    public function destroy($id)
    {
        $product = Product::with('productImages')->findOrFail($id);

        // Delete product images from storage + DB
        foreach ($product->productImages as $image) {
            Storage::delete('public/' . $image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
   public function destroyImage($productId, $imageId)
{
    $image = \App\Models\ProductImage::findOrFail($imageId);

    // Verify image belongs to this product
    if ($image->product_id != $productId) {
        abort(403, 'Image does not belong to this product');
    }

    // Delete physical file
    \Storage::delete('public/' . $image->image);

    // Delete database record
    $image->delete();

    return back()->with('success', 'Image deleted successfully!');
}

}

