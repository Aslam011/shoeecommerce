@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white text-center">
                    <h4>🔑 Verify OTP</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.otp.submit') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-3">
                            <label for="otp_code" class="form-label">Enter OTP</label>
                            <input type="text" name="otp_code" class="form-control" required maxlength="6">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Verify</button>
                        </div>

                        <div class="text-center mt-3">
                            Didn’t get OTP? <a href="#">Resend</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
