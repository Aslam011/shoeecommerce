@extends('layouts.admin')

@section('title', 'Edit Order')

@section('content')
<div class="container">
    <h2 class="mb-4">✏️ Edit Order #{{ $order->order_number }}</h2>

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Order Number</label>
            <input type="text" name="order_number" class="form-control" 
                   value="{{ $order->order_number }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Amount ($)</label>
            <input type="number" step="0.01" name="total" class="form-control" 
                   value="{{ $order->total }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Update Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
