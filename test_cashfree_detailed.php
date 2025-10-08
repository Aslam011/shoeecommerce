<?php

require __DIR__.'/vendor/autoload.php';

$appId = 'TEST1009536209069b06bcee13c3314026359001';
$secretKey = 'cfsk_ma_test_eb114ea0d55239b8c23afd9334d242df_ed2e3356';
$apiVersion = '2023-08-01';
$baseUrl = 'https://sandbox.cashfree.com';

echo "=== CASHFREE API TEST ===\n\n";

// Test 1: Create Order
echo "1. Testing Create Order API...\n";
$orderId = 'TEST_ORDER_' . time();

$ch = curl_init($baseUrl . '/pg/orders');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'order_id' => $orderId,
        'order_amount' => 100.00,
        'order_currency' => 'INR',
        'customer_details' => [
            'customer_id' => 'TEST_CUST_' . time(),
            'customer_email' => 'test@test.com',
            'customer_phone' => '9999999999',
        ],
    ]),
    CURLOPT_HTTPHEADER => [
        'x-client-id: ' . $appId,
        'x-client-secret: ' . $secretKey,
        'x-api-version: ' . $apiVersion,
        'Content-Type: application/json',
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Code: $httpCode\n";

if ($httpCode == 200) {
    $json = json_decode($response, true);
    $paymentSessionId = $json['payment_session_id'] ?? null;
    echo "   ✅ Order created successfully!\n";
    echo "   Order ID: " . ($json['order_id'] ?? 'N/A') . "\n";
    echo "   Payment Session ID: " . substr($paymentSessionId, 0, 50) . "...\n";
    echo "   Session ID Length: " . strlen($paymentSessionId) . "\n";
    
    // Test 2: Try to get QR code with this session ID
    echo "\n2. Testing QR Code Generation API...\n";
    
    $ch2 = curl_init($baseUrl . '/pg/orders/sessions');
    curl_setopt_array($ch2, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'payment_session_id' => $paymentSessionId,
            'payment_method' => [
                'upi' => [
                    'channel' => 'qrcode',
                ],
            ],
        ]),
        CURLOPT_HTTPHEADER => [
            'x-client-id: ' . $appId,
            'x-client-secret: ' . $secretKey,
            'x-api-version: ' . $apiVersion,
            'Content-Type: application/json',
        ],
    ]);
    
    $qrResponse = curl_exec($ch2);
    $qrHttpCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    curl_close($ch2);
    
    echo "   HTTP Code: $qrHttpCode\n";
    
    if ($qrHttpCode == 200) {
        $qrJson = json_decode($qrResponse, true);
        echo "   ✅ QR API call successful!\n";
        echo "   Response: " . json_encode($qrJson, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "   ❌ QR API failed!\n";
        echo "   Response: $qrResponse\n";
    }
    
    // Test 3: Try with different API version
    echo "\n3. Testing with API version 2025-01-01...\n";
    
    $ch3 = curl_init($baseUrl . '/pg/orders/sessions');
    curl_setopt_array($ch3, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'payment_session_id' => $paymentSessionId,
            'payment_method' => [
                'upi' => [
                    'channel' => 'qrcode',
                ],
            ],
        ]),
        CURLOPT_HTTPHEADER => [
            'x-client-id: ' . $appId,
            'x-client-secret: ' . $secretKey,
            'x-api-version: 2025-01-01',
            'Content-Type: application/json',
        ],
    ]);
    
    $qrResponse3 = curl_exec($ch3);
    $qrHttpCode3 = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
    curl_close($ch3);
    
    echo "   HTTP Code: $qrHttpCode3\n";
    
    if ($qrHttpCode3 == 200) {
        $qrJson3 = json_decode($qrResponse3, true);
        echo "   ✅ QR API with new version successful!\n";
        
        if (isset($qrJson3['data']['payload']['qrcode'])) {
            echo "   ✅ QR CODE FOUND!\n";
            echo "   QR Code URL: " . substr($qrJson3['data']['payload']['qrcode'], 0, 80) . "...\n";
        } else {
            echo "   Response: " . json_encode($qrJson3, JSON_PRETTY_PRINT) . "\n";
        }
    } else {
        echo "   ❌ QR API with new version also failed!\n";
        echo "   Response: $qrResponse3\n";
    }
    
} else {
    $json = json_decode($response, true);
    echo "   ❌ Order creation failed!\n";
    echo "   Response: $response\n";
}

echo "\n=== TEST COMPLETE ===\n";
