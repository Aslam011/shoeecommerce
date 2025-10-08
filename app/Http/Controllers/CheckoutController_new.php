<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
    {
        $cartItems = session('cart', []);
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = (float)($item['price'] ?? 0);
            $qty   = (int)($item['quantity'] ?? 1);
            $subtotal += $price * $qty;
        }

        $shipping = $subtotal >= 2000 ? 0 : 100;
        $taxRate = (float) config('app.tax_rate', 18) / 100;
        $tax = round($subtotal * $taxRate, 2);

        $couponDiscount = (float) session('coupon_discount', 0);
        $total = round($subtotal + $shipping + $tax - $couponDiscount, 2);

        return view('checkout', compact(
            'cartItems', 'subtotal', 'shipping', 'tax', 'couponDiscount', 'total'
        ));
    }

    // Place order - redirects to payment page
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'postal_code'   => 'required|string|max:20',
            'country'       => 'required|string|max:100',
            'address_type'  => 'required|string|in:home,work,other',
            'payment_method'=> 'required|string|in:paytm,phonepe',
            'save_address'  => 'nullable|boolean',
        ]);

        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = (float)($item['price'] ?? 0);
            $qty   = (int)($item['quantity'] ?? 1);
            $subtotal += $price * $qty;
        }

        $shipping = $subtotal >= 2000 ? 0 : 100;
        $taxRate = (float) config('app.tax_rate', 18) / 100;
        $tax = round($subtotal * $taxRate, 2);
        $couponDiscount = (float) session('coupon_discount', 0);
        $total = round($subtotal + $shipping + $tax - $couponDiscount, 2);

        $order = Order::create([
            'user_id'        => auth('customer')->check() ? auth('customer')->id() : null,
            'customer_name'  => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'country'        => $request->country,
            'address_type'   => $request->address_type,
            'payment_method' => $request->payment_method,
            'subtotal'       => $subtotal,
            'shipping'       => $shipping,
            'tax'            => $tax,
            'discount'       => $couponDiscount,
            'total'          => $total,
            'status'         => 'pending_payment',
            'tracking_number'=> 'ORD-' . strtoupper(Str::random(8)),
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id'   => $item['id'] ?? null,
                'product_name' => $item['name'] ?? 'Product',
                'quantity'     => $item['quantity'] ?? 1,
                'price'        => $item['price'] ?? 0,
                'total'        => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
            ]);
        }

        if ($request->save_address && auth('customer')->check()) {
            auth('customer')->user()->addresses()->create([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'city'        => $request->city,
                'state'       => $request->state,
                'postal_code' => $request->postal_code,
                'country'     => $request->country,
                'type'        => $request->address_type,
            ]);
        }

        session(['pending_order_id' => $order->id]);

        return redirect()->route('payment.process', [
            'order' => $order->id,
            'method'=> $request->payment_method
        ]);
    }

    // Show payment page
    public function showPayment($orderId, $method)
    {
        $order = Order::with('items')->findOrFail($orderId);

        if (auth('customer')->check()) {
            if ($order->user_id !== auth('customer')->id()) {
                abort(403);
            }
        } elseif ($order->user_id !== null) {
            abort(403);
        }

        return view('payment.' . $method, compact('order'));
    }
}
