@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<div class="container">
    <h2>➕ Add New Category</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (optional)</label>
            <input type="text" name="slug" class="form-control">
            <small class="text-muted">If left blank, it will be generated automatically.</small>
        </div>

        <button type="submit" class="btn btn-success">💾 Save</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
