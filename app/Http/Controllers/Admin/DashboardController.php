<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $customersCount = Customer::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total') ?? 0;

        // Get recent orders (latest 5)
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Get all admin users
        $admins = Admin::latest()->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'ordersCount',
            'customersCount',
            'totalRevenue',
            'recentOrders',
            'admins'
        ));
    }
}
