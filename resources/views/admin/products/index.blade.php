@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">📦 Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">➕ Add Product</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>   {{-- 👈 Added --}}
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        {{-- 👇 Show first image or placeholder --}}
                        <td>
                            @php
$mainImage = $product->productImages->where('is_main', true)->first();
$displayImage = $mainImage ?? $product->productImages->first();
@endphp

@if($displayImage)
    <img src="{{ asset('storage/'.$displayImage->image) }}" 
         alt="{{ $product->name }}" 
         class="rounded border" 
         style="width: 60px; height: 60px; object-fit: cover;">
@else
    <img src="https://via.placeholder.com/60x60?text=No+Image" 
         class="rounded border" 
         alt="No Image">
@endif

                        </td>

                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="btn btn-sm btn-warning">✏️ Edit</a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
