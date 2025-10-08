@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">{{ $productsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">{{ $ordersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Customers</h5>
                    <p class="card-text">{{ $customersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-danger shadow">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text">₹{{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Orders -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0">🛒 Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name ?? $order->customer->email ?? 'N/A' }}</td>
                                <td>₹{{ number_format($order->total, 2) }}</td>
                                <td>
                                    @if($order->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($order->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info">Processing</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center text-muted">No orders yet</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Admin Users -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="mb-0">👥 Admin Users</h5>
                </div>
                <div class="card-body">
                    @if($admins->count() > 0)
                    <ul class="list-group">
                        @foreach($admins as $admin)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $admin->email }}</strong>
                                <br>
                                <small class="text-muted">Role: Admin</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">Admin</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-center text-muted">No admin users found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
