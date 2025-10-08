@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">{{ $category->name }}</h2>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $product->productImages->first() ? asset('storage/'.$product->productImages->first()->image) : asset('storage/default.jpg') }}"
                         class="card-img-top" style="height:200px; object-fit:cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="fw-bold text-primary">₹{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('product.details', $product->id) }}" class="btn btn-dark btn-sm">View</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No products found in this category.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
