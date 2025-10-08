<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Web cart page - return Blade view with data
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $cartItems = [];
        $subtotal = 0;
        $tax = 0;
        $total = 0;

        if ($customer) {
            // Authenticated user - get from database
            $cartItems = Cart::with(['product.productImages'])
                ->where('customer_id', $customer->id)
                ->get()
                ->map(function ($cartItem) {
                    $product = $cartItem->product;
                    $image = null;
                    
                    if ($product) {
                        $mainImage = $product->productImages->where('is_main', true)->first();
                        if ($mainImage) {
                            $image = asset('storage/' . $mainImage->image);
                        }
                    }

                    return [
                        'id' => $cartItem->id,
                        'product_id' => $cartItem->product_id,
                        'name' => $product->name ?? 'Unknown Product',
                        'price' => $product->price ?? 0,
                        'quantity' => $cartItem->quantity,
                        'image' => $image,
                    ];
                })
                ->toArray();
        } else {
            // Guest user - get from session
            $sessionCart = session('cart', []);
            foreach ($sessionCart as $productId => $item) {
                $product = Product::with('productImages')->find($productId);
                if ($product) {
                    $mainImage = $product->productImages->where('is_main', true)->first();
                    $image = $mainImage ? asset('storage/' . $mainImage->image) : null;
                    
                    $cartItems[] = [
                        'id' => $productId, // Use product ID for guest
                        'product_id' => $productId,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'image' => $image,
                    ];
                }
            }
        }

        // Calculate totals
        $subtotal = array_reduce($cartItems, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        
        $taxRate = 0.07; // 7%
        $tax = $subtotal * $taxRate;
        $shipping = count($cartItems) > 0 ? 10.00 : 0;
        $total = $subtotal + $tax + $shipping;

        return view('cart.index', compact('cartItems', 'subtotal', 'tax', 'total', 'shipping'));
    }

    // Add to cart - FIXED VERSION (no Cart::add())
    public function store(Request $request)
    {
        Log::info('Cart Store Request:', $request->all());
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        Log::info("Adding product ID {$productId} with quantity {$quantity}");

        try {
            $product = Product::findOrFail($productId);
            
            if (!$product) {
                Log::error("Product {$productId} not found");
                return back()->withErrors(['error' => 'Product not found.']);
            }

            // Check stock
            $totalQuantity = $quantity;
            $customer = Auth::guard('customer')->user();

            if ($customer) {
                // Authenticated user - check existing cart quantity
                $existingCart = Cart::where('customer_id', $customer->id)
                    ->where('product_id', $productId)
                    ->first();
                
                if ($existingCart) {
                    $totalQuantity += $existingCart->quantity;
                }
                
                if ($product->stock < $totalQuantity) {
                    Log::warning("Insufficient stock for customer {$customer->id}: requested {$totalQuantity}, available {$product->stock}");
                    return back()->withErrors(['quantity' => "Only {$product->stock} available. Cannot add more."]);
                }
                
                // Update or create cart item - NO Cart::add()
                $cartItem = Cart::updateOrCreate(
                    [
                        'customer_id' => $customer->id,
                        'product_id' => $productId,
                    ],
                    ['quantity' => $totalQuantity]
                );
                
                Log::info("Updated/created cart item {$cartItem->id} for customer {$customer->id}");
                
                return redirect()->route('cart.index')
                    ->with('success', "Added {$quantity} × {$product->name} to cart!");
                    
            } else {
                // Guest user - session cart
                $cart = session('cart', []);
                
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $quantity;
                    $totalQuantity = $cart[$productId]['quantity'];
                } else {
                    $cart[$productId] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->productImages->where('is_main', true)->first()?->image,
                    ];
                }
                
                if ($product->stock < $totalQuantity) {
                    Log::warning("Insufficient stock for guest: requested {$totalQuantity}, available {$product->stock}");
                    return back()->withErrors(['quantity' => "Only {$product->stock} available. Cannot add more."]);
                }
                
                session(['cart' => $cart]);
                Log::info("Added product {$productId} to session cart. Total items: " . count($cart));
                
                return redirect()->route('cart.index')
                    ->with('success', "Added {$quantity} × {$product->name} to cart!");
            }
            
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to add product to cart. Please try again.']);
        }
    }

    // Update cart item quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $customer = Auth::guard('customer')->user();

        try {
            if ($customer) {
                $cartItem = Cart::where('customer_id', $customer->id)
                    ->where('id', $id)
                    ->firstOrFail();
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
                
                Log::info("Updated cart item {$id} quantity to {$request->quantity}");
            } else {
                $cart = session('cart', []);
                if (isset($cart[$id])) {
                    $cart[$id]['quantity'] = $request->quantity;
                    session(['cart' => $cart]);
                    Log::info("Updated session cart item {$id} quantity to {$request->quantity}");
                } else {
                    return redirect()->route('cart.index')->withErrors(['error' => 'Item not found.']);
                }
            }

            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update cart. Please try again.']);
        }
    }

    // Remove item from cart
    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        try {
            if ($customer) {
                $deleted = Cart::where('customer_id', $customer->id)->where('id', $id)->delete();
                if ($deleted) {
                    Log::info("Deleted cart item {$id} for customer {$customer->id}");
                }
            } else {
                $cart = session('cart', []);
                if (isset($cart[$id])) {
                    unset($cart[$id]);
                    session(['cart' => $cart]);
                    Log::info("Removed item {$id} from session cart");
                }
            }

            return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
        } catch (\Exception $e) {
            Log::error('Cart destroy error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove item. Please try again.']);
        }
    }

    // Clear entire cart
    public function clear()
    {
        $customer = Auth::guard('customer')->user();

        try {
            if ($customer) {
                Cart::where('customer_id', $customer->id)->delete();
                Log::info("Cleared cart for customer {$customer->id}");
            } else {
                session()->forget('cart');
                Log::info("Cleared session cart");
            }

            return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to clear cart. Please try again.']);
        }
    }
}