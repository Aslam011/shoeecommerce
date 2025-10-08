<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            min-width: 220px;
            max-width: 220px;
            background-color: #343a40;
            color: white;
        }
        .sidebar a, .sidebar form button {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 15px;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .sidebar a:hover, .sidebar form button:hover {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-center">Admin Panel</h4>
        <hr>
       <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
<a href="{{ route('admin.products.index') }}">📦 Products</a>
 <a href="{{ route('admin.categories.index') }}">📂 Categories</a> 
 <a href="{{ route('admin.orders.index') }}">🛒 Orders</a>
 <a href="{{ route('admin.sliders.index') }}">🎭 Sliders</a>
<a href="{{ route('admin.payment-gateways.index') }}">💳 Payment Gateways</a>
{{-- <a href="{{ route('admin.users.index') }}">👥 Users</a>--}} 
{{-- <a href="{{ route('admin.settings.index') }}">⚙️ Settings</a> --}} 


<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <hr>
        <!-- Logout as POST -->
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">🚪 Logout</button>
        </form>
    </div>

    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-light bg-light mb-4 p-3 rounded shadow-sm">
            <span class="navbar-brand mb-0 h4">Welcome, Admin 🎉</span>
        </nav>

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
