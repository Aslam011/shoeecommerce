@extends('layouts.app')

@section('title', $product->name . ' - ShoeCommerce')

@section('content')
<div class="container my-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image (Square Box on Left) -->
        <div class="col-md-6 d-flex justify-content-center">
            <div class="border rounded shadow-sm d-flex align-items-center justify-content-center"
                 style="width: 400px; height: 400px; overflow: hidden;">
                 
                @if($product->productImages->count() > 0)
                    <img src="{{ asset('storage/' . $product->productImages->first()->image) }}"
                         alt="{{ $product->name }}"
                         class="img-fluid rounded"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400x400?text=No+Image"
                         alt="No Image"
                         class="img-fluid rounded"
                         style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
        </div>

        <!-- Product Details (Right Side) -->
        <div class="col-md-6">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted">Brand: {{ $product->brand ?? 'N/A' }}</p>
            <p class="h4 fw-bold text-success mb-3">₹{{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>

            <!-- Add to Cart -->
            <form method="POST" action="{{ route('cart.add') }}"> - @csrf - <input type="hidden" name="product_id" value="{{ $product->id }}"> - <input type="number" name="quantity" value="1" min="1"> - <button type="submit" class="btn btn-primary">Add to Cart</button> - </form>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-5">
        <h4 class="mb-4">You may also like</h4>
        <div class="row g-3">
            @forelse($related as $item)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <div style="width: 100%; height: 200px; overflow: hidden;">
                            <img src="{{ $item->productImages->first() ? asset('storage/'.$item->productImages->first()->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                 class="w-100 h-100"
                                 style="object-fit: cover;"
                                 alt="{{ $item->name }}">
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold">{{ $item->name }}</h6>
                            <p class="text-muted">₹{{ number_format($item->price, 2) }}</p>
                            <a href="{{ route('product.details', $item->id) }}" class="btn btn-sm btn-outline-dark">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No related products found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
