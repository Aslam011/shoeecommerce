@extends('layouts.admin')

@section('title', 'Payment Gateways')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-credit-card me-2"></i>Payment Gateway Settings
        </h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @foreach($gateways as $gateway)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-gradient d-flex justify-content-between align-items-center {{ $gateway->is_active ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-wallet me-2"></i>{{ $gateway->display_name }}
                            @if($gateway->supports_upi)
                                <span class="badge bg-light text-dark ms-2">
                                    <i class="fas fa-mobile-alt me-1"></i>UPI Supported
                                </span>
                            @endif
                        </h5>
                        <small class="opacity-75">{{ ucfirst($gateway->environment) }} Mode</small>
                    </div>
                    <div class="form-check form-switch">
                        <form action="{{ route('admin.payment-gateways.toggle', $gateway) }}" method="POST" class="d-inline">
                            @csrf
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                {{ $gateway->is_active ? 'checked' : '' }}
                                onchange="this.form.submit()"
                                style="width: 50px; height: 25px; cursor: pointer;">
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    @if(!$gateway->isConfigured())
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Not Configured!</strong> Please add your API credentials below.
                        </div>
                    @else
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Configured!</strong> This gateway is ready to use.
                        </div>
                    @endif

                    <form action="{{ route('admin.payment-gateways.update', $gateway) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Environment Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-cog me-2"></i>Environment
                            </label>
                            <select name="environment" class="form-select" required>
                                <option value="test" {{ $gateway->environment == 'test' ? 'selected' : '' }}>Test/Sandbox</option>
                                <option value="live" {{ $gateway->environment == 'live' ? 'selected' : '' }}>Live/Production</option>
                            </select>
                        </div>

                        <!-- Razorpay Fields -->
                        @if($gateway->name == 'razorpay')
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2"></i>API Key (Key ID)
                                </label>
                                <input 
                                    type="text" 
                                    name="api_key" 
                                    class="form-control" 
                                    value="{{ $gateway->api_key }}" 
                                    placeholder="rzp_test_xxxxxxxxxxxxx"
                                    required>
                                <small class="text-muted">Get from Razorpay Dashboard → Settings → API Keys</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2"></i>API Secret (Key Secret)
                                </label>
                                <input 
                                    type="password" 
                                    name="api_secret" 
                                    class="form-control" 
                                    value="{{ $gateway->api_secret }}" 
                                    placeholder="••••••••••••••••"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-shield-alt me-2"></i>Webhook Secret (Optional)
                                </label>
                                <input 
                                    type="text" 
                                    name="webhook_secret" 
                                    class="form-control" 
                                    value="{{ $gateway->webhook_secret }}" 
                                    placeholder="whsec_xxxxxxxxxxxxx">
                                <small class="text-muted">For webhook signature verification</small>
                            </div>
                        @endif

                        <!-- PhonePe Fields -->
                        @if($gateway->name == 'phonepe')
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-store me-2"></i>Merchant ID
                                </label>
                                <input 
                                    type="text" 
                                    name="merchant_id" 
                                    class="form-control" 
                                    value="{{ $gateway->merchant_id }}" 
                                    placeholder="M123456789"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2"></i>Salt Key
                                </label>
                                <input 
                                    type="password" 
                                    name="salt_key" 
                                    class="form-control" 
                                    value="{{ $gateway->salt_key }}" 
                                    placeholder="••••••••••••••••"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-2"></i>Salt Index
                                </label>
                                <input 
                                    type="text" 
                                    name="salt_index" 
                                    class="form-control" 
                                    value="{{ $gateway->salt_index }}" 
                                    placeholder="1"
                                    required>
                                <small class="text-muted">Usually "1" for production</small>
                            </div>
                        @endif

                        <!-- Paytm Fields -->
                        @if($gateway->name == 'paytm')
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-store me-2"></i>Merchant ID (MID)
                                </label>
                                <input 
                                    type="text" 
                                    name="merchant_id" 
                                    class="form-control" 
                                    value="{{ $gateway->merchant_id }}" 
                                    placeholder="xxxxxxxxxxxxx"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2"></i>Merchant Key
                                </label>
                                <input 
                                    type="password" 
                                    name="api_key" 
                                    class="form-control" 
                                    value="{{ $gateway->api_key }}" 
                                    placeholder="••••••••••••••••"
                                    required>
                            </div>
                        @endif

                        <!-- Cashfree Fields -->
                        @if($gateway->name == 'cashfree')
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2"></i>App ID (Client ID)
                                </label>
                                <input 
                                    type="text" 
                                    name="api_key" 
                                    class="form-control" 
                                    value="{{ $gateway->api_key }}" 
                                    placeholder="CF_xxxxxxxxxxxxx"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2"></i>Secret Key (Client Secret)
                                </label>
                                <input 
                                    type="password" 
                                    name="api_secret" 
                                    class="form-control" 
                                    value="{{ $gateway->api_secret }}" 
                                    placeholder="••••••••••••••••"
                                    required>
                                <small class="text-muted">Get from Cashfree Dashboard → Credentials</small>
                            </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Save Configuration
                            </button>
                        </div>
                    </form>

                    <!-- Documentation Links -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-book me-2"></i>Documentation
                        </h6>
                        <div class="d-flex gap-2">
                            @if($gateway->name == 'razorpay')
                                <a href="https://razorpay.com/docs/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt me-1"></i>Docs
                                </a>
                                <a href="https://dashboard.razorpay.com/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            @endif

                            @if($gateway->name == 'phonepe')
                                <a href="https://developer.phonepe.com/v1/docs" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt me-1"></i>Docs
                                </a>
                                <a href="https://business.phonepe.com/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            @endif

                            @if($gateway->name == 'paytm')
                                <a href="https://developer.paytm.com/docs/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt me-1"></i>Docs
                                </a>
                                <a href="https://dashboard.paytm.com/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            @endif

                            @if($gateway->name == 'cashfree')
                                <a href="https://docs.cashfree.com/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-external-link-alt me-1"></i>Docs
                                </a>
                                <a href="https://merchant.cashfree.com/" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Help Section -->
    <div class="card mt-4 shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-question-circle me-2"></i>Setup Instructions
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">🔐 Security Best Practices</h6>
                    <ul class="small">
                        <li>Always use <strong>Test Mode</strong> during development</li>
                        <li>Keep your API keys and secrets <strong>confidential</strong></li>
                        <li>Never commit credentials to version control</li>
                        <li>Switch to <strong>Live Mode</strong> only when ready for production</li>
                        <li>Enable webhook signatures for added security</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">✅ Testing UPI Payments</h6>
                    <ul class="small">
                        <li>All gateways support <strong>UPI payments</strong></li>
                        <li>Test in sandbox mode before going live</li>
                        <li>Use test UPI IDs provided by payment gateways</li>
                        <li>Verify webhook integration for payment status</li>
                        <li>Check transaction logs in gateway dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
}
</style>
@endsection
