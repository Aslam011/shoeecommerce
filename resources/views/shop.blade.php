@extends('layouts.app')

@section('title', 'Shop - ShoeCommerce')

@section('content')
<div class="container my-5">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">🛍️ Shop All Shoes</h2>

        <!-- Search Form -->
        <form class="d-flex" method="GET" action="{{ route('shop.index') }}">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control me-2" placeholder="Search shoes...">
            <button class="btn btn-outline-dark">Search</button>
        </form>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Filter</div>
                <div class="card-body">

                    <!-- Category Filter -->
                    <h6 class="fw-bold">Category</h6>
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop.category', $category->slug) }}" 
                                   class="text-decoration-none">
                                   {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Sort -->
                    <h6 class="fw-bold mt-3">Sort By</h6>
                    <form method="GET" action="{{ route('shop.index') }}">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>

                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                 class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <h6 class="fw-bold">{{ $product->name }}</h6>
                                <p class="text-muted mb-1">${{ number_format($product->price, 2) }}</p>

                                <a href="{{ route('product.details', $product->id) }}"
                                   class="btn btn-sm btn-dark mt-auto">
                                   View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No products available right now.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
