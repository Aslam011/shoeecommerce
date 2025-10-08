@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="container">
    <h2>✏️ Edit Product</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Product Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Price (₹) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status *</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Existing Images -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Existing Images</label>
                <div class="d-flex flex-wrap gap-3">
                    @forelse($product->productImages as $image)
                        <div class="position-relative" style="width:120px;">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" style="width:120px; height:120px; object-fit:cover;">
                        </div>
                    @empty
                        <p>No images uploaded.</p>
                    @endforelse
                </div>
            </div>
<div class="mb-3">
    <label class="form-label">Existing Images</label>
    <div class="d-flex flex-wrap gap-3">
        @foreach($product->productImages as $image)
            <div class="position-relative" style="width: 120px;">
                <img src="{{ asset('storage/' . $image->image) }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">

                <!-- Delete button -->
                <form action="{{ route('admin.products.image.destroy', [$product->id ?? 0, $image->id]) }}" method="POST" class="position-absolute top-0 end-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger rounded-circle p-1" style="line-height: 1;">
                        ✖
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>

            <!-- Upload New Images -->
            <div class="col-md-12 mb-3">
                <label class="form-label">Change / Add Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
                <small class="text-muted">You can upload multiple images (jpeg, png, jpg, gif)</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">💾 Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection