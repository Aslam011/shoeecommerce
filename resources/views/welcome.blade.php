@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-shoe-prints fa-5x text-primary mb-4"></i>
            </div>
            <h1 class="display-4 fw-bold mb-4">Welcome to ShoeCommerce</h1>
            <p class="lead mb-4">Your one-stop shop for premium footwear</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">Browse Products</a>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg">View Cart</a>
            </div>
        </div>
    </div>
</div>
@endsection