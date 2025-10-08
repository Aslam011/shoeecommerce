<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CashfreeService
{
    private $appId;
    private $secretKey;
    private $baseUrl;
    private $apiVersion;

    public function __construct()
    {
        $this->appId = config('cashfree.app_id');
        $this->secretKey = config('cashfree.secret_key');
        $this->baseUrl = config('cashfree.api_base_url');
        $this->apiVersion = config('cashfree.api_version');
    }

    public function createOrder($orderId, $amount, $customerId, $customerEmail, $customerPhone, $customerName)
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => $this->apiVersion,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/pg/orders', [
                'order_id' => $orderId,
                'order_amount' => (float) $amount,
                'order_currency' => 'INR',
                'customer_details' => [
                    'customer_id' => (string) $customerId,
                    'customer_email' => $customerEmail,
                    'customer_phone' => $customerPhone,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('Cashfree Create Order Success', [
                    'payment_session_id' => $data['payment_session_id'] ?? 'N/A',
                    'order_id' => $data['order_id'] ?? 'N/A',
                ]);
                
                return [
                    'success' => true,
                    'data' => $data,
                ];
            }

            Log::error('Cashfree Create Order Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Failed to create order',
            ];
        } catch (\Exception $e) {
            Log::error('Cashfree Create Order Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getQRCode($paymentSessionId)
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => $this->apiVersion,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/pg/orders/sessions', [
                'payment_session_id' => $paymentSessionId,
                'payment_method' => [
                    'upi' => [
                        'channel' => 'qrcode',
                    ],
                ],
            ]);

            Log::info('Cashfree QR API Response', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data,
                ];
            }

            Log::error('Cashfree Get QR Code Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Failed to generate QR code',
            ];
        } catch (\Exception $e) {
            Log::error('Cashfree Get QR Code Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function checkOrderStatus($orderId)
    {
        try {
            $response = Http::withHeaders([
                'x-client-id' => $this->appId,
                'x-client-secret' => $this->secretKey,
                'x-api-version' => $this->apiVersion,
            ])->get($this->baseUrl . '/pg/orders/' . $orderId);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Cashfree Check Order Status Failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Failed to check order status',
            ];
        } catch (\Exception $e) {
            Log::error('Cashfree Check Order Status Exception', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verifyWebhookSignature($webhookData, $signature, $timestamp)
    {
        $signatureData = $timestamp . $webhookData;
        $computedSignature = base64_encode(hash_hmac('sha256', $signatureData, $this->secretKey, true));
        
        return hash_equals($computedSignature, $signature);
    }
}
