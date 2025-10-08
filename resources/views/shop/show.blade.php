@extends('layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

  body {
    background: var(--bg);
  }

  .product-page {
    margin-top: 32px;
  }

  /* Breadcrumbs */
  .breadcrumb-container {
    background: var(--card);
    border-radius: var(--radius);
    padding: 16px 24px;
    margin-bottom: 32px;
    box-shadow: var(--shadow);
  }

  .breadcrumb-light .breadcrumb-item a {
    color: var(--muted);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }

  .breadcrumb-light .breadcrumb-item a:hover {
    color: var(--brand);
  }

  .breadcrumb-light .breadcrumb-item.active {
    color: var(--text);
    font-weight: 600;
  }

  /* Main Layout */
  .product-main {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 32px;
  }

  /* Image Gallery */
  .gallery-section {
    padding: 20px;
    position: relative;
  }

  .swiper-main {
    border-radius: 16px;
    overflow: hidden;
    background: #f3f4f6;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }

  .swiper-main .swiper-slide img {
    width: 100%;
    height: 460px;
    object-fit: contain;
    background: #f3f4f6;
  }

  /* Navigation buttons style */
  .swiper-button-next,
  .swiper-button-prev {
    color: var(--brand);
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    top: 50%;
    transform: translateY(-50%);
  }

  .swiper-button-next:hover,
  .swiper-button-prev:hover {
    background: var(--brand);
    color: #fff;
  }

  /* Thumbnails */
  .swiper-thumbs {
    margin-top: 14px;
    padding-top: 10px;
    border-top: 1px solid var(--border);
  }

  .swiper-thumbs .swiper-slide {
    width: 90px !important;
    opacity: 0.75;
    transition: all 0.25s ease;
    cursor: pointer;
    border-radius: 12px;
    overflow: hidden;
    margin-right: 12px;
  }

  .swiper-thumbs .swiper-slide:hover {
    opacity: 0.9;
  }

  .swiper-thumbs .swiper-slide-thumb-active {
    border: 2px solid var(--brand);
    opacity: 1 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .swiper-thumbs img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
  }

  /* Product Info */
  .info-section {
    padding: 28px 32px;
    position: relative;
  }

  .product-title {
    font-weight: 800;
    line-height: 1.3;
    font-size: 2rem;
    color: var(--text);
    margin-bottom: 8px;
  }

  .price-display {
    font-size: 2rem;
    font-weight: 700;
    color: var(--success);
    margin: 8px 0 16px;
  }

  .meta p {
    margin-bottom: 0.45rem;
    font-size: 0.95rem;
  }

  .meta strong {
    font-weight: 700;
  }

  /* Badges */
  .badge-soft {
    background: #e7f1ff;
    color: var(--brand);
    font-weight: 600;
    border-radius: 999px;
    padding: 6px 12px;
    margin-right: 8px;
  }

  .badge-stock {
    background: #eaf7ef;
    color: var(--success);
    font-weight: 700;
    border-radius: 999px;
    padding: 6px 12px;
  }

  /* Quantity & actions */
  .qty-group {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
  }

  .qty-control {
    display: inline-flex;
    align-items: center;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
  }

  .qty-control button {
    width: 42px;
    height: 42px;
    border: 0;
    background: #f3f4f6;
    font-weight: 700;
    font-size: 1.25rem;
    cursor: pointer;
    user-select: none;
  }

  .qty-control button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .qty-control input {
    width: 64px;
    height: 42px;
    border: 0;
    text-align: center;
    font-weight: 700;
    font-size: 1.1rem;
  }

  .actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }

  .actions form {
    flex: 1 1 48%;
  }

  .btn {
    height: 50px;
    border-radius: 14px;
    font-weight: 700;
    letter-spacing: 0.3px;
    transition: transform 0.08s ease, box-shadow 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .btn:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(13, 110, 253, 0.18);
  }

  .btn-buy {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: 0;
    color: #fff;
    position: relative;
    overflow: hidden;
  }

  .btn-buy:hover {
    background: dodgerblue;
    box-shadow: 0 0 30px 5px rgba(0, 142, 236, 0.815);
  }

  .btn-buy:hover::before {
    animation: sh02 0.5s linear;
  }

  .btn-buy::before {
    content: '';
    display: block;
    width: 0;
    height: 86%;
    position: absolute;
    top: 7%;
    left: 0;
    opacity: 0;
    background: #fff;
    box-shadow: 0 0 50px 30px #fff;
    transform: skewX(-20deg);
  }

  @keyframes sh02 {
    0% {
      opacity: 0;
      left: 0;
    }
    50% {
      opacity: 1;
    }
    100% {
      opacity: 0;
      left: 100%;
    }
  }

  .btn-buy:active {
    box-shadow: none;
    transition: box-shadow 0.2s ease-in;
  }

  /* Divider */
  .divider {
    height: 1px;
    background: #eee;
    margin: 18px 0;
  }

  /* Description */
  .desc-title {
    font-weight: 700;
    font-size: 1.15rem;
    margin-bottom: 8px;
  }

  .desc-text {
    color: #374151;
    line-height: 1.7;
  }

  /* Trust row */
  .trust {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-top: 10px;
  }

  .trust .pill {
    background: #f8fafc;
    border: 1px solid var(--border);
    border-radius: 999px;
    padding: 8px 14px;
    color: #374151;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .actions form {
      flex: 1 1 100%;
    }
  }
