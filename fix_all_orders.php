<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$orders = App\Models\Order::whereNotNull('payment_session_id')
    ->where('payment_session_id', 'like', '%paymentpayment')
    ->get();

echo "Found " . $orders->count() . " orders with duplicate 'payment'\n\n";

foreach ($orders as $order) {
    echo "Order #{$order->id}: ";
    $old = $order->payment_session_id;
    $fixed = substr($old, 0, -7); // Remove last 7 characters ("payment")
    
    $order->payment_session_id = $fixed;
    $order->save();
    
    echo "✅ Fixed\n";
}

echo "\nAll orders fixed!\n";
