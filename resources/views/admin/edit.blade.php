@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Product Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div>
            <label for="brand">Brand</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}">
        </div>

        <div>
            <label for="price">Price</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" required>
        </div>

        <div>
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div>
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>
        </div>

        <div>
            <label for="images">Add More Images</label>
            <input type="file" name="images[]" id="images" multiple>
        </div>

        @if($product->productImages->count() > 0)
            <div>
                <p>Existing Images:</p>
                @foreach($product->productImages as $img)
                    <img src="{{ asset('storage/'.$img->image) }}" alt="Product Image" width="100">
                @endforeach
            </div>
        @endif

        <button type="submit">Update Product</button>
    </form>
</div>
@endsection
