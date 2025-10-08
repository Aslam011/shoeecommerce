@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"> Add New Product</h4>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">
                ⏪ Back to Products
            </a>
        </div>
        <div class="card-body p-4">

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <!-- Product Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label fw-bold">Product Name</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Brand -->
                <div class="col-md-6">
                    <label for="brand" class="form-label fw-bold">Brand</label>
                    <input type="text" name="brand" id="brand" 
                           class="form-control" 
                           value="{{ old('brand') }}">
                </div>

                <!-- Price -->
                <div class="col-md-6">
                    <label for="price" class="form-label fw-bold">Price (₹)</label>
                    <input type="number" step="0.01" name="price" id="price" 
                           class="form-control @error('price') is-invalid @enderror" 
                           value="{{ old('price') }}" required>
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Stock -->
                <div class="col-md-6">
                    <label for="stock" class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" id="stock" 
                           class="form-control @error('stock') is-invalid @enderror" 
                           value="{{ old('stock') }}" required>
                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label fw-bold">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected':'' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected':'' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected':'' }}>Inactive</option>
                    </select>
                </div>

                <!-- Images -->
                <div class="mb-3">
                    <label for="images" class="form-label fw-bold">Product Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*" aria-describedby="imagesHelp">
                    <div id="imagesHelp" class="form-text mb-2">You can upload up to 10 images (jpeg, png, jpg, gif).</div>

                    {{-- Preview Area --}}
                    <div id="preview" class="d-flex flex-wrap gap-3"></div>
                </div>

                <!-- Hidden input to store main image index -->
                <input type="hidden" name="main_image_index" id="main_image_index" value="0">

                <!-- Description -->
                <div class="col-md-12">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea name="description" id="description" rows="4" 
                              class="form-control">{{ old('description') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        💾 Save Product
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
    #preview {
        margin-top: 0.5rem;
    }

    .img-card {
        position: relative;
        width: 140px;
        height: 140px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        background: #fff;
    }
    .img-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .img-delete-btn {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 9999px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform .12s, background-color .12s, box-shadow .12s;
        box-shadow: 0 2px 6px rgba(0,0,0,.15);
    }
    .img-delete-btn:hover {
        background: #dc3545;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(220,53,69,.35);
    }
    .img-main-radio {
        position: absolute;
        left: 8px;
        bottom: 8px;
        background: rgba(255,255,255,.9);
        border-radius: 16px;
        padding: 4px 8px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,.12);
    }
    .main-badge {
        position: absolute;
        left: 8px;
        top: 8px;
        background: #0d6efd;
        color: #fff;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 9999px;
        box-shadow: 0 2px 6px rgba(13,110,253,.35);
    }
</style>

<script>
const input = document.getElementById('images');
const preview = document.getElementById('preview');
const mainImageIndexInput = document.getElementById('main_image_index');

input.addEventListener('change', updatePreview);

function updatePreview() {
    preview.innerHTML = "";

    const files = Array.from(input.files);
    if (!files.length) {
        mainImageIndexInput.value = '';
        return;
    }

    files.forEach((file, idx) => {
        if (!file.type.startsWith('image/')) return;
        const url = URL.createObjectURL(file);

        const card = document.createElement('div');
        card.className = 'img-card';
        card.innerHTML = `
            ${idx === parseInt(mainImageIndexInput.value) ? '<span class="main-badge">Main</span>' : ''}
            <img src="${url}" alt="Preview ${idx+1}">
            <label class="img-main-radio">
                <input type="radio" name="main_choice" value="${idx}" ${idx === 0 ? 'checked' : ''}>
                Main
            </label>
            <button type="button" class="img-delete-btn">&times;</button>
        `;

        // handle main select
        card.querySelector('input[type=radio]').addEventListener('change', () => {
            mainImageIndexInput.value = idx;
            updatePreview(); // re-render to refresh badges
        });

        // handle delete
        card.querySelector('.img-delete-btn').addEventListener('click', () => {
            removeImage(idx);
        });

        preview.appendChild(card);
    });
    // default: first is main
    if (!mainImageIndexInput.value) mainImageIndexInput.value = 0;
}

function removeImage(indexToRemove) {
    const dt = new DataTransfer();
    Array.from(input.files).forEach((file, i) => {
        if (i !== indexToRemove) dt.items.add(file);
    });
    input.files = dt.files;

    mainImageIndexInput.value = 0;
    updatePreview();
}
function updatePreview() {
    preview.innerHTML = "";

    const files = Array.from(input.files);
    if (!files.length) {
        mainImageIndexInput.value = '';
        return;
    }

    // Get current main index
    let mainIndex = parseInt(mainImageIndexInput.value, 10);
    if (isNaN(mainIndex) || mainIndex < 0 || mainIndex >= files.length) {
        mainIndex = 0;
    }

    // Reorder files so main comes first
    const reordered = [files[mainIndex], ...files.filter((_, i) => i !== mainIndex)];

    // Replace FileList
    const dt = new DataTransfer();
    reordered.forEach(f => dt.items.add(f));
    input.files = dt.files;

    // Render cards
    Array.from(input.files).forEach((file, idx) => {
        if (!file.type.startsWith('image/')) return;
        const url = URL.createObjectURL(file);

        const card = document.createElement('div');
        card.className = 'img-card';
        card.innerHTML = `
            ${idx === 0 ? '<span class="main-badge">Main</span>' : ''}
            <img src="${url}" alt="Preview ${idx+1}">
            <label class="img-main-radio">
                <input type="radio" name="main_choice" value="${idx}" ${idx === 0 ? 'checked' : ''}>
                Main
            </label>
            <button type="button" class="img-delete-btn">&times;</button>
        `;

        // handle radio
        card.querySelector('input[type=radio]').addEventListener('change', () => {
            mainImageIndexInput.value = idx;
            updatePreview(); // re-render, which moves it to first
        });

        // handle delete
        card.querySelector('.img-delete-btn').addEventListener('click', () => {
            removeImage(idx);
        });

        preview.appendChild(card);
    });

    // Ensure hidden field always matches new main (first image)
    mainImageIndexInput.value = 0;
}

</script>
@endsection