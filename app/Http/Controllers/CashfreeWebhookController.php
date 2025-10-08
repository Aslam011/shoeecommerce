<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\CashfreeService;
use Illuminate\Support\Facades\Log;

class CashfreeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $rawPayload = $request->getContent();
        $signature = $request->header('x-webhook-signature');
        $timestamp = $request->header('x-webhook-timestamp');
        
        Log::info('Cashfree Webhook Received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
            'raw_payload' => $rawPayload,
        ]);

        if ($signature && $timestamp) {
            $cashfreeService = new CashfreeService();
            
            if (!$cashfreeService->verifyWebhookSignature($rawPayload, $signature, $timestamp)) {
                Log::error('Cashfree Webhook: Invalid Signature', [
                    'signature' => $signature,
                    'timestamp' => $timestamp,
                ]);
                
                return response()->json(['error' => 'Invalid signature'], 401);
            }
            
            Log::info('Cashfree Webhook: Signature Verified ✓');
        }

        $data = $request->all();
        
        $eventType = $data['type'] ?? null;
        
        Log::info('Cashfree Webhook Event Type', [
            'event_type' => $eventType,
        ]);

        if ($eventType === 'PAYMENT_SUCCESS_WEBHOOK' || $eventType === 'ORDER_PAID') {
            $this->handlePaymentSuccess($data);
        } elseif (isset($data['data']['order'])) {
            $this->handleOrderUpdate($data);
        } else {
            Log::warning('Cashfree Webhook: Unknown event type', [
                'event_type' => $eventType,
                'data' => $data,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    private function handlePaymentSuccess($data)
    {
        $orderData = $data['data']['order'] ?? $data['order'] ?? null;
        
        if (!$orderData) {
            Log::error('Cashfree Webhook: No order data found');
            return;
        }

        $cashfreeOrderId = $orderData['order_id'] ?? null;
        $orderStatus = $orderData['order_status'] ?? null;
        
        Log::info('Cashfree Webhook: Processing Payment', [
            'cashfree_order_id' => $cashfreeOrderId,
            'order_status' => $orderStatus,
        ]);

        if (!$cashfreeOrderId) {
            Log::error('Cashfree Webhook: Missing order_id');
            return;
        }

        preg_match('/ORDER_(\d+)_/', $cashfreeOrderId, $matches);
        
        if (!isset($matches[1])) {
            Log::error('Cashfree Webhook: Could not extract local order ID', [
                'cashfree_order_id' => $cashfreeOrderId,
            ]);
            return;
        }

        $localOrderId = $matches[1];
        $order = Order::find($localOrderId);

        if (!$order) {
            Log::error('Cashfree Webhook: Order not found in database', [
                'local_order_id' => $localOrderId,
            ]);
            return;
        }

        if ($orderStatus === 'PAID') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);

            if (session('pending_cart_clear')) {
                $this->clearCart($order);
            }

            Log::info('Cashfree Webhook: Order marked as PAID', [
                'order_id' => $order->id,
                'cashfree_order_id' => $cashfreeOrderId,
            ]);
        } else {
            Log::info('Cashfree Webhook: Order status updated', [
                'order_id' => $order->id,
                'status' => $orderStatus,
            ]);
        }
    }

    private function handleOrderUpdate($data)
    {
        $orderData = $data['data']['order'] ?? null;
        
        if (!$orderData) {
            return;
        }

        $cashfreeOrderId = $orderData['order_id'] ?? null;
        $orderStatus = $orderData['order_status'] ?? null;

        if (!$cashfreeOrderId) {
            return;
        }

        preg_match('/ORDER_(\d+)_/', $cashfreeOrderId, $matches);
        
        if (isset($matches[1])) {
            $localOrderId = $matches[1];
            $order = Order::find($localOrderId);

            if ($order && $orderStatus === 'PAID') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);

                Log::info('Cashfree Webhook: Order marked as PAID via order update', [
                    'order_id' => $order->id,
                ]);
            }
        }
    }

    private function clearCart($order)
    {
        if ($order->customer_id) {
            \App\Models\Cart::where('customer_id', $order->customer_id)->delete();
            Log::info('Cart cleared for customer', ['customer_id' => $order->customer_id]);
        }
    }
}
