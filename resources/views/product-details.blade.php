@extends('layouts.app')

@section('title', $product->name . ' - ShoeCommerce')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            @php
    $image = $product->productImages->first()->image 
        ?? 'https://via.placeholder.com/500x400?text=No+Image';
@endphp

<img src="{{ asset('storage/' . $image) }}" 
     alt="{{ $product->name }}" 
     class="img-fluid rounded shadow">

        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted">Brand: {{ $product->brand ?? 'N/A' }}</p>
            <p class="h4 fw-bold text-success mb-3">${{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>

            <!-- Add to Cart -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-dark btn-lg">
                    🛒 Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
