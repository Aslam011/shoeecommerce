@extends('layouts.admin')

@section('title', 'Edit Slider')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">🎭 Edit Slider</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.sliders.index') }}">Sliders</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Slider Image</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Leave empty to keep current image. Recommended size: 1920x700px</small>
                    
                    <div class="mt-3">
                        <label class="form-label fw-bold">Current Image:</label>
                        <div>
                            <img id="currentImage"
                                 src="{{ asset('storage/' . $slider->image) }}" 
                                 alt="Current slider" 
                                 class="rounded shadow-sm"
                                 style="max-width: 400px;">
                        </div>
                        <img id="imagePreview" 
                             src="" 
                             alt="Preview" 
                             class="rounded shadow-sm mt-2"
                             style="max-width: 400px; display: none;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title</label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $slider->title) }}"
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
                              placeholder="Short description for the slider">{{ old('description', $slider->description) }}</textarea>
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
                               value="{{ old('button_text', $slider->button_text) }}"
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
                               value="{{ old('button_link', $slider->button_link) }}"
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
                               value="{{ old('order', $slider->order) }}"
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
                                   {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Update Slider
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
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            currentImage.style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
