@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">🛒 Orders</h2>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">➕ New Order</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>User</th>
                    <th>Total ($)</th>
                    <th>Status</th>
                    <th>Placed On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($order->status == 'pending') bg-warning 
                                @elseif($order->status == 'processing') bg-info 
                                @elseif($order->status == 'completed') bg-success 
                                @else bg-danger @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
