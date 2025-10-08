<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreePaymentService
{
    private $gateway;
    private $apiUrl;

    public function __construct()
    {
        $this->gateway = PaymentGateway::where('name', 'cashfree')->where('is_active', true)->first();
        
        if (!$this->gateway) {
            throw new \Exception('Cashfree payment gateway is not configured or not active');
        }

        // Set API URL based on environment
        $this->apiUrl = $this->gateway->environment === 'live' 
            ? 'https://api.cashfree.com/pg' 
            : 'https://sandbox.cashfree.com/pg';
    }

    /**
     * Create Cashfree Order
     */
    public function createOrder(Order $order)
    {
        $orderId = 'ORDER_' . $order->id . '_' . time();

        $payload = [
            'order_id' => $orderId,
            'order_amount' => (float) $order->total,
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => 'CUST_' . ($order->customer_id ?? 'GUEST_' . $order->id),
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
            ],
            'order_meta' => [
                'return_url' => route('order.success', $order->id),
                'notify_url' => route('payment.webhook.cashfree'),
            ],
        ];

        Log::info('Cashfree Create Order Request:', $payload);

        $response = Http::withHeaders([
            'x-client-id' => $this->gateway->api_key,
            'x-client-secret' => $this->gateway->api_secret,
            'x-api-version' => '2023-08-01',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/orders', $payload);

        Log::info('Cashfree Create Order Response:', $response->json());

        if ($response->successful()) {
            $data = $response->json();
            
            // Store payment session ID in order
            $order->update([
                'payment_session_id' => $data['payment_session_id'] ?? null,
                'payment_transaction_id' => $orderId,
            ]);

            return [
                'success' => true,
                'payment_session_id' => $data['payment_session_id'],
                'order_id' => $data['order_id'],
                'cf_order_id' => $data['cf_order_id'] ?? null,
            ];
        }

        $error = $response->json();
        Log::error('Cashfree Create Order Failed:', $error);
        
        throw new \Exception($error['message'] ?? 'Failed to create Cashfree payment order');
    }

    /**
     * Get QR Code for UPI Payment
     */
    public function getQRCode($paymentSessionId)
    {
        $payload = [
            'payment_session_id' => $paymentSessionId,
            'payment_method' => [
                'upi' => [
                    'channel' => 'qrcode',
                ],
            ],
        ];

        Log::info('Cashfree Get QR Request:', $payload);

        $response = Http::withHeaders([
            'x-client-id' => $this->gateway->api_key,
            'x-client-secret' => $this->gateway->api_secret,
            'x-api-version' => '2023-08-01',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/orders/pay', $payload);

        Log::info('Cashfree Get QR Response:', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Check different possible response structures
            $qrCode = $data['data']['payload']['qrcode'] 
                   ?? $data['payload']['qrcode'] 
                   ?? $data['qr_code']
                   ?? $data['data']['qr']
                   ?? null;

            if ($qrCode) {
                return [
                    'success' => true,
                    'qr_code' => $qrCode,
                    'upi_intent' => $data['data']['payload']['upi_intent'] ?? $data['upi_intent'] ?? null,
                ];
            }
        }

        $error = $response->json();
        Log::error('Cashfree QR Generation Failed:', $error);
        throw new \Exception($error['message'] ?? 'Failed to generate QR code');
    }

    /**
     * Check Payment Status
     */
    public function checkPaymentStatus($cfOrderId)
    {
        $response = Http::withHeaders([
            'x-client-id' => $this->gateway->api_key,
            'x-client-secret' => $this->gateway->api_secret,
            'x-api-version' => '2023-08-01',
        ])->get($this->apiUrl . '/orders/' . $cfOrderId);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'success' => true,
                'order_status' => $data['order_status'] ?? 'ACTIVE',
                'payment_status' => $data['payment_status'] ?? null,
                'data' => $data,
            ];
        }

        return ['success' => false];
    }

    /**
     * Verify Webhook Signature
     */
    public function verifyWebhookSignature($postData, $signature, $timestamp)
    {
        $signatureData = $timestamp . $postData;
        $computedSignature = base64_encode(hash_hmac('sha256', $signatureData, $this->gateway->api_secret, true));
        
        return hash_equals($computedSignature, $signature);
    }
}
