@extends('layouts.admin')

@section('title', 'Create Order')

@section('content')
<div class="container">
    <h2 class="mb-4">➕ Create New Order</h2>

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- form fields -->
     <div class="mb-3">
    <label for="images" class="form-label">Product Images (1–10)</label>
    <input 
        type="file" 
        name="images[]" 
        id="images" 
        class="form-control" 
        multiple 
        accept="image/*"
        required
    >
    <small class="text-muted">You must upload at least 1 image and up to 10 images.</small>
</div>

        <div class="mb-3">
            <label class="form-label">Order Number</label>
            <input type="text" name="order_number" class="form-control" placeholder="ORD12345" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Amount ($)</label>
            <input type="number" step="0.01" name="total" class="form-control" placeholder="0.00" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">💾 Save Order</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
