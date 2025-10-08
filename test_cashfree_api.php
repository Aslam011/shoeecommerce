<?php

require __DIR__.'/vendor/autoload.php';

$appId = 'TEST1009536209069b06bcee13c3314026359001';
$secretKey = 'cfsk_ma_test_eb114ea0d55239b8c23afd9334d242df_ed2e3356';
$apiVersion = '2023-08-01';

$ch = curl_init('https://sandbox.cashfree.com/pg/orders');

$data = [
    'order_id' => 'TEST_ORDER_' . time(),
    'order_amount' => 100.00,
    'order_currency' => 'INR',
    'customer_details' => [
        'customer_id' => 'TEST_CUSTOMER_1',
        'customer_email' => 'test@test.com',
        'customer_phone' => '9999999999',
    ],
];

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
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

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n";

$json = json_decode($response, true);
if (isset($json['message'])) {
    echo "\nError Message: " . $json['message'] . "\n";
}
if (isset($json['type'])) {
    echo "Error Type: " . $json['type'] . "\n";
}
