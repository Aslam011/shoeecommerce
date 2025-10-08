<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$order = App\Models\Order::find(33);

if ($order) {
    echo "Current payment_session_id: " . $order->payment_session_id . "\n";
    echo "Length: " . strlen($order->payment_session_id) . "\n";
    
    // Check if it ends with duplicate "payment"
    if (substr($order->payment_session_id, -14) === 'paymentpayment') {
        echo "Found duplicate 'payment' at the end\n";
        $fixed = substr($order->payment_session_id, 0, -7);
        echo "Fixed session ID: " . $fixed . "\n";
        
        $order->payment_session_id = $fixed;
        $order->save();
        
        echo "✅ Order 33 payment_session_id has been fixed!\n";
    } else {
        echo "No duplicate found\n";
    }
} else {
    echo "Order 33 not found\n";
}
