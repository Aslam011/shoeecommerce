<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
{
    $cartItems = session('cart', []); // or however you store cart

    $subtotal = 0;
    foreach ($cartItems as $item) {
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $qty   = isset($item['quantity']) ? (int)$item['quantity'] : 1;
        $subtotal += $price * $qty;
    }

    $shipping = $subtotal >= 2000 ? 0 : 10; // free shipping rule
    $taxRate = ((float) config('app.tax_rate', 7)) / 100;
    $tax = round($subtotal * $taxRate, 2);

    $couponDiscount = (float) session('coupon_discount', 0);
    $total = round($subtotal + $shipping + $tax - $couponDiscount, 2);

    return view('checkout', compact(
        'cartItems', 'subtotal', 'shipping', 'tax', 'total'
    ));
}

    // Place order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'city'        => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'payment'     => 'required|string',
        ]);

        $cartItems = Cart::with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $order = Order::create([
            'user_id'        => auth()->id() ?? null,
            'name'           => $request->name,
            'address'        => $request->address,
            'city'           => $request->city,
            'postal_code'    => $request->postal_code,
            'payment_method' => $request->payment,
            'total'          => $total,
            'tracking_number'=> 'ORD-' . strtoupper(Str::random(8)),
        ]);

        // Save order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // Clear cart
        Cart::truncate();

        return redirect()->route('order.confirmation', $order->id);
    }
}
