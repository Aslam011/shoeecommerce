@extends('layouts.admin')

@section('title', 'Manage Sliders')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">🎭 Manage Sliders</h2>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Slider
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Button</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td>{{ $slider->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $slider->image) }}" 
                                         alt="{{ $slider->title }}" 
                                         class="rounded"
                                         style="width: 100px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ Str::limit($slider->description, 50) }}</td>
                                <td>
                                    @if($slider->button_text)
                                        <span class="badge bg-primary">{{ $slider->button_text }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $slider->order }}</span>
                                </td>
                                <td>
                                    @if($slider->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" 
                                           class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this slider?');"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No sliders found. <a href="{{ route('admin.sliders.create') }}">Create one now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
