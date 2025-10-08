<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Admin: Show all orders
    public function index()
    {
        $orders = Order::with('items.product', 'user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Admin: Edit order
    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    // Admin: Update order
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order updated successfully!');
    }

    // Admin: Delete order
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order deleted successfully!');
    }

    // Customer: Show my orders
   public function myOrders()
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You must log in first.');
    }

    $orders = auth()->user()->orders; 
    return view('account.orders', compact('orders'));
}
}
