@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">➕ Add New Product</h2>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label">Category *</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="price" class="form-label">Price (₹) *</label>
                <input type="number" name="price" id="price" step="0.01" class="form-control"
                       value="{{ old('price') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="stock" class="form-label">Stock *</label>
                <input type="number" name="stock" id="stock" class="form-control" 
                       value="{{ old('stock') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="status" class="form-label">Status *</label>
                <select name="status" id="status" class="form-select">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Product Images *</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <small class="text-muted">Upload one or more images (jpeg, png, jpg, gif, max 2MB each)</small>
        </div>

        <button type="submit" class="btn btn-primary">💾 Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
