@extends('layouts.home')

@section('title', 'Order Confirmation')

@section('content')
<div class="container my-5 text-center">
    <div class="card shadow-sm p-5">
        <h2 class="text-success">🎉 Thank You for Your Order!</h2>
        <p class="mt-3">Your order has been placed successfully. We’ll send you an email confirmation shortly.</p>

        <h5 class="mt-4">Order Tracking Number:</h5>
        <h3 class="fw-bold text-primary">#{{ $order->tracking_number }}</h3>

        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">Continue Shopping 🛍️</a>
            <a href="{{ route('customer.orders') }}" class="btn btn-success">View My Orders 📦</a>
        </div>
    </div>
</div>
@endsection
