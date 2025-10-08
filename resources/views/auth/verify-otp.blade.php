@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm mx-auto" style="max-width: 400px;">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">🔐 Verify Your Email</h5>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

           <form method="POST" action="{{ route('customer.verifyOtp', $customer->id) }}">
    @csrf
    <div class="mb-3">
        <label for="otp" class="form-label">Enter OTP</label>
        <input type="text" name="otp" id="otp" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Verify</button>
</form>

            <hr>
            <form method="POST" action="{{ route('customer.resendOtp', $customer->id) }}">
                @csrf
                <button type="submit" class="btn btn-link w-100">Resend OTP</button>
            </form>
        </div>
    </div>
</div>
@endsection
