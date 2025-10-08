<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShoeCommerce') }}</title>

    <!-- Bootstrap CSS (if you used it before) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @stack('styles')
    
    <style>
        /* 3D Professional Navbar Styles */
        .navbar-3d {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e5e7eb;
        }

        .navbar-brand-3d {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e3c72 !important;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand-3d:hover {
            transform: scale(1.05);
            filter: brightness(1.2);
        }

        .navbar-brand-3d i {
            font-size: 1.8rem;
            color: #ff9900;
            -webkit-text-fill-color: #ff9900;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .nav-link-3d {
            color: #374151 !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.6rem 1.2rem !important;
            margin: 0 0.3rem;
            border-radius: 8px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link-3d::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border-radius: 8px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            z-index: -1;
        }

        .nav-link-3d:hover::before {
            transform: scaleX(1);
        }

        .nav-link-3d:hover {
            color: #1e3c72 !important;
            background: transparent;
            transform: translateY(-2px);
        }

        .nav-link-3d.active {
            color: #ff9900 !important;
            font-weight: 700;
        }

        .btn-3d {
            padding: 0.6rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-3d-login {
            background: linear-gradient(145deg, #10b981, #059669);
            color: white;
        }

        .btn-3d-register {
            background: linear-gradient(145deg, #3b82f6, #2563eb);
            color: white;
        }

        .btn-3d:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-3d::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-3d:hover::before {
            width: 300px;
            height: 300px;
        }

        .dropdown-menu-3d {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .dropdown-item-3d {
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-weight: 600;
            color: #333;
            transition: all 0.3s ease;
            margin: 0.2rem 0;
        }

        .dropdown-item-3d:hover {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            transform: translateX(5px);
        }

        .dropdown-item-3d i {
            color: #ff9900;
            margin-right: 8px;
        }

        .dropdown-item-3d:hover i {
            color: #ffc107;
        }

        .navbar-toggler-3d {
            border: 2px solid #d1d5db;
            border-radius: 10px;
            padding: 0.5rem;
        }

        .navbar-toggler-3d:focus {
            box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.1);
            border-color: #1e3c72;
        }

        .navbar-toggler-3d .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(55, 65, 81, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .user-dropdown-3d {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            border: 2px solid #d1d5db;
            color: #1f2937 !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .user-dropdown-3d:hover {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white !important;
            border-color: #1e3c72;
            transform: scale(1.05);
        }

        .user-dropdown-3d i {
            color: #ff9900;
        }

        .user-dropdown-3d:hover i {
            color: #ffc107;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff4757;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 700;
        }

        /* Professional Search Bar */
        .search-container {
            position: relative;
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 500;
            color: #374151;
            background: #f9fafb;
            transition: all 0.3s ease;
            outline: none;
        }

        .search-input:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .search-icon {
            font-size: 16px;
        }

        /* Live Search Dropdown */
        .search-results {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-results.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s ease;
        }

        .search-result-item:hover {
            background: #f9fafb;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 12px;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .search-result-price {
            font-size: 13px;
            color: #6366f1;
            font-weight: 700;
        }

        .search-no-results {
            padding: 20px;
            text-align: center;
            color: #9ca3af;
        }

        .search-loading {
            padding: 20px;
            text-align: center;
            color: #6366f1;
        }

        /* Mobile Search */
        @media (max-width: 992px) {
            .search-container {
                margin: 1rem 0;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .search-input {
                padding: 10px 45px 10px 16px;
                font-size: 14px;
            }

            .search-btn {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <!-- ✅ 3D Professional Navbar -->
    <nav class="navbar navbar-3d navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand-3d" href="{{ url('/') }}">
                <i class="fas fa-shoe-prints"></i>
                <span>ShoeCommerce</span>
            </a>
            <button class="navbar-toggler navbar-toggler-3d" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <div class="search-container">
                    <div class="search-wrapper">
                        <input 
                            type="text" 
                            class="search-input" 
                            id="searchInput"
                            placeholder="Search for shoes, brands, categories..."
                            autocomplete="off"
                        />
                        <button class="search-btn" type="button" id="searchBtn">
                            <i class="fas fa-search search-icon"></i>
                        </button>
                        <div class="search-results" id="searchResults"></div>
                    </div>
                </div>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link nav-link-3d">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/shop') }}" class="nav-link nav-link-3d">
                            <i class="fas fa-store me-1"></i> Shop
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a href="{{ route('cart.index') }}" class="nav-link nav-link-3d">
                            <i class="fas fa-shopping-cart me-1"></i> Cart
                        </a>
                    </li>

                    @auth('customer')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown-3d" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::guard('customer')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-3d dropdown-menu-end">
                                <li><a href="{{ route('customer.profile') }}" class="dropdown-item dropdown-item-3d">
                                    <i class="fas fa-user me-2"></i>My Profile
                                </a></li>
                                <li><a href="{{ route('customer.orders') }}" class="dropdown-item dropdown-item-3d">
                                    <i class="fas fa-shopping-bag me-2"></i>My Orders
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('customer.logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item dropdown-item-3d">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('customer.login') }}" class="btn btn-3d btn-3d-login">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('customer.register') }}" class="btn btn-3d btn-3d-register">
                                <i class="fas fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">&copy; {{ date('Y') }} ShoeCommerce. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <!-- Live Search Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchBtn = document.getElementById('searchBtn');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout = null;

        // Live search on typing
        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Hide results if query is too short
            if (query.length < 2) {
                searchResults.classList.remove('show');
                searchResults.innerHTML = '';
                return;
            }
            
            // Show loading state
            searchResults.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin me-2"></i>Searching...</div>';
            searchResults.classList.add('show');
            
            // Debounce search
            searchTimeout = setTimeout(function () {
                fetchSearchResults(query);
            }, 300);
        });

        // Search on button click
        searchBtn.addEventListener('click', function () {
            performSearch();
        });

        // Search on Enter key
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });

        // Close search results when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target) && !searchBtn.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });

        // Show results when clicking on input (if there's content)
        searchInput.addEventListener('click', function () {
            if (this.value.trim().length >= 2 && searchResults.innerHTML !== '') {
                searchResults.classList.add('show');
            }
        });

        function fetchSearchResults(query) {
            fetch(`{{ route('search.live') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    displaySearchResults(data);
                })
                .catch(error => {
                    console.error('Search error:', error);
                    searchResults.innerHTML = '<div class="search-no-results"><i class="fas fa-exclamation-circle me-2"></i>Error loading results</div>';
                });
        }

        function displaySearchResults(data) {
            if (!data.success || data.products.length === 0) {
                searchResults.innerHTML = `
                    <div class="search-no-results">
                        <i class="fas fa-search me-2"></i>
                        No products found
                    </div>
                `;
                return;
            }

            let html = '';
            data.products.forEach(product => {
                const detailsUrl = product.slug 
                    ? `/shop/${product.slug}` 
                    : `/product/${product.id}`;
                
                html += `
                    <a href="${detailsUrl}" class="search-result-item">
                        <img src="${product.image}" alt="${product.name}" class="search-result-image">
                        <div class="search-result-info">
                            <div class="search-result-name">${product.name}</div>
                            <div class="search-result-price">₹${parseFloat(product.price).toFixed(2)}</div>
                        </div>
                        ${product.stock > 0 
                            ? '<span class="badge bg-success">In Stock</span>' 
                            : '<span class="badge bg-danger">Out of Stock</span>'}
                    </a>
                `;
            });

            // Add "View All Results" link if there are results
            html += `
                <a href="{{ route('search') }}?q=${encodeURIComponent(searchInput.value)}" 
                   class="search-result-item" 
                   style="background: #f3f4f6; font-weight: 700; justify-content: center; color: #6366f1;">
                    <i class="fas fa-arrow-right me-2"></i>
                    View All Results (${data.count}+)
                </a>
            `;

            searchResults.innerHTML = html;
        }

        function performSearch() {
            const query = searchInput.value.trim();
            if (query.length > 0) {
                window.location.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
            }
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>
