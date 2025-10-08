@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📦 Products</h2>
        <a href="#" class="btn btn-primary">
            ➕ Add Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="card shadow">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Products</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Product Row -->
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="https://via.placeholder.com/50" class="rounded" alt="Product">
                        </td>
                        <td>Nike Air Max</td>
                        <td>Shoes</td>
                        <td>$120</td>
                        <td>25</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑️ Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <img src="https://via.placeholder.com/50" class="rounded" alt="Product">
                        </td>
                        <td>Adidas Ultraboost</td>
                        <td>Shoes</td>
                        <td>$150</td>
                        <td>40</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑️ Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <img src="https://via.placeholder.com/50" class="rounded" alt="Product">
                        </td>
                        <td>Puma Sneakers</td>
                        <td>Shoes</td>
                        <td>$90</td>
                        <td>60</td>
                        <td><span class="badge bg-danger">Inactive</span></td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">🗑️ Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