</style>

<div class="container product-page">
  <!-- Breadcrumbs -->
  <div class="breadcrumb-container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-light p-0 m-0">
        <li class="breadcrumb-item">
          <a href="{{ route('home') }}" class="text-decoration-none">
            <i class="fas fa-home me-2"></i>Home
          </a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('shop.index') }}" class="text-decoration-none">Shop</a>
        </li>
        @if($product->category)
          <li class="breadcrumb-item">
            <a href="{{ route('shop.category', $product->category->slug) }}" class="text-decoration-none">
              {{ $product->category->name }}
            </a>
          </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">
          {{ Str::limit($product->name, 50) }}
        </li>
      </ol>
    </nav>
  </div>

  <!-- Main Product Layout -->
  <div class="product-main">
    <div class="row g-0">
      <!-- Image Gallery -->
      <div class="col-lg-6">
        <div class="gallery-section">
          <!-- Main Image Swiper -->
          <div class="swiper swiper-main">
            <div class="swiper-wrapper">
              @forelse($product->productImages as $img)
                <div class="swiper-slide">
                  <img src="{{ asset('storage/'.$img->image) }}" 
                       alt="{{ $product->name }}" 
                       loading="lazy" />
                </div>
              @empty
                <div class="swiper-slide">
                  <img src="https://via.placeholder.com/800x460?text={{ urlencode($product->name) }}" 
                       alt="{{ $product->name }}" 
                       loading="lazy" />
                </div>
              @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>

          <!-- Thumbnail Swiper -->
          @if($product->productImages->count() > 1)
            <div class="swiper swiper-thumbs mt-3">
              <div class="swiper-wrapper">
                @foreach($product->productImages as $img)
                  <div class="swiper-slide">
                    <img src="{{ asset('storage/'.$img->image) }}" 
                         alt="{{ $product->name }}" 
                         loading="lazy" />
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-lg-6">
        <div class="info-section">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge-soft">{{ $product->brand ?? 'Brand' }}</span>
            <span class="badge-stock">
              {{ $product->stock > 0 ? 'In Stock: '.$product->stock : 'Out of Stock' }}
            </span>
          </div>

          <h1 class="product-title">{{ $product->name }}</h1>
          <div class="price-display">₹{{ number_format($product->price, 2) }}</div>

          <div class="meta mb-3">
            <p><strong>Status:</strong>
              <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }}">
                {{ $product->stock > 0 ? 'Available' : 'Out of Stock' }}
              </span>
            </p>
            <p><strong>Brand:</strong> {{ $product->brand ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $product->category->name ?? 'Uncategorized' }}</p>
            <p><strong>Product Status:</strong> {{ ucfirst($product->status) }}</p>
          </div>

          <div class="divider"></div>

          <!-- Quantity + Actions -->
          <div class="qty-group">
            <label for="qtyInput" class="fw-semibold me-1">Quantity</label>
            <div class="qty-control">
              <button type="button" id="qtyMinus" {{ $product->stock < 2 ? 'disabled' : '' }}>−</button>
              <input type="number" id="qtyInput" value="1" min="1" max="{{ max(1, (int)$product->stock) }}" aria-label="Quantity">
              <button type="button" id="qtyPlus" {{ $product->stock < 2 ? 'disabled' : '' }}>+</button>
            </div>
          </div>

          <div class="actions">
            <form action="{{ route('cart.store') }}" method="POST" class="me-2">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="hidden" name="quantity" id="cartQty" value="1">
              <button class="btn btn-primary w-100" type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}>
                <i class="bi bi-cart-plus me-1"></i> Add to Cart
              </button>
            </form>

            <form action="{{ route('checkout.buy-now', ['product' => $product->id]) }}" method="POST" class="w-100">
              @csrf
              <input type="hidden" name="quantity" id="buyQty" value="1">
              <button class="btn btn-buy w-100" type="submit" {{ $product->stock < 1 ? 'disabled' : '' }}>
                <i class="bi bi-lightning-charge-fill me-1"></i> Buy Now
              </button>
            </form>
          </div>

          <div class="trust mt-3">
            <span class="pill">✔ Secure checkout</span>
            <span class="pill">↺ 7-day return</span>
            <span class="pill">★ Genuine product</span>
          </div>

          <div class="divider"></div>

          <h5 class="desc-title">Description</h5>
          <p class="desc-text">{!! $product->description ?? '<em>No description available.</em>' !!}</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Initialize thumbnails swiper if exists
    let thumbsSwiper = null;
    if (document.querySelector('.swiper-thumbs')) {
      thumbsSwiper = new Swiper('.swiper-thumbs', {
        spaceBetween: 12,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
          320: { slidesPerView: 3, spaceBetween: 8 },
          768: { slidesPerView: 4, spaceBetween: 12 }
        }
      });
    }

    // Main swiper with fade effect and autoplay sliding to right
    const mainSwiper = new Swiper('.swiper-main', {
      spaceBetween: 10,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      loop: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
        reverseDirection: false // slide to right (default)
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : null,
      on: {
        slideChange: function () {
          this.autoplay.stop();
          this.autoplay.start();
        },
        touchStart: function () {
          this.autoplay.stop();
        }
      }
    });

    // Quantity controls
    const stockMax = {{ max(1, (int)$product->stock) }};
    const qtyInput = document.getElementById('qtyInput');
    const cartQty = document.getElementById('cartQty');
    const buyQty = document.getElementById('buyQty');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');

    function clampQty(val) {
      val = parseInt(val, 10) || 1;
      if (val < 1) val = 1;
      if (val > stockMax) val = stockMax;
      return val;
    }

    function syncQty(val) {
      val = clampQty(val);
      qtyInput.value = val;
      cartQty.value = val;
      buyQty.value = val;

      // Enable/disable buttons
      qtyMinus.disabled = val <= 1;
      qtyPlus.disabled = val >= stockMax;
    }

    qtyMinus.addEventListener('click', () => {
      syncQty(qtyInput.value - 1);
    });

      qtyPlus.addEventListener('click', () => {
      syncQty(parseInt(qtyInput.value, 10) + 1);
    });

    qtyInput.addEventListener('input', () => {
      syncQty(qtyInput.value);
    });

    qtyInput.addEventListener('change', () => {
      syncQty(qtyInput.value);
    });

    // Initialize quantity controls
    syncQty(1);

    // Add to Cart button feedback
    const addToCartForm = document.querySelector('form[action="{{ route('cart.store') }}"]');
    if (addToCartForm) {
      addToCartForm.addEventListener('submit', function (e) {
        const btn = this.querySelector('button[type="submit"]');
        if (btn && !btn.disabled) {
          btn.innerHTML = '<i class="bi bi-arrow-repeat spin me-2"></i> Adding...';
          btn.disabled = true;
        }
      });
    }

    // Buy Now button feedback
    const buyNowForm = document.querySelector('form[action*="/buy-now"]');
    if (buyNowForm) {
      buyNowForm.addEventListener('submit', function (e) {
        const btn = this.querySelector('button[type="submit"]');
        if (btn && !btn.disabled) {
          btn.innerHTML = '<i class="bi bi-arrow-repeat spin me-2"></i> Processing...';
          btn.disabled = true;
        }
      });
    }
  });
</script>
@endsection