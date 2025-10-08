@extends('layouts.app')

@section('title', 'Payment - Cashfree')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-wallet me-2"></i>Complete Your Payment
                    </h3>
                    <p class="mb-0 mt-2 opacity-75">Cashfree Secure Payment Gateway</p>
                </div>

                <div class="card-body p-5">
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

                    <div class="text-center">
                        <h5 class="mb-4">
                            <i class="fas fa-mobile-alt me-2 text-primary"></i>Scan QR to Pay via UPI
                        </h5>
                        
                        <div class="qr-container p-4 bg-white border rounded-3 shadow-sm d-inline-block" id="qrContainer">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading Payment...</span>
                            </div>
                            <p class="mt-3 text-muted">Initializing Cashfree Payment...</p>
                        </div>

                        <div id="qrDisplay" style="display: none;">
                            <div class="qr-container p-4 bg-white border rounded-3 shadow-sm d-inline-block">
                                <img id="qrImage" src="" alt="UPI QR Code" style="width: 280px; height: 280px;">
                                <p class="mt-3 mb-0 fw-bold text-success fs-5">
                                    Pay ₹{{ number_format($order->total, 2) }}
                                </p>
                                <p class="text-muted small mb-0">Scan with any UPI app</p>
                            </div>
                        </div>

                        <div id="paymentFrame" style="display: none;">
                            <div class="payment-frame-container">
                                <iframe id="cashfreeFrame" style="width: 100%; height: 500px; border: none;"></iframe>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-light rounded">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-info-circle me-2"></i>How to Pay
                            </h6>
                            <ol class="text-start mb-3">
                                <li class="mb-2">Open Google Pay, PhonePe, Paytm, or any UPI app</li>
                                <li class="mb-2">Scan the QR code above</li>
                                <li class="mb-2">Verify amount is <strong>₹{{ number_format($order->total, 2) }}</strong></li>
                                <li class="mb-0">Enter your UPI PIN and complete payment</li>
                            </ol>
                        </div>

                        <div class="mt-4 p-4 border border-success rounded bg-light">
                            <h6 class="text-success mb-3">
                                <i class="fas fa-check-circle me-2"></i>Payment Status
                            </h6>
                            <p class="mb-3">We are automatically checking for payment confirmation...</p>
                            <div class="spinner-border spinner-border-sm text-success" role="status" id="statusSpinner">
                                <span class="visually-hidden">Checking...</span>
                            </div>
                            <p class="text-muted small mt-2">Payment will be detected automatically once completed</p>
                        </div>

                        <div class="mt-3" id="paymentStatus" style="display: none;"></div>
                    </div>

                    <hr class="my-4">

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

                <div class="card-footer text-center py-3 bg-light">
                    <p class="text-muted small mb-2">
                        <i class="fas fa-shield-alt me-1"></i>
                        Secured by Cashfree Payment Gateway
                    </p>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Shop
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.order-summary-box {
    border-left: 4px solid #10b981;
}

.qr-container {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}
</style>

<!-- Cashfree SDK -->
<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

<script>
const orderId = '{{ $order->id }}';
const paymentSessionId = '{{ $paymentSessionId }}';
let statusCheckInterval;

document.addEventListener('DOMContentLoaded', function() {
    generateQRCode();
    startPaymentCheck();
});

function generateQRCode() {
    fetch('{{ route("payment.generate-qr", $order->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success && result.data) {
            document.getElementById('qrContainer').style.display = 'none';
            document.getElementById('qrDisplay').style.display = 'block';
            
            // Extract QR code from response
            const qrCode = result.data.data?.payload?.qrcode || result.data.payload?.qrcode;
            
            if (qrCode) {
                document.getElementById('qrImage').src = qrCode;
                console.log('✅ QR Code loaded successfully!');
            } else {
                console.error('QR code not found in response:', result);
                showError('QR code not available in API response');
            }
        } else {
            console.error('API Error:', result);
            showError(result.message || 'Failed to generate QR code');
        }
    })
    .catch(error => {
        console.error('QR Generation Error:', error);
        showError('Network error. Please refresh the page.');
    });
}

function showError(message) {
    document.getElementById('qrContainer').innerHTML = `
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            ${message}
        </div>
    `;
}

function startPaymentCheck() {
    statusCheckInterval = setInterval(function() {
        fetch('{{ route("payment.check-cashfree-status", $order->id) }}', {
            method: 'GET',
            headers: {'Accept': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.status === 'PAID') {
                clearInterval(statusCheckInterval);
                showPaymentSuccess(data.redirect);
            }
        })
        .catch(err => console.log('Status check:', err));
    }, 3000);
}

function showPaymentSuccess(redirectUrl) {
    document.getElementById('statusSpinner').style.display = 'none';
    document.getElementById('paymentStatus').innerHTML = `
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Payment Successful!</strong> Redirecting to order confirmation...
        </div>
    `;
    document.getElementById('paymentStatus').style.display = 'block';
    
    setTimeout(() => {
        window.location.href = redirectUrl || '{{ route("order.success", $order->id) }}';
    }, 2000);
}
</script>
@endsection
