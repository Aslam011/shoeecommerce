<?php

// Simulate Cashfree Webhook Test - Direct PHP call

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing webhook handler directly...\n\n";

// Sample Cashfree webhook payload for PAID order
$payload = [
    'type' => 'PAYMENT_SUCCESS_WEBHOOK',
    'data' => [
        'order' => [
            'order_id' => 'ORDER_3_1759771683',
            'order_amount' => 117.00,
            'order_currency' => 'INR',
            'order_status' => 'PAID',
        ],
        'payment' => [
            'cf_payment_id' => '123456789',
            'payment_status' => 'SUCCESS',
            'payment_amount' => 117.00,
            'payment_time' => date('Y-m-d H:i:s'),
        ],
    ],
];

// Create fake request (without signature for testing)
$request = new Illuminate\Http\Request();
$request->replace($payload);
$request->setMethod('POST');
$request->headers->set('Content-Type', 'application/json');

// Call webhook controller
$controller = new App\Http\Controllers\CashfreeWebhookController();

try {
    $response = $controller->handle($request);
    echo "✅ Webhook processed successfully!\n";
    echo "Response: " . $response->getContent() . "\n";
    
    // Check order status
    $order = App\Models\Order::find(3);
    if ($order) {
        echo "\nOrder #3 Status:\n";
        echo "  Payment Status: {$order->payment_status}\n";
        echo "  Order Status: {$order->status}\n";
        
        if ($order->payment_status === 'paid') {
            echo "\n🎉 SUCCESS! Order marked as PAID!\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
