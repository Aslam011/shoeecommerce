@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<style>
  :root {
    --brand: #0d6efd;
    --success: #16a34a;
    --text: #111827;
    --muted: #6b7280;
    --bg: #f9fafb;
    --card: #ffffff;
    --shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    --shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.12);
    --radius: 18px;
    --border: #e5e7eb;
  }

  body { background: var(--bg); }

  /* Search Header */
  .search-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
  }

  .search-title {
    font-weight: 800;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
  }

  .search-query {
    font-weight: 600;
    color: #ffc107;
  }

  .search-count {
    font-size: 1rem;
    opacity: 0.9;
  }

  .page-title {
    font-weight: 800;
    text-align: center;
    margin: 18px 0 28px;
    color: var(--text);
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 22px;
  }
  @media (min-width: 576px) { .product-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 992px) { .product-grid { grid-template-columns: repeat(4, 1fr); } }

  .card-product {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 18px 18px 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .card-product:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
    border-color: var(--brand);
  }

  .thumb-wrap {
    background: #f8fafc;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 220px;
    margin-bottom: 16px;
    position: relative;
  }
  
  .thumb-wrap img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }

  .card-product:hover .thumb-wrap img {
    transform: scale(1.05);
  }

  /* Stock badge */
  .stock-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 2;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .stock-in { 
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
  }
  
  .stock-out { 
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
  }

  .title {
    font-weight: 700;
    color: var(--text);
    margin: 0 0 8px;
    min-height: 52px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 0.95rem;
    line-height: 1.4;
  }

  .price {
    color: var(--brand);
    font-weight: 800;
    font-size: 1.3rem;
    margin-bottom: 12px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
  }

  .actions {
    margin-top: auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  /* Professional Button Styles */
  .btn-modern {
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    padding: 0 20px;
    min-width: 140px;
  }

  /* View Details Button */
  .btn-details {
    background: transparent;
    color: var(--text);
    border: 2px solid var(--border);
    font-size: 0.85rem;
  }

  .btn-details:hover {
    background: var(--text);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Add to Cart Button */
  .btn-cart {
    background: linear-gradient(135deg, var(--brand), #2563eb);
    color: white;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
  }

  .btn-cart:hover:not(:disabled) {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
    color: white;
  }

  /* Success State */
  .btn-cart.added {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4) !important;
    animation: successPulse 0.6s ease-in-out;
  }

  @keyframes successPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }

  /* Buy Now Button */
  .btn-buy {
    background: linear-gradient(135deg, var(--success), #15803d);
    color: white;
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    font-weight: 700;
  }

  .btn-buy:hover:not(:disabled) {
    background: linear-gradient(135deg, #15803d, #166534);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
    color: white;
  }

  /* Disabled States */
  .btn-modern:disabled,
  .btn-cart:disabled:not(.added),
  .btn-buy:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
  }

  .btn-out-of-stock {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
    color: white;
    border: none;
    font-size: 0.85rem;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
  }

  .empty-state i {
    font-size: 5rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
  }

  .empty-state h3 {
    color: var(--text);
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .empty-state p {
    color: var(--muted);
    margin-bottom: 1.5rem;
  }

  /* Responsive */
  @media (max-width: 576px) {
    .actions { gap: 6px; }
    .btn-modern { 
      height: 40px; 
      font-size: 0.8rem; 
      min-width: 120px; 
      padding: 0 16px;
    }
  }
</style>

<!-- Search Header -->
<div class="search-header">
  <div class="container">
    <h1 class="search-title">
      <i class="fas fa-search me-2"></i>
      Search Results for "<span class="search-query">{{ $query }}</span>"
    </h1>
    <p class="search-count">
      {{ $products->total() }} {{ Str::plural('product', $products->total()) }} found
    </p>
  </div>
</div>

<div class="container py-3">
  @if($products->count() > 0)
    <div class="product-grid">
      @foreach($products as $product)
        @php
          $firstImg = optional($product->productImages->first())->image ?? null;
          $imgUrl = $firstImg ? asset('storage/'.$firstImg) : 'https://via.placeholder.com/500x350?text=No+Image';
          $inStock = (int)($product->stock ?? 0) > 0;
          $detailsUrl = isset($product->slug) && $product->slug
                        ? route('shop.show', $product->slug)
                        : (Route::has('shop.show') ? route('shop.show', $product->id) : route('product.details', $product->id));
        @endphp

        <div class="card-product">
          {{-- Stock Badge --}}
          @if($inStock)
            <span class="stock-badge stock-in">
              <i class="fas fa-check-circle me-1"></i>
              In Stock
            </span>
          @else
            <span class="stock-badge stock-out">
              <i class="fas fa-times-circle me-1"></i>
              Sold Out
            </span>
          @endif

          <a href="{{ $detailsUrl }}" aria-label="View {{ $product->name }}">
            <div class="thumb-wrap">
              <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
            </div>
          </a>

          <h3 class="title h5">{{ Str::limit($product->name, 70) }}</h3>
          <div class="price">₹{{ number_format((float)$product->price, 2) }}</div>

          <div class="actions">
            {{-- View Details Button --}}
            <a class="btn-modern btn-details" href="{{ $detailsUrl }}">
              <i class="fas fa-eye me-1"></i>
              <span>View Details</span>
            </a>

            {{-- Add to Cart Button --}}
            <div class="add-to-cart-wrapper" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}">
              @if($inStock)
                <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form d-inline-block w-100">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  <input type="hidden" name="quantity" value="1">
                  <button
                    type="submit"
                    class="btn-modern btn-cart w-100 position-relative"
                    data-default-text="Add to Cart"
                    data-loading-text="Adding..."
                    data-success-text="Added!"
                    data-product-name="{{ $product->name }}"
                  >
                    <i class="fas fa-shopping-cart me-1"></i>
                    <span>Add to Cart</span>
                  </button>
                </form>
              @else
                <button class="btn-modern btn-out-of-stock w-100" disabled>
                  <i class="fas fa-clock me-1"></i>
                  <span>Notify Me</span>
                </button>
              @endif
            </div>

            {{-- Buy Now Button --}}
            @if($inStock)
              <form action="{{ route('checkout.buy-now', ['product' => $product->id]) }}" 
                    method="POST" class="d-inline-block w-100">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-modern btn-buy w-100">
                  <i class="fas fa-bolt me-1"></i>
                  <span>Buy Now</span>
                </button>
              </form>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if(method_exists($products, 'links'))
      <div class="pagination-wrap d-flex justify-content-center mt-5">
        {{ $products->appends(['q' => $query])->links() }}
      </div>
    @endif
  @else
    <div class="empty-state">
      <i class="fas fa-search"></i>
      <h3>No products found</h3>
      <p>We couldn't find any products matching "{{ $query }}"</p>
      <div class="d-flex gap-3 justify-content-center">
        <a href="{{ route('shop.index') }}" class="btn btn-primary">
          <i class="fas fa-store me-2"></i>Browse All Products
        </a>
        <button onclick="document.getElementById('searchInput').focus()" class="btn btn-outline-secondary">
          <i class="fas fa-search me-2"></i>Try Another Search
        </button>
      </div>
    </div>
  @endif
</div>

<script>
// Enhanced Add to Cart with Success Message
document.addEventListener('DOMContentLoaded', function () {
  const addToCartForms = document.querySelectorAll('.add-to-cart-form');
  
  addToCartForms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      const wrapper = this.closest('.add-to-cart-wrapper');
      const btn = this.querySelector('.btn-cart');
      
      if (!btn || btn.dataset.submitting === '1') {
        e.preventDefault();
        return false;
      }
      
      // Prevent double submit
      btn.dataset.submitting = '1';
      
      // Show loading state
      const originalIcon = btn.querySelector('i');
      const originalSpan = btn.querySelector('span');
      const loadingText = btn.getAttribute('data-loading-text');
      const productName = btn.getAttribute('data-product-name');
      
      originalIcon.className = 'fas fa-spinner fa-spin me-1';
      originalSpan.textContent = loadingText;
      btn.disabled = true;
      
      // Simulate success after short delay
      setTimeout(function() {
        // Show success state
        btn.classList.add('added');
        btn.classList.remove('btn-cart');
        btn.classList.add('btn-success', 'cart-success-message');
        originalIcon.className = 'fas fa-check me-1';
        originalSpan.innerHTML = `Added <strong>${productName}</strong>!`;
        
        // Auto-reset after 2 seconds
        setTimeout(function() {
          // Reset to original state
          btn.classList.remove('added', 'btn-success', 'cart-success-message');
          btn.classList.add('btn-cart');
          originalIcon.className = 'fas fa-shopping-cart me-1';
          originalSpan.textContent = btn.getAttribute('data-default-text') || 'Add to Cart';
          btn.disabled = false;
          btn.dataset.submitting = '0';
        }, 2000);
        
      }, 800);
    });
  });
});
</script>
@endsection
