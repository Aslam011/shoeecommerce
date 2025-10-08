@extends('layouts.app')

@section('title', 'ShoeCommerce - Premium Footwear Collection')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
:root {
    --primary-navy: #232f3e;
    --secondary-navy: #131921;
    --accent-orange: #ff9900;
    --accent-blue: #007bff;
    --light-gray: #f3f3f3;
    --border-gray: #ddd;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Amazon Ember', Arial, sans-serif;
    color: #0f1111;
}

/* ===== HERO SLIDER SECTION ===== */
.heroSwiper {
    width: 100%;
    height: 550px;
    position: relative;
    overflow: hidden;
}

@media (min-width: 1200px) {
    .heroSwiper {
        height: 600px;
    }
}

@media (max-width: 768px) {
    .heroSwiper {
        height: 400px;
    }
}

.swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.slider-bg {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
    background-position: center;
    position: relative;
}

.slider-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
    z-index: 1;
}

.slider-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    max-width: 800px;
    padding: 3rem;
}

.slider-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-shadow: 2px 4px 8px rgba(0,0,0,0.5);
    opacity: 0;
    transform: translateY(50px);
    animation: slideInUp 0.8s ease forwards;
}

.slider-description {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    text-shadow: 1px 2px 4px rgba(0,0,0,0.5);
    opacity: 0;
    transform: translateY(50px);
    animation: slideInUp 1s ease forwards 0.2s;
}

.slider-btn {
    display: inline-block;
    padding: 1rem 3rem;
    background: var(--accent-orange);
    color: var(--secondary-navy);
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(255, 153, 0, 0.4);
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(50px);
    animation: slideInUp 1.2s ease forwards 0.4s;
}

.slider-btn:hover {
    background: #ff8800;
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(255, 153, 0, 0.6);
}

@keyframes slideInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Navigation Arrows - Large and Visible */
.swiper-button-next,
.swiper-button-prev {
    width: 60px !important;
    height: 60px !important;
    background: rgba(255, 255, 255, 0.95) !important;
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    color: var(--secondary-navy) !important;
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 26px !important;
    font-weight: 900;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: var(--accent-orange) !important;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(255, 153, 0, 0.5);
}

.swiper-pagination {
    bottom: 25px !important;
}

.swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: white;
    opacity: 0.6;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    background: var(--accent-orange);
    opacity: 1;
    width: 40px;
    border-radius: 6px;
}

/* ===== CATEGORIES SECTION ===== */
.categories-section {
    padding: 4rem 0;
    background: var(--light-gray);
}

.section-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--secondary-navy);
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--accent-orange);
    border-radius: 2px;
}

.category-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    cursor: pointer;
    text-decoration: none;
    display: block;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.category-image {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-orange));
    position: relative;
    overflow: hidden;
}

.category-icon {
    font-size: 4rem;
    font-weight: 700;
    color: white;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    transition: transform 0.4s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.2) rotate(5deg);
}

.category-body {
    padding: 1.5rem;
    text-align: center;
}

.category-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--secondary-navy);
    margin-bottom: 0.5rem;
}

.category-desc {
    font-size: 0.9rem;
    color: #565959;
}

/* ===== PRODUCTS SECTION ===== */
.products-section {
    padding: 4rem 0;
    background: white;
}

.product-card {
    background: white;
    border: 1px solid var(--border-gray);
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-color: var(--accent-orange);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 280px;
    background: #f9f9f9;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #0f1111;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    min-height: 2.8rem;
}

.product-rating {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.stars {
    color: var(--accent-orange);
    font-size: 1rem;
    margin-right: 0.5rem;
}

.rating-count {
    color: #007185;
    font-size: 0.85rem;
}

.product-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #b12704;
    margin-bottom: 1rem;
}

.product-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: auto;
}

.btn-view {
    flex: 1;
    padding: 0.7rem;
    background: var(--accent-orange);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.btn-view:hover {
    background: #ff8800;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 153, 0, 0.4);
}

.btn-cart {
    flex: 1;
    padding: 0.7rem;
    background: var(--primary-navy);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cart:hover {
    background: var(--secondary-navy);
    transform: translateY(-2px);
}

/* ===== FEATURED DEALS SECTION ===== */
.deals-section {
    padding: 4rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.deals-section .section-title {
    color: white;
}

.deals-section .section-title::after {
    background: white;
}

.deal-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.deal-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.deal-badge {
    display: inline-block;
    background: #e74c3c;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 700;
    margin-bottom: 1rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.deal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--secondary-navy);
    margin-bottom: 1rem;
}

.deal-timer {
    font-size: 2rem;
    font-weight: 700;
    color: #e74c3c;
    margin-bottom: 1rem;
}

/* ===== WHY CHOOSE US SECTION ===== */
.features-section {
    padding: 4rem 0;
    background: white;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    background: var(--light-gray);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-orange));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
    transition: all 0.3s ease;
}

.feature-card:hover .feature-icon {
    transform: rotateY(360deg);
}

