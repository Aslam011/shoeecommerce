@extends('layouts.app')

@section('title', 'Order Placed Successfully')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Success Header -->
            <div class="success-header text-center mb-4">
                <div class="success-icon mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="display-5 fw-bold text-success mb-2">Order Placed Successfully!</h1>
                <p class="lead text-muted">Thank you for your purchase</p>
            </div>

            <!-- Order Details Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>Order Details
                        </h5>
                        <span class="badge bg-light text-success">Order #{{ $order->id }}</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Order Info Grid -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="info-box p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-hashtag me-1"></i>Tracking Number
                                </small>
                                <strong class="text-primary">{{ $order->tracking_number }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-box p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-calendar me-1"></i>Order Date
                                </small>
                                <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-credit-card me-1"></i>Payment Method
                                </small>
                                <strong class="text-capitalize">{{ $order->payment_method }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-info-circle me-1"></i>Payment Status
                                </small>
                                @if($order->payment_status === 'paid')
                                    <span class="badge bg-success">Paid ✓</span>
                                @elseif($order->payment_status === 'payment_confirmed')
                                    <span class="badge bg-info">Payment Confirmed - Verifying</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span>
                                @endif
                            </div>
                        </div>
                        @if($order->payment_transaction_id)
                        <div class="col-md-12 mt-3">
                            <div class="info-box p-3 bg-light rounded">
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-receipt me-1"></i>Transaction Reference ID
                                </small>
                                <strong class="small text-break">{{ $order->payment_transaction_id }}</strong>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Delivery Address -->
                    <div class="delivery-section mb-4 p-3 border rounded">
                        <h6 class="mb-3">
                            <i class="fas fa-map-marker-alt me-2 text-danger"></i>Delivery Address
                        </h6>
                        <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                        <p class="mb-1">{{ $order->address }}</p>
                        <p class="mb-1">{{ $order->city }}, {{ $order->state }} - {{ $order->postal_code }}</p>
                        <p class="mb-1">{{ $order->country }}</p>
                        <p class="mb-0 text-muted">
                            <i class="fas fa-phone me-1"></i>{{ $order->customer_phone }}
                        </p>
                    </div>

                    <!-- Order Items -->
                    <h6 class="mb-3">
                        <i class="fas fa-box me-2 text-primary"></i>Order Items ({{ $order->items->count() }})
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                    <td class="text-end">₹{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">₹{{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tax (7%):</strong></td>
                                    <td class="text-end">₹{{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="3" class="text-end"><strong class="fs-5">Total Amount:</strong></td>
                                    <td class="text-end"><strong class="fs-5 text-success">₹{{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Status Note -->
                    @if($order->payment_status === 'payment_confirmed')
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-hourglass-half me-2"></i>
                        <strong>Payment Verification:</strong> Your payment confirmation has been received. Our team will verify the payment and process your order within 1-2 hours.
                    </div>
                    @endif

                    <!-- Expected Delivery -->
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-truck me-2"></i>
                        <strong>Expected Delivery:</strong> {{ $order->created_at->addDays(5)->format('d M Y') }}
                    </div>

                    <!-- What's Next -->
                    <div class="card bg-light border-0 mt-4">
                        <div class="card-body">
                            <h6 class="mb-3">
                                <i class="fas fa-question-circle me-2"></i>What happens next?
                            </h6>
                            <ul class="mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    You'll receive an order confirmation email at <strong>{{ $order->customer_email }}</strong>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-shipping-fast text-success me-2"></i>
                                    Your order will be processed and shipped within 1-2 business days
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-bell text-warning me-2"></i>
                                    You'll receive shipping updates via SMS and email
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card-footer bg-white py-3">
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        @auth('customer')
                            <a href="{{ route('customer.orders') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>View My Orders
                            </a>
                        @endauth
                        <a href="{{ route('shop.index') }}" class="btn btn-success">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Go to Home
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="row g-3 mt-3">
                <div class="col-md-4">
                    <div class="trust-card text-center p-3">
                        <i class="fas fa-shield-alt text-success fa-2x mb-2"></i>
                        <h6>100% Secure</h6>
                        <small class="text-muted">Your payment is safe</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card text-center p-3">
                        <i class="fas fa-truck text-primary fa-2x mb-2"></i>
                        <h6>Fast Delivery</h6>
                        <small class="text-muted">Ships within 1-2 days</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="trust-card text-center p-3">
                        <i class="fas fa-undo text-info fa-2x mb-2"></i>
                        <h6>Easy Returns</h6>
                        <small class="text-muted">30-day return policy</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-header .success-icon i {
    font-size: 5rem;
    color: #10b981;
    animation: scaleIn 0.5s ease-out;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.info-box {
    transition: all 0.3s ease;
    border-left: 3px solid #10b981;
}

.info-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.delivery-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.trust-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.trust-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}
</style>

<script>
// Confetti animation (optional)
setTimeout(() => {
    console.log('🎉 Order placed successfully!');
}, 100);
</script>
@endsection
