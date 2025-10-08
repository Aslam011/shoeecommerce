@extends('layouts.app')

@section('title', 'Payment - PhonePe')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-mobile-alt me-2"></i>Complete Your Payment
                    </h3>
                    <p class="mb-0 mt-2 opacity-75">PhonePe Secure Payment Gateway</p>
                </div>

                <div class="card-body p-5">
                    <!-- Order Summary -->
                    <div class="order-summary-box mb-4 p-4 bg-light rounded">
                        <h5 class="mb-3"><i class="fas fa-receipt me-2"></i>Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Order ID:</span>
                            <strong>#{{ $order->id }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Amount to Pay:</span>
                            <strong class="text-success fs-4">₹{{ number_format($order->total, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="small text-muted">
                            <i class="fas fa-box me-1"></i>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="text-center">
                        <form id="phonepePaymentForm" action="#" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="amount" value="{{ $order->total }}">
                            
                            <button type="submit" class="btn btn-lg btn-purple px-5 py-3" id="payNowBtn">
                                <i class="fas fa-lock me-2"></i>Pay ₹{{ number_format($order->total, 2) }} with PhonePe
                            </button>
                        </form>

                        <p class="mt-4 text-muted small">
                            <i class="fas fa-shield-alt me-1"></i>Secured by PhonePe
                        </p>

                        <div class="payment-methods-icons mt-4">
                            <span class="badge bg-primary me-2 p-2">
                                <i class="fas fa-mobile-alt me-1"></i>UPI
                            </span>
                            <span class="badge bg-info me-2 p-2">
                                <i class="fas fa-credit-card me-1"></i>Cards
                            </span>
                            <span class="badge bg-warning me-2 p-2">
                                <i class="fas fa-university me-1"></i>Net Banking
                            </span>
                            <span class="badge bg-secondary p-2">
                                <i class="fas fa-wallet me-1"></i>Wallets
                            </span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Order Items -->
                    <h6 class="mb-3"><i class="fas fa-shopping-bag me-2"></i>Order Items</h6>
                    <div class="order-items">
                        @foreach($order->items as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                            <div>
                                <strong>{{ $item->product_name }}</strong>
                                <small class="text-muted d-block">Qty: {{ $item->quantity }}</small>
                            </div>
                            <span>₹{{ number_format($item->total, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer text-center py-3">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Cancel & Return to Shop
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #5f259f 0%, #3c1361 100%);
}

.order-summary-box {
    border-left: 4px solid #5f259f;
}

.btn-purple {
    background: linear-gradient(135deg, #5f259f, #3c1361);
    border: none;
    color: white;
    box-shadow: 0 4px 15px rgba(95, 37, 159, 0.3);
    transition: all 0.3s ease;
}

.btn-purple:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(95, 37, 159, 0.4);
    color: white;
}
</style>

<script>
// PhonePe Payment Integration will go here
document.getElementById('phonepePaymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const btn = document.getElementById('payNowBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing Payment...';
    
    // TODO: Integrate PhonePe SDK here
    // For now, simulate payment success
    
    fetch('{{ route("payment.success", $order->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: '{{ $order->id }}',
            payment_status: 'success'
        })
    })
    .then(() => {
        window.location.href = '{{ route("order.success", $order->id) }}';
    })
    .catch(() => {
        window.location.href = '{{ route("order.success", $order->id) }}';
    });
});
</script>
@endsection
