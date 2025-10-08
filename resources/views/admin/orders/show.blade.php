@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🛒 Order #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">⬅ Back to Orders</a>
    </div>

    <!-- Order Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold">Order Information</h5>
            <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($order->status == 'pending') bg-warning 
                    @elseif($order->status == 'processing') bg-info 
                    @elseif($order->status == 'shipped') bg-primary 
                    @elseif($order->status == 'delivered') bg-success 
                    @elseif($order->status == 'cancelled') bg-danger 
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
            <p><strong>Placed On:</strong> {{ $order->created_at->format('d M, Y h:i A') }}</p>
        </div>
    </div>

    <!-- Shipping Info -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold">Shipping Details</h5>
            <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold">Ordered Items</h5>
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No items found for this order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Update Status Form -->
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold">Update Order Status</h5>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-primary">💾 Save Status</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