.feature-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--secondary-navy);
    margin-bottom: 0.5rem;
}

.feature-desc {
    color: #565959;
}

/* ===== SCROLL ANIMATIONS ===== */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .slider-title {
        font-size: 2rem;
    }
    
    .slider-description {
        font-size: 1rem;
    }
    
    .slider-btn {
        padding: 0.8rem 2rem;
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .swiper-button-next,
    .swiper-button-prev {
        width: 45px !important;
        height: 45px !important;
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 20px !important;
    }
}
</style>
@endpush

@section('content')

<!-- Hero Slider -->
@if(isset($sliders) && $sliders->count() > 0)
<div class="swiper heroSwiper">
    <div class="swiper-wrapper">
        @foreach($sliders as $slider)
        <div class="swiper-slide">
            <div class="slider-bg" style="background: url('{{ asset('storage/' . $slider->image) }}') center/cover no-repeat;">
                <div class="slider-content">
                    @if($slider->title)
                        <h1 class="slider-title">{{ $slider->title }}</h1>
                    @endif
                    @if($slider->description)
                        <p class="slider-description">{{ $slider->description }}</p>
                    @endif
                    @if($slider->button_text && $slider->button_link)
                        <a href="{{ $slider->button_link }}" class="slider-btn">
                            {{ $slider->button_text }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>
@else
<!-- Fallback Hero -->
<div class="swiper heroSwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <div class="slider-bg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="slider-content">
                    <h1 class="slider-title">Welcome to ShoeCommerce</h1>
                    <p class="slider-description">Your one-stop shop for stylish, comfortable, and trendy footwear</p>
                    <a href="{{ route('shop.index') }}" class="slider-btn">Start Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Categories Section -->
<section class="categories-section fade-in">
    <div class="container">
        <h2 class="section-title">Shop by Category</h2>
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('shop.category', ['category' => $category->slug]) }}" class="category-card">
                        <div class="category-image">
                            <div class="category-icon">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="category-body">
                            <h3 class="category-name">{{ $category->name }}</h3>
                            <p class="category-desc">{{ $category->description ?? 'Explore collection' }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No categories available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Featured Deals Section -->
<section class="deals-section fade-in">
    <div class="container">
        <h2 class="section-title">Today's Featured Deals</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="deal-card">
                    <div class="deal-badge">🔥 HOT DEAL</div>
                    <h3 class="deal-title">Up to 50% OFF</h3>
                    <div class="deal-timer">23:45:12</div>
                    <p>On Premium Sneakers</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="deal-card">
                    <div class="deal-badge">⚡ FLASH SALE</div>
                    <h3 class="deal-title">Buy 2 Get 1 Free</h3>
                    <div class="deal-timer">12:30:45</div>
                    <p>Selected Sports Shoes</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="deal-card">
                    <div class="deal-badge">🎁 SPECIAL</div>
                    <h3 class="deal-title">Free Shipping</h3>
                    <div class="deal-timer">48:00:00</div>
                    <p>On Orders Above ₹999</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="products-section fade-in">
    <div class="container">
        <h2 class="section-title">Latest Products</h2>
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            @php
                                $image = $product->productImages->first()->image ?? 'default.jpg';
                            @endphp
                            <img src="{{ asset('storage/' . $image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-image">
                        </div>
                        <div class="product-body">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-rating">
                                <span class="stars">★★★★☆</span>
                                <span class="rating-count">(4.2)</span>
                            </div>
                            <div class="product-price">₹{{ number_format($product->price, 2) }}</div>
                            <div class="product-actions">
                                <a href="{{ route('product.details', $product->id) }}" class="btn-view">View Details</a>
                                <button class="btn-cart">🛒 Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No products available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="features-section fade-in">
    <div class="container">
        <h2 class="section-title">Why Choose ShoeCommerce?</h2>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3 class="feature-title">Fast Delivery</h3>
                    <p class="feature-desc">Quick & reliable shipping nationwide</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Secure Payment</h3>
                    <p class="feature-desc">100% safe & encrypted transactions</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3 class="feature-title">Quality Products</h3>
                    <p class="feature-desc">Authentic brands & guaranteed quality</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="feature-card">
                    <div class="feature-icon">↩️</div>
                    <h3 class="feature-title">Easy Returns</h3>
                    <p class="feature-desc">Hassle-free 30-day return policy</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    if (document.querySelector('.heroSwiper')) {
        const heroSwiper = new Swiper('.heroSwiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 1000,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }

    // Scroll Animation Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });

    // Countdown Timer Animation (Demo)
    function updateTimers() {
        document.querySelectorAll('.deal-timer').forEach(timer => {
            const time = timer.textContent.split(':');
            let hours = parseInt(time[0]);
            let minutes = parseInt(time[1]);
            let seconds = parseInt(time[2]);

            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
            }
            if (minutes < 0) {
                minutes = 59;
                hours--;
            }
            if (hours < 0) hours = 23;

            timer.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        });
    }

    setInterval(updateTimers, 1000);
});
</script>
@endpush
