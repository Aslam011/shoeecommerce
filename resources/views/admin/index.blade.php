@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📦 Manage Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">➕ Add New Product</a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price (₹)</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>

                            <!-- Thumbnail (first related image) -->
                            <td>
                                @if($product->productImages->count() > 0)
                                    <img src="{{ asset('storage/'.$product->productImages->first()->image) }}" 
                                         alt="Thumbnail" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/60x60?text=No+Image" 
                                         class="img-thumbnail" alt="No Image">
                                @endif
                            </td>

                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>₹{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $product->stock > 0 ? $product->stock : 'Out of Stock' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                                
                                <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
