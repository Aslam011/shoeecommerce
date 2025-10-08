@extends('layouts.admin')

@section('title', 'Create Slider')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">🎭 Create New Slider</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="images" class="form-label fw-bold">Slider Images <span class="text-danger">*</span></label>
                    <input type="file" 
                           class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" 
                           id="images" 
                           name="images[]" 
                           accept="image/*"
                           onchange="previewImages(event)"
                           multiple
                           required>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Recommended size: 1920x1080px (16:9 ratio). You can select multiple images at once.</small>
                    
                    <div class="mt-3" id="imagePreviews" style="display: flex; flex-wrap: wrap; gap: 15px;">
                        <!-- Image previews will be inserted here -->
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title</label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}"
                           placeholder="e.g., Welcome to ShoeCommerce">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3"
                              placeholder="Short description for the slider">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="button_text" class="form-label fw-bold">Button Text</label>
                        <input type="text" 
                               class="form-control @error('button_text') is-invalid @enderror" 
                               id="button_text" 
                               name="button_text" 
                               value="{{ old('button_text') }}"
                               placeholder="e.g., Shop Now">
                        @error('button_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="button_link" class="form-label fw-bold">Button Link</label>
                        <input type="text" 
                               class="form-control @error('button_link') is-invalid @enderror" 
                               id="button_link" 
                               name="button_link" 
                               value="{{ old('button_link') }}"
                               placeholder="e.g., /shop">
                        @error('button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="order" class="form-label fw-bold">Display Order</label>
                        <input type="number" 
                               class="form-control @error('order') is-invalid @enderror" 
                               id="order" 
                               name="order" 
                               value="{{ old('order', 0) }}"
                               min="0">
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Create Slider
                    </button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImages(event) {
    const previewContainer = document.getElementById('imagePreviews');
    const files = event.target.files;
    
    // Clear previous previews
    previewContainer.innerHTML = '';
    
    if (files.length > 0) {
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.style.position = 'relative';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded shadow-sm';
                img.style.maxWidth = '250px';
                img.style.height = 'auto';
                img.style.objectFit = 'cover';
                
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary position-absolute top-0 start-0 m-2';
                badge.textContent = `Image ${index + 1}`;
                
                imgWrapper.appendChild(img);
                imgWrapper.appendChild(badge);
                previewContainer.appendChild(imgWrapper);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
