<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Create Cashfree Payment Order
     */
    public function createCashfreePayment(Order $order)
    {
        $gateway = PaymentGateway::where('name', 'cashfree')->where('is_active', true)->first();
        
        if (!$gateway || !$gateway->isConfigured()) {
            throw new \Exception('Cashfree payment gateway is not configured');
        }

        $apiUrl = $gateway->environment === 'live' 
            ? 'https://sandbox.cashfree.com/pg/orders' 
            : 'https://sandbox.cashfree.com/pg/orders';

        $orderData = [
            'order_id' => 'ORDER_' . $order->id . '_' . time(),
            'order_amount' => (float) $order->total,
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id' => 'CUST_' . ($order->user_id ?? 'GUEST_' . $order->id),
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
            ],
            'order_meta' => [
                'return_url' => route('order.success', $order->id),
                'notify_url' => route('payment.webhook.cashfree'),
            ],
        ];

        $response = Http::withHeaders([
            'x-client-id' => $gateway->api_key,
            'x-client-secret' => $gateway->api_secret,
            'x-api-version' => '2023-08-01',
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $orderData);

        if ($response->successful()) {
            $data = $response->json();
            
            // Store payment session
            $order->update([
                'payment_session_id' => $data['payment_session_id'] ?? null,
            ]);

            return [
                'success' => true,
                'payment_session_id' => $data['payment_session_id'],
                'order_id' => $data['order_id'],
                'payment_link' => $data['payment_link'] ?? null,
            ];
        }

        throw new \Exception('Failed to create Cashfree payment: ' . $response->body());
    }

    /**
     * Get Cashfree Payment Status
     */
    public function getCashfreePaymentStatus($orderId)
    {
        $gateway = PaymentGateway::where('name', 'cashfree')->where('is_active', true)->first();
        
        if (!$gateway) {
            return ['status' => 'failed', 'message' => 'Gateway not configured'];
        }

        $apiUrl = $gateway->environment === 'live' 
            ? "https://sandbox.cashfree.com/pg/orders/ORDER_{$orderId}_*/payments" 
            : "https://sandbox.cashfree.com/pg/orders/ORDER_{$orderId}_*/payments";

        $response = Http::withHeaders([
            'x-client-id' => $gateway->api_key,
            'x-client-secret' => $gateway->api_secret,
            'x-api-version' => '2023-08-01',
        ])->get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'status' => 'success',
                'payment_status' => $data[0]['payment_status'] ?? 'PENDING',
                'data' => $data,
            ];
        }

        return ['status' => 'failed', 'message' => 'Failed to fetch payment status'];
    }

    /**
     * Verify Cashfree Payment
     */
    public function verifyCashfreePayment($orderId)
    {
        $status = $this->getCashfreePaymentStatus($orderId);
        
        if ($status['status'] === 'success' && isset($status['payment_status'])) {
            return in_array($status['payment_status'], ['SUCCESS', 'PAID']);
        }

        return false;
    }
}
