@extends('admin.layouts.app')

@section('content')
<style>
/* Image card styling */
.img-card, .preview-card {
    position: relative;
    width: 140px;
    height: 140px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    background: #fff;
}
.img-card img, .preview-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
/* Delete button */
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

@php
$currentMainId = old('main_image_id') 
    ?? optional($product->productImages->firstWhere('is_main', true))->id
    ?? $product->main_image_id
    ?? null;
@endphp

<div class="container">
    <h2 class="mb-4">✏️ Edit Product</h2>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
        @csrf
        @method('PUT')

        {{-- Hidden main image fields --}}
        <input type="hidden" name="main_image_id" id="main_image_id_hidden" value="{{ $currentMainId }}">
        <input type="hidden" name="main_new_index" id="main_new_index_hidden" value="{{ old('main_new_index') }}">

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
        </div>

        {{-- Brand --}}
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input id="brand" type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control">
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label for="price" class="form-label">Price (₹)</label>
            <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="form-control" required>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input id="stock" type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-control" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Existing Images --}}
        <div class="mb-3">
            <label class="form-label d-block mb-2">Existing Images</label>
            @if($product->productImages->isEmpty())
                <p class="text-muted">No images uploaded</p>
            @else
                <small class="text-muted d-block mb-2">Select Main or remove images.</small>
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($product->productImages as $img)
                        @php $isMain = old('main_image_id', $currentMainId) == $img->id; @endphp
                        <div class="img-card">
                            @if($isMain)
                                <span class="main-badge">Main</span>
                            @endif

                            <img src="{{ asset('storage/' . $img->image) }}" alt="Product Image {{ $loop->iteration }}">

                            {{-- Main selector --}}
                            <label class="img-main-radio" for="main_existing_{{ $img->id }}">
                                <input type="radio" id="main_existing_{{ $img->id }}" name="main_choice" value="existing:{{ $img->id }}" {{ $isMain ? 'checked' : '' }}>
                                Main
                            </label>

                            {{-- Delete --}}
                            <button type="button" class="img-delete-btn" title="Remove image" onclick="if(confirm('Delete this image?')) document.getElementById('delete-image-{{ $img->id }}').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Upload New Images --}}
        <div class="mb-4">
            <label for="images" class="form-label">Upload New Images (optional)</label>
            <input id="images" type="file" name="images[]" class="form-control" multiple accept="image/*">
            <small class="text-muted">Upload multiple images. You can mark one as Main.</small>
            <div id="newImagesPreview" class="d-flex flex-wrap gap-3 mt-3"></div>
        </div>

        <button type="submit" class="btn btn-primary me-2">💾 Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back</a>
    </form>

    {{-- Delete forms --}}
    @foreach ($product->productImages as $img)
        <form id="delete-image-{{ $img->id }}" action="{{ route('admin.products.image.destroy', [$product->id, $img->id]) }}" method="POST" class="d-none">
            @csrf @method('DELETE')
        </form>
    @endforeach
</div>

<script>
function setMainExisting(id) {
    document.getElementById('main_image_id_hidden').value = id || '';
    document.getElementById('main_new_index_hidden').value = '';
}
function setMainNew(index) {
    document.getElementById('main_image_id_hidden').value = '';
    document.getElementById('main_new_index_hidden').value = index;
}
document.addEventListener('change', e => {
    if (e.target && e.target.name === 'main_choice') {
        const val = e.target.value;
        document.querySelectorAll('.img-card .main-badge').forEach(el => el.remove());
        if (val.startsWith('existing:')) {
            setMainExisting(val.split(':')[1]);
            const card = e.target.closest('.img-card');
            if (card) {
                const badge = document.createElement('span');
                badge.className = 'main-badge';
                badge.innerText = 'Main';
                card.appendChild(badge);
            }
        } else if (val.startsWith('new:')) {
            setMainNew(val.split(':')[1]);
        }
    }
});
const imagesInput = document.getElementById('images');
const previewWrap = document.getElementById('newImagesPreview');
imagesInput && imagesInput.addEventListener('change', function() {
    previewWrap.innerHTML = '';
    const files = Array.from(this.files || []);
    if (!files.length) {
        document.getElementById('main_new_index_hidden').value = '';
        return;
    }
    files.forEach((file, idx) => {
        const url = URL.createObjectURL(file);
        const card = document.createElement('div');
        card.className = 'preview-card';
        card.innerHTML = `
            <img src="${url}" alt="New Image ${idx+1}">
            <label class="img-main-radio" for="main_new_${idx}">
                <input type="radio" id="main_new_${idx}" name="main_choice" value="new:${idx}"> Main
            </label>
        `;
        previewWrap.appendChild(card);
    });
    if (!document.querySelector('input[name="main_choice"]:checked')) {
        const first = document.getElementById('main_new_0');
        if (first) { first.checked = true; setMainNew(0); }
    }
});
(function syncOnLoad(){
    const checked = document.querySelector('input[name="main_choice"]:checked');
    if (checked) {
        if (checked.value.startsWith('existing:')) setMainExisting(checked.value.split(':')[1]);
        else if (checked.value.startsWith('new:')) setMainNew(checked.value.split(':')[1]);
    } else if ('{{ $currentMainId }}') {
        setMainExisting('{{ $currentMainId }}');
    }
})();
</script>
@endsection
