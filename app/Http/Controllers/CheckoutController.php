<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\PaymentGateway;
use App\Services\CashfreeService;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
{
    $customer = auth('customer')->user(); // logged-in customer

    $request->validate([
        'address'      => 'required|string',
        'city'         => 'required|string|max:255',
        'state'        => 'required|string|max:255',
        'postal_code'  => 'required|string|max:20',
        'country'      => 'required|string|max:100',
        'type'         => 'required|in:home,work,other',
    ]);

    // Save address with customer's existing info
    $customer->addresses()->create([
        'first_name'   => $customer->first_name,
        'last_name'    => $customer->last_name,
        'email'        => $customer->email,
        'phone'        => $customer->phone,
        'address'      => $request->address,
        'city'         => $request->city,
        'state'        => $request->state,
        'postal_code'  => $request->postal_code,
        'country'      => $request->country,
        'type'         => $request->type,
        'is_default'   => $request->input('is_default', 0),
    ]);

    return redirect()->back()->with('success', 'Address added successfully!');
}

    // Show checkout page
    public function index()
    {
        $customer = auth('customer')->user();
        $cartItems = [];

        if ($customer) {
            // Authenticated user - get from database
            $cartItems = \App\Models\Cart::with(['product.productImages'])
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
                $product = \App\Models\Product::with('productImages')->find($productId);
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

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = isset($item['price']) ? (float)$item['price'] : 0;
            $qty   = isset($item['quantity']) ? (int)$item['quantity'] : 1;
            $subtotal += $price * $qty;
        }

        $shipping = $subtotal >= 2000 ? 0 : 10;
        $taxRate = ((float) config('app.tax_rate', 7)) / 100;
        $tax = round($subtotal * $taxRate, 2);

        $couponDiscount = (float) session('coupon_discount', 0);
        $total = round($subtotal + $shipping + $tax - $couponDiscount, 2);

        // 🔥 Fetch customer addresses
        $addresses = [];
        if (auth('customer')->check()) {
            $addresses = auth('customer')->user()->addresses;
        }

        // 🔥 Fetch active payment gateways
        $paymentGateways = PaymentGateway::getActive();

        return view('checkout', compact(
            'cartItems', 'subtotal', 'shipping', 'tax', 'total', 'addresses', 'paymentGateways'
        ));
    }

    // Place order - now redirects to payment page
    public function placeOrder(Request $request)
    {
        // Get active payment methods dynamically
        $activeGateways = PaymentGateway::where('is_active', true)->pluck('name')->toArray();
        $paymentMethods = !empty($activeGateways) ? implode(',', $activeGateways) : 'razorpay,phonepe,paytm,cashfree';

        // Handle both guest and authenticated user address formats
        if ($request->has('use_new_address') && $request->use_new_address == '1') {
            // Guest user with new address
            $request->merge([
                'first_name' => explode(' ', $request->guest_full_name)[0] ?? '',
                'last_name' => explode(' ', $request->guest_full_name)[1] ?? '',
                'email' => $request->guest_email ?? 'guest@example.com',
                'phone' => $request->guest_mobile_number,
                'address' => $request->guest_flat_house_no . ', ' . $request->guest_area_street,
                'city' => $request->guest_town_city,
                'state' => $request->guest_state,
                'postal_code' => $request->guest_pincode,
                'country' => $request->guest_country ?? 'India',
                'address_type' => 'home',
            ]);
        }

        $request->validate([
            'selected_address' => 'nullable|exists:addresses,id',
            'first_name'    => 'nullable|required_without:selected_address|string|max:255',
            'last_name'     => 'nullable|required_without:selected_address|string|max:255',
            'email'         => 'nullable|required_without:selected_address|email',
            'phone'         => 'nullable|required_without:selected_address|string|max:20',
            'address'       => 'nullable|required_without:selected_address|string',
            'city'          => 'nullable|required_without:selected_address|string|max:100',
            'state'         => 'nullable|required_without:selected_address|string|max:100',
            'postal_code'   => 'nullable|required_without:selected_address|string|max:20',
            'country'       => 'nullable|required_without:selected_address|string|max:100',
            'address_type'  => 'nullable|required_without:selected_address|string|in:home,work,other',
            'payment_method' => 'required|string|in:' . $paymentMethods,
        ]);

        $customer = auth('customer')->user();
        $cartItems = [];

        // Check if this is a buy now order
        if (session()->has('buy_now')) {
            $buyNowItem = session('buy_now');
            $cartItems = [[
                'id' => $buyNowItem['product_id'],
                'product_id' => $buyNowItem['product_id'],
                'name' => $buyNowItem['product_name'],
                'price' => $buyNowItem['price'],
                'quantity' => $buyNowItem['quantity'],
            ]];
        } elseif ($customer) {
            // Authenticated user - get from database
            $cartItems = \App\Models\Cart::with('product')
                ->where('customer_id', $customer->id)
                ->get()
                ->map(function ($cartItem) {
                    return [
                        'id' => $cartItem->product_id,
                        'product_id' => $cartItem->product_id,
                        'name' => $cartItem->product->name ?? 'Product',
                        'price' => $cartItem->product->price ?? 0,
                        'quantity' => $cartItem->quantity,
                    ];
                })
                ->toArray();
        } else {
            // Guest user - get from session
            $cartItems = session('cart', []);
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        // Get address details
        if ($request->selected_address) {
            $address = \App\Models\Address::findOrFail($request->selected_address);
            $addressData = [
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'postal_code' => $address->postal_code,
                'country' => $address->country,
                'address_type' => $address->type,
            ];
        } else {
            $addressData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
                'address_type' => $request->address_type,
            ];
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = isset($item['price']) ? (float)$item['price'] : 0;
            $qty   = isset($item['quantity']) ? (int)$item['quantity'] : 1;
            $subtotal += $price * $qty;
        }

        $shipping = $subtotal >= 2000 ? 0 : 10;
        $taxRate = ((float) config('app.tax_rate', 7)) / 100;
        $tax = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        // Create order with pending status
        $order = Order::create([
            'user_id'        => null, // Not using users table, storing customer info directly
            'customer_id'    => $customer ? $customer->id : null,
            'customer_name'  => $addressData['first_name'] . ' ' . $addressData['last_name'],
            'customer_email' => $addressData['email'],
            'customer_phone' => $addressData['phone'],
            'address'        => $addressData['address'],
            'city'           => $addressData['city'],
            'state'          => $addressData['state'],
            'postal_code'    => $addressData['postal_code'],
            'country'        => $addressData['country'],
            'address_type'   => $addressData['address_type'],
            'payment_method' => $request->payment_method,
            'subtotal'       => $subtotal,
            'shipping'       => $shipping,
            'tax'            => $tax,
            'total'          => $total,
            'status'         => 'pending_payment',
            'tracking_number' => 'ORD-' . strtoupper(Str::random(8)),
        ]);

        // Save order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'] ?? $item['id'],
                'product_name' => $item['name'] ?? 'Product',
                'quantity'   => $item['quantity'] ?? 1,
                'price'      => $item['price'] ?? 0,
                'total'      => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
            ]);
        }

        // Store order ID and cart info in session for payment processing
        session([
            'pending_order_id' => $order->id,
            'pending_cart_clear' => true
        ]);

        // Redirect to payment page based on method
        return redirect()->route('payment.process', [
            'order' => $order->id,
            'method' => $request->payment_method
        ]);
    }

    // Show payment page
    public function showPayment($orderId, $method)
    {
        try {
            $order = Order::with('items')->findOrFail($orderId);

            // Verify order belongs to current customer (if logged in)
            if (auth('customer')->check() && $order->customer_id && $order->customer_id !== auth('customer')->id()) {
                abort(403, 'You do not have permission to view this order.');
            }

            // For Cashfree, create payment session
            if ($method === 'cashfree') {
                // Check if order already has payment session
                if ($order->payment_session_id) {
                    $paymentSessionId = $order->payment_session_id;
                } else {
                    $cashfreeService = new CashfreeService();
                    
                    $cashfreeOrderId = 'ORDER_' . $order->id . '_' . time();
                    
                    $result = $cashfreeService->createOrder(
                        $cashfreeOrderId,
                        $order->total,
                        $order->customer_id ?? 'GUEST_' . time(),
                        $order->customer_email,
                        $order->customer_phone,
                        $order->customer_name,
                        $order->id
                    );
                    
                    if (!$result['success']) {
                        \Log::error('Cashfree API Error', [
                            'order_id' => $order->id,
                            'error' => $result['message']
                        ]);
                        
                        $order->update(['status' => 'failed']);
                        
                        return redirect()->route('checkout.index')
                            ->with('error', 'Payment gateway error: ' . $result['message'] . '. Please try again.');
                    }
                    
                    $paymentSessionId = $result['data']['payment_session_id'];
                    
                    $order->update([
                        'payment_session_id' => $paymentSessionId,
                        'payment_transaction_id' => $cashfreeOrderId,
                    ]);
                }
                
                $isSandbox = config('cashfree.environment') === 'sandbox';
                
                return view('payment.cashfree', compact('order', 'paymentSessionId', 'isSandbox'));
            }

            return view('payment.' . $method, compact('order'));
        } catch (\Exception $e) {
            \Log::error('Show Payment Error', [
                'order_id' => $orderId,
                'method' => $method,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('checkout.index')
                ->with('error', 'Error loading payment page: ' . $e->getMessage());
        }
    }

    // Customer Confirms Payment
    public function confirmPayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order status to payment_confirmed (pending admin verification)
        $order->update([
            'payment_status' => 'payment_confirmed',
            'status' => 'pending_verification',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmation received',
            'order_id' => $order->id,
        ]);
    }

    // Payment Success Handler (for webhook/admin verification)
    public function paymentSuccess(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update order status to paid
        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment processed successfully',
            'order_id' => $order->id,
        ]);
    }

    // Order Success Page
    public function orderSuccess($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);

        // Verify order belongs to current customer (if logged in)
        if (auth('customer')->check() && $order->customer_id && $order->customer_id !== auth('customer')->id()) {
            abort(403, 'You do not have permission to view this order.');
        }

        return view('order-success', compact('order'));
    }

    // Check Payment Status (for polling)
    public function checkPaymentStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        return response()->json([
            'status' => $order->payment_status,
            'order_status' => $order->status,
        ]);
    }

    // Generate QR Code
    public function generateQR(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if (!$order->payment_session_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment session not found',
            ], 400);
        }

        $cashfreeService = new CashfreeService();
        $result = $cashfreeService->getQRCode($order->payment_session_id);
        
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'data' => $result['data'],
        ]);
    }

    // Check Cashfree Payment Status
    public function checkCashfreeStatus($orderId)
    {
        $order = Order::findOrFail($orderId);

        if (!$order->payment_transaction_id) {
            return response()->json([
                'success' => false,
                'message' => 'No transaction ID found',
            ]);
        }

        $cashfreeService = new CashfreeService();
        $result = $cashfreeService->checkOrderStatus($order->payment_transaction_id);
        
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 500);
        }
        
        $orderStatus = $result['data']['order_status'] ?? null;
        
        if ($orderStatus === 'PAID') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
            
            // Clear cart only after successful payment
            $this->clearPendingCart();
            
            return response()->json([
                'success' => true,
                'status' => 'PAID',
                'redirect' => route('order.success', ['order' => $order->id]),
            ]);
        }
        
        return response()->json([
            'success' => true,
            'status' => $orderStatus,
        ]);
    }

    // Cashfree Webhook Handler
    public function cashfreeWebhook(Request $request)
    {
        $signature = $request->header('x-webhook-signature');
        $timestamp = $request->header('x-webhook-timestamp');
        $postData = $request->getContent();
        
        \Log::info('Cashfree Webhook Received:', [
            'signature' => $signature,
            'timestamp' => $timestamp,
            'data' => $request->all(),
        ]);

        // Verify signature
        $cashfreeService = new CashfreeService();
        if ($signature && $timestamp) {
            if (!$cashfreeService->verifyWebhookSignature($postData, $signature, $timestamp)) {
                \Log::error('Cashfree Webhook: Invalid signature');
                return response()->json(['error' => 'Invalid signature'], 401);
            }
        }

        $data = $request->all();
        
        if (isset($data['data']['order']['order_id'])) {
            preg_match('/ORDER_(\d+)_/', $data['data']['order']['order_id'], $matches);
            if (isset($matches[1])) {
                $orderId = $matches[1];
                $order = Order::find($orderId);
                
                if ($order) {
                    $orderStatus = $data['data']['order']['order_status'] ?? null;
                    
                    if ($orderStatus === 'PAID') {
                        $order->update([
                            'payment_status' => 'paid',
                            'status' => 'processing',
                        ]);
                        
                        // Clear cart on successful payment
                        session(['pending_cart_clear' => true]);
                        $this->clearPendingCart();
                        
                        \Log::info('Order #' . $orderId . ' marked as PAID via webhook');
                    }
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    // Buy Now - Direct checkout for single product
    public function buyNow(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = \App\Models\Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        // Check stock
        if ($product->stock < $quantity) {
            return back()->with('error', 'Insufficient stock available!');
        }

        // Store buy now product in session
        session([
            'buy_now' => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'total' => $product->price * $quantity,
            ]
        ]);

        return redirect()->route('checkout.buyNowCheckout');
    }

    // Buy Now Checkout Page
    public function buyNowCheckout()
    {
        $buyNowItem = session('buy_now');
        
        if (!$buyNowItem) {
            return redirect()->route('shop.index')->with('error', 'No item selected for buy now!');
        }

        $customer = auth('customer')->user();
        
        // Convert buy now item to cart format
        $cartItems = [[
            'id' => $buyNowItem['product_id'],
            'product_id' => $buyNowItem['product_id'],
            'name' => $buyNowItem['product_name'],
            'price' => $buyNowItem['price'],
            'quantity' => $buyNowItem['quantity'],
        ]];

        // Calculate totals
        $subtotal = $buyNowItem['total'];
        $shipping = $subtotal >= 2000 ? 0 : 10;
        $taxRate = ((float) config('app.tax_rate', 7)) / 100;
        $tax = round($subtotal * $taxRate, 2);
        $total = round($subtotal + $shipping + $tax, 2);

        $addresses = [];
        if ($customer) {
            $addresses = $customer->addresses;
        }

        $paymentGateways = PaymentGateway::getActive();

        return view('checkout', compact(
            'cartItems', 'subtotal', 'shipping', 'tax', 'total', 'addresses', 'paymentGateways'
        ));
    }

    // Helper to clear cart after successful payment session creation
    private function clearPendingCart()
    {
        if (session('pending_cart_clear')) {
            $customer = auth('customer')->user();
            
            if (session()->has('buy_now')) {
                session()->forget('buy_now');
            } elseif ($customer) {
                \App\Models\Cart::where('customer_id', $customer->id)->delete();
            } else {
                session()->forget('cart');
            }
            
            session()->forget('pending_cart_clear');
        }
    }
}
