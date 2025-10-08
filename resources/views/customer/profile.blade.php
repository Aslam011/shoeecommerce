@extends('layouts.app')

@section('title', 'My Account - ShoeCommerce')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                    <h2 class="mb-0 fw-bold">
                        <i class="fas fa-user-circle me-2"></i>My Account
                    </h2>
                    <p class="mb-0 opacity-75">Welcome back, {{ $customer->name }}!</p>
                </div>
                
                <div class="card-body p-5">
                    <!-- Profile Info Section -->
                    <div class="row mb-5">
                        <div class="col-md-4 text-center mb-4">
                            <div class="avatar-placeholder rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                                <i class="fas fa-user text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="fw-bold text-primary">{{ $customer->name }}</h4>
                            <p class="text-muted">Customer ID: #{{ $customer->id }}</p>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-card p-3 bg-light rounded-3">
                                        <h6 class="text-muted mb-2"><i class="fas fa-envelope me-2"></i>Email Address</h6>
                                        <p class="mb-0 fw-semibold">{{ $customer->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-card p-3 bg-light rounded-3">
                                        <h6 class="text-muted mb-2"><i class="fas fa-phone me-2"></i>Phone Number</h6>
                                        <p class="mb-0 fw-semibold">{{ $customer->phone }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-card p-3 bg-light rounded-3">
                                        <h6 class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i>Delivery Location</h6>
                                        <p class="mb-0 text-muted">Location not specified yet. You can update your delivery address in your order history or contact support.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-success bg-opacity-10 rounded-3">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-success">Account Verified</h6>
                                    <p class="mb-0 small text-success">Your account is verified and active</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 bg-warning bg-opacity-10 rounded-3">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-warning">Joined on {{ $customer->created_at->format('M d, Y') }}</h6>
                                    <p class="mb-0 small text-muted">Member since</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <a href="{{ route('orders') }}" class="btn btn-outline-primary w-100 py-3 rounded-3">
                                <i class="fas fa-shopping-bag me-2"></i>
                                My Orders
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-success w-100 py-3 rounded-3">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Shopping Cart
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('customer.profile.edit') }}" class="btn btn-outline-info w-100 py-3 rounded-3">
                                <i class="fas fa-edit me-2"></i>
                                Edit Profile
                            </a>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-danger w-100 py-3 rounded-3" onclick="confirmLogout()">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </button>
                        </div>
                    </div>

                    <!-- Logout Form (Hidden) -->
                    <form id="logoutForm" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <script>
                        function confirmLogout() {
                            if (confirm('Are you sure you want to logout?')) {
                                document.getElementById('logoutForm').submit();
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .info-card {
        transition: all 0.3s ease;
        border-left: 4px solid #0d6efd;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .avatar-placeholder {
        border: 3px solid #e9ecef;
    }
    .card {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
    }
</style>
@endsection
