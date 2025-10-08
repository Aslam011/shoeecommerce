<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$customer = App\Models\Customer::first();
$product = App\Models\Product::first();

$order = App\Models\Order::create([
    'customer_id' => $customer->id,
    'customer_name' => $customer->name,
    'customer_email' => $customer->email,
    'customer_phone' => $customer->phone,
    'address' => '123 Test Street',
    'city' => 'Delhi',
    'state' => 'Delhi',
    'postal_code' => '110001',
    'country' => 'India',
    'address_type' => 'home',
    'payment_method' => 'cashfree',
    'subtotal' => $product->price,
    'shipping' => 10,
    'tax' => 7,
    'total' => $product->price + 10 + 7,
    'status' => 'pending_payment',
    'tracking_number' => 'ORD-TEST-' . time(),
]);

$order->items()->create([
    'product_id' => $product->id,
    'product_name' => $product->name,
    'quantity' => 1,
    'price' => $product->price,
    'total' => $product->price,
]);

echo "✅ Test order created: #{$order->id}\n";
echo "Total: ₹{$order->total}\n";
echo "\nAccess payment page at:\n";
echo "http://localhost:8080/shoecommerce2/public/payment/{$order->id}/cashfree\n";
