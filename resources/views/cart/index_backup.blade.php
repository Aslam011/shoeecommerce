@extends('layouts.app')

@section('content')
<style>
  :root {
    --primary: #667eea;
    --primary-dark: #5a67d8;
    --primary-light: #e0e7ff;
    --secondary: #764ba2;
    --accent: #f093fb;
    --success: #10b981;
    --warning: #f59e0b;
    --error: #ef4444;
    --info: #06b6d4;

    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --bg-3d: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%);
    --surface: #ffffff;
    --surface-hover: #f1f5f9;

    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --text-muted: #94a3b8;
    --text-white: #ffffff;

    --border: #e2e8f0;
    --border-focus: #667eea;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --shadow-3d: 0 20px 40px rgba(0, 0, 0, 0.1), 0 10px 20px rgba(0, 0, 0, 0.08);

    --radius: 16px;
    --radius-lg: 20px;
    --spacing-xs: 0.25rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
  }

  * {
    box-sizing: border-box;
  }

  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: var(--bg-gradient);
    color: var(--text-primary);
    line-height: 1.6;
    overflow-x: hidden;
    position: relative;
  }

  /* 3D Background Elements */
  body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background:
      radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.15) 0%, transparent 50%),
      radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.15) 0%, transparent 50%),
      radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
    z-index: -1;
    animation: float 8s ease-in-out infinite;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(1deg); }
    66% { transform: translateY(5px) rotate(-1deg); }
  }

  /* Floating 3D Elements */
  .floating-shapes {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
    overflow: hidden;
  }

  .shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(145deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    backdrop-filter: blur(10px);
    animation: floatShape 15s ease-in-out infinite;
  }

  .shape:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
  }

  .shape:nth-child(2) {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 15%;
    animation-delay: 2s;
  }

  .shape:nth-child(3) {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
  }

  .shape:nth-child(4) {
    width: 70px;
    height: 70px;
    bottom: 10%;
    right: 10%;
    animation-delay: 6s;
  }

  @keyframes floatShape {
    0%, 100% {
      transform: translateY(0px) translateX(0px) scale(1);
    }
    25% {
      transform: translateY(-20px) translateX(10px) scale(1.1);
    }
    50% {
      transform: translateY(-10px) translateX(-10px) scale(0.9);
    }
    75% {
      transform: translateY(-30px) translateX(5px) scale(1.05);
    }
  }

  /* Progress Bar */
  .progress-container {
    max-width: 800px;
    margin: 2rem auto;
    background: var(--bg-3d);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-3d);
    overflow: hidden;
    transform: perspective(1000px) rotateX(5deg);
    transition: transform 0.3s ease;
  }

  .progress-container:hover {
    transform: perspective(1000px) rotateX(0deg);
  }

  .progress-header {
    background: var(--bg-gradient);
    color: white;
    padding: 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
  }

  .progress-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
    animation: shimmer 3s ease-in-out infinite;
  }

  .progress-title {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
    position: relative;
  }

  .progress-title i {
    font-size: 2rem;
    animation: bounce 2s ease-in-out infinite;
  }

  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
  }

  .progress-steps {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
    position: relative;
  }

  .step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    position: relative;
  }

  .step-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    border: 3px solid rgba(255, 255, 255, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    position: relative;
    overflow: hidden;
  }

  .step-circle::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: white;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: all 0.4s ease;
  }

  .step-circle.active {
    background: white;
    color: var(--primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3);
    animation: pulseGlow 2s ease-in-out infinite;
  }

  .step-circle.active::before {
    width: 100%;
    height: 100%;
  }

  @keyframes pulseGlow {
    0%, 100% {
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3);
      transform: scale(1);
    }
    50% {
      box-shadow: 0 0 0 8px rgba(102, 126, 234, 0.2);
      transform: scale(1.05);
    }
  }

  .step-line {
    height: 3px;
    background: rgba(255, 255, 255, 0.3);
    flex: 1;
    margin: 0 16px;
    position: relative;
    overflow: hidden;
    border-radius: 2px;
  }

  .step-line.completed {
    background: white;
    animation: fillLine 1.5s ease-out forwards;
  }

  @keyframes fillLine {
    from { width: 0; }
    to { width: 100%; }
  }

  .step-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    text-align: center;
    min-width: 70px;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  }

  /* Main Container */
  .checkout-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
    animation: fadeInUp 1s ease-out 0.3s both;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* 3D Card Styles */
  .checkout-card {
    background: var(--bg-3d);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-3d);
    overflow: hidden;
    margin-bottom: 2rem;
    transform: perspective(1000px) rotateX(2deg);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
  }

  .checkout-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--bg-gradient);
    z-index: 1;
  }

  .checkout-card:hover {
    transform: perspective(1000px) rotateX(0deg) translateY(-5px);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
  }

  .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid var(--border);
    padding: 24px 32px;
    display: flex;
    align-items: center;
    gap: 16px;
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.2rem;
    position: relative;
    z-index: 2;
  }

  .card-header i {
    font-size: 1.5rem;
    color: var(--primary);
    animation: iconBounce 2s ease-in-out infinite;
  }

  @keyframes iconBounce {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
  }

  .card-body {
    padding: 32px;
    position: relative;
  }

  /* Order Summary */
  .order-summary {
    background: var(--bg-3d);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-3d);
    overflow: hidden;
    position: sticky;
    top: 20px;
    height: fit-content;
    transform: perspective(1000px) rotateX(2deg);
    transition: all 0.4s ease;
  }

  .order-summary:hover {
    transform: perspective(1000px) rotateX(0deg) translateY(-5px);
  }

  .summary-header {
    background: var(--bg-gradient);
    color: white;
    padding: 20px 24px;
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .summary-header i {
    font-size: 1.3rem;
  }

  .summary-body {
    padding: 24px;
  }

  .summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
  }

  .summary-item:last-child {
    border-bottom: none;
    font-weight: 700;
    font-size: 1.1rem;
    color: var(--primary);
  }

  .summary-label {
    color: var(--text-secondary);
  }

  .summary-value {
    font-weight: 600;
    color: var(--text-primary);
  }

  /* Empty State */
  .empty-cart-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg);
    margin-bottom: 2rem;
  }

  .empty-cart-icon {
    font-size: 6rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
    animation: bounce 2s ease-in-out infinite;
  }

  .empty-cart-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
  }

  .empty-cart-text {
    color: var(--text-secondary);
    margin-bottom: 2rem;
  }

  /* Checkout Button */
  .checkout-button {
    background: var(--bg-gradient);
    color: white;
    border: none;
    padding: 16px 32px;
    border-radius: var(--radius);
    font-weight: 700;
    font-size: 1.1rem;
    width: 100%;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    margin-top: 1rem;
  }

  .checkout-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .checkout-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }

  .checkout-button.loading {
    pointer-events: none;
  }

  /* Trust Badges */
  .trust-badges {
    display: flex;
    justify-content: space-around;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
  }

  .trust-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    font-size: 0.85rem;
  }

  .trust-badge i {
    font-size: 1.2rem;
    color: var(--primary);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .checkout-container {
      padding: 0 var(--spacing-md);
    }

    .card-body {
      padding: 20px;
    }

    .progress-steps {
      gap: 8px;
    }

    .step-circle {
      width: 36px;
      height: 36px;
      font-size: 0.9rem;
    }

    .step-label {
      font-size: 0.7rem;
      min-width: 50px;
    }

    .address-grid {
      grid-template-columns: 1fr;
    }

    .payment-methods {
      grid-template-columns: 1fr;
    }

    .order-summary {
      margin-top: 2rem;
      position: static;
    }
  }

  /* Animations */
  @keyframes shimmer {
    0% { transform: translateX(-100%) skewX(-25deg); }
    100% { transform: translateX(100%) skewX(-25deg); }
  }

  /* Cart specific styles */
  .cart-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
  }

  .cart-table-container {
    background: var(--bg-3d);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-3d);
    overflow: hidden;
    margin-bottom: 24px;
  }

  .cart-table-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid var(--border);
  }

  .cart-table-header th {
    font-weight: 700;
    color: var(--text-primary);
    border: none;
    padding: 20px 16px;
    vertical-align: middle;
  }

  .cart-table-body td {
    padding: 20px 16px;
    vertical-align: middle;
    border-color: var(--border);
  }

  .product-info {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .product-image {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--border);
    transition: all 0.2s ease;
  }

  .product-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
  }

  .product-details h6 {
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px 0;
    font-size: 1rem;
  }

  .product-details small {
    color: var(--text-secondary);
  }

  .price-display {
    font-weight: 700;
    color: var(--primary);
    font-size: 1.1rem;
  }

  .quantity-controls {
    display: inline-flex;
    align-items: center;
    background: white;
    border: 2px solid var(--border);
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    max-width: 220px;
  }

  .qty-btn {
    width: 44px;
    height: 44px;
    border: 0;
    background: #f8fafc;
    color: var(--text);
    font-weight: 700;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .qty-btn:hover:not(:disabled) {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
  }

  .qty-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
  }

  .qty-input {
    width: 70px;
    height: 44px;
    border: 0;
    text-align: center;
    font-weight: 700;
    font-size: 1.1rem;
    background: white;
    color: var(--text);
  }

  .qty-input:focus {
    outline: none;
    background: #f8fafc;
  }

  .update-btn {
    background: var(--primary);
    color: white;
    border: 0;
    border-radius: 0 25px 25px 0;
    padding: 0 16px;
    font-weight: 600;
    transition: all 0.2s ease;
    height: 44px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .update-btn:hover {
    background: #2563eb;
    transform: translateX(2px);
  }

  .remove-btn {
    color: #ef4444;
    font-weight: 600;
    padding: 8px 12px;
    border-radius: 8px;
    border: 0;
    background: transparent;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .remove-btn:hover {
    background: #fef2f2;
    color: #dc2626;
    transform: translateY(-1px);
  }

  .cart-actions {
    display: flex;
    gap: 12px;
    margin-top: 16px;
  }

  .cart-actions .btn {
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
  }
</style>

<div class="floating-shapes">
  <div class="shape"></div>
  <div class="shape"></div>
  <div class="shape"></div>
  <div class="shape"></div>
</div>

<!-- Progress Bar -->
<div class="progress-container">
  <div class="progress-header">
    <div class="progress-title">
      <i class="fas fa-shopping-cart"></i>
      <span>Checkout Progress</span>
    </div>
    <div class="progress-steps">
      <div class="step-item">
        <div class="step-circle active">1</div>
        <span class="step-label">Cart</span>
      </div>
      <div class="step-line"></div>
      <div class="step-item">
        <div class="step-circle">2</div>
        <span class="step-label">Address</span>
      </div>
      <div class="step-line"></div>
      <div class="step-item">
        <div class="step-circle">3</div>
        <span class="step-label">Payment</span>
      </div>
      <div class="step-line"></div>
      <div class="step-item">
        <div class="step-circle">4</div>
        <span class="step-label">Complete</span>
      </div>
    </div>
  </div>
</div>

<div class="checkout-container">
  @if(isset($cartItems) && !empty($cartItems))
  <div class="row g-4">
    <!-- Left Column: Cart Items -->
    <div class="col-lg-8">
      <div class="checkout-card">
        <div class="card-header">
          <i class="fas fa-shopping-cart"></i>
          <span>Your Cart</span>
        </div>
        <div class="card-body">
          <div class="cart-table-container">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="cart-table-header">
                  <tr>
                    <th class="text-start">Product Details</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Total</th>
                    <th class="text-end"></th>
                  </tr>
                </thead>
                <tbody class="cart-table-body">
                  @foreach($cartItems as $item)
                  <tr class="align-middle">
                    <td>
                      <div class="product-info">
                        @php
                          $imageUrl = null;
                          if (!empty($item['image'])) {
                            try {
                              if (\Illuminate\Support\Facades\Storage::disk('public')->exists($item['image'])) {
                                $imageUrl = \Illuminate\Support\Facades\Storage::url($item['image']);
                              } else {
                                $imageUrl = asset($item['image']);
                              }
                            } catch (\Exception $e) {
                              $imageUrl = asset($item['image']);
                            }
                          }
                        @endphp

                        @if(!empty($imageUrl))
                        <img src="{{ $item['image'] ? asset($item['image']) : 'https://via.placeholder.com/80x80?text=No+Image' }}"
  alt="{{ $item['name'] }}"
  class="product-image"
  onerror="this.src='https://via.placeholder.com/80x80?text=No+Image'">
                        @else
                        <div class="product-image bg-light d-flex align-items-center justify-content-center rounded">
                          <i class="fas fa-image text-muted"></i>
                        </div>
                        @endif
                        <div class="product-details">
                          <h6 class="mb-1">{{ Str::limit($item['name'], 40) }}</h6>
                          <small class="text-muted d-block mb-1">
                            <i class="fas fa-barcode me-1"></i>ID: {{ $item['product_id'] }}
                          </small>
                          @if(isset($item['size']))
                          <span class="badge bg-light text-dark">
                            <i class="fas fa-ruler-combined me-1"></i>{{ $item['size'] }}
                          </span>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="price-display">
                        ₹<span class="item-price">{{ number_format($item['price'], 2) }}</span>
                      </div>
                      <small class="text-muted">each</small>
                    </td>
                    <td class="text-center">
                      <div class="quantity-controls">
                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline qty-form">
                          @csrf
                          @method('PATCH')
                          <div class="d-flex align-items-center">
                            <div class="qty-control d-inline-flex align-items-center">
                              <button type="button" class="qty-btn" onclick="changeQty(this, -1)" aria-label="Decrease quantity">
                                <i class="fas fa-minus"></i>
                              </button>
                              <input type="number"
                                     name="quantity"
                                     value="{{ $item['quantity'] }}"
                                     min="1"
                                     max="99"
                                     class="qty-input"
                                     data-price="{{ $item['price'] }}"
                                     onchange="updateQty(this)">
                              <button type="button" class="qty-btn" onclick="changeQty(this, 1)" aria-label="Increase quantity">
                                <i class="fas fa-plus"></i>
                              </button>
                            </div>

                            <!-- Update button visible on the right -->
                            <button type="submit" class="update-btn ms-3" disabled aria-label="Update quantity">
                              <i class="fas fa-sync-alt"></i>
                              <span>Update</span>
                            </button>
                          </div>
                        </form>
                      </div>
                    </td>

                    <td class="text-center">
                      <div class="total-display">
                        ₹<span class="item-total">{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                      </div>
                    </td>


                    <td class="text-end">
                      <form action="{{ route('cart.destroy', $item['id']) }}" method="POST" class="d-inline remove-form"
                        onsubmit="return confirm('Remove {{ $item['name'] }} from cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="remove-btn">
                          <i class="fas fa-trash-alt"></i>
                          <span>Remove</span>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Order Summary - Right Side Only --}}
    <div class="col-lg-4 d-none d-lg-block">
      <div class="order-summary">
        <div class="summary-header">
          <i class="fas fa-receipt"></i>
          <span>Order Summary</span>
        </div>

        <div class="summary-body">
          {{-- Items Summary --}}
          <div class="items-summary mb-4">
            @php $subtotal = 0; @endphp
            @forelse($cartItems as $item)
            @php
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            @endphp
            <div class="summary-item d-flex align-items-center gap-3 p-3 rounded mb-2 bg-light">
              @php
                // reuse image determination from earlier
                $smallImage = null;
                if (!empty($item['image'])) {
                  try {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($item['image'])) {
                      $smallImage = \Illuminate\Support\Facades\Storage::url($item['image']);
                    } else {
                      $smallImage = asset($item['image']);
                    }
                  } catch (\Exception $e) {
                    $smallImage = asset($item['image']);
                  }
                }
              @endphp
              <img src="{{ $smallImage ?? 'https://via.placeholder.com/40x40' }}" alt="{{ $item['name'] }}"
                class="rounded" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.onerror=null;this.src='https://via.placeholder.com/40x40?text=No+Image'">
              <div class="flex-grow-1">
                <small class="d-block text-truncate" style="max-width: 120px;">{{ Str::limit($item['name'], 25) }}</small>
                <small class="text-muted">×{{ $item['quantity'] }}</small>
              </div>
              <div class="text-end">
                <small class="text-muted d-block">₹{{ number_format($item['price'], 0) }}</small>
                <strong>₹{{ number_format($itemTotal, 2) }}</strong>
              </div>
            </div>
            @empty
            <div class="text-center py-3">
              <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
              <small class="text-muted">No items in cart</small>
            </div>
            @endforelse
          </div>

          {{-- Breakdown --}}
          <div class="breakdown-section">
            <div class="summary-item">
              <span class="label">Subtotal</span>
              <span class="value">₹{{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="summary-item">
              <span class="label">Shipping</span>
              <span class="value">
                @if($shipping > 0)
                ₹{{ number_format($shipping, 2) }}
                @else
                <span class="text-success">Free</span>
                @endif
              </span>
            </div>

            <div class="summary-item">
              <span class="label">Tax (7%)</span>
              <span class="value">₹{{ number_format($subtotal * 0.07, 2) }}</span>
            </div>

            @if(session('coupon_discount'))
            <div class="summary-item">
              <span class="label text-success">Coupon Discount</span>
              <span class="value text-success">-₹{{ number_format(session('coupon_discount'), 2) }}</span>
            </div>
            @endif

            <hr class="my-3 mx-n4">

            <div class="summary-item total-item">
              <span class="label h5 mb-0">Total Amount</span>
              <span class="value h4 mb-0" id="total-amount">₹{{ number_format($total, 2) }}</span>
            </div>
          </div>

          {{-- Coupon Input --}}
          <div class="coupon-input mt-4 p-3 bg-light rounded">
            <div class="input-group">
              <input type="text" class="form-control border-end-0" id="couponInput" placeholder="Enter coupon code"
                aria-label="Coupon code">
              <span class="input-group-text border-start-0 bg-white">
                <i class="fas fa-gift text-muted"></i>
              </span>
              <button class="btn btn-outline-secondary" type="button" id="applyCouponBtn">
                Apply
              </button>
            </div>
            <small class="text-muted mt-2 d-block">
              <i class="fas fa-info-circle me-1"></i>
              Enter coupon code to get discount on your order.
            </small>
          </div>

          {{-- Checkout Button --}}
          @if(count($cartItems) > 0)
          <a href="{{ route('checkout.index') }}" class="checkout-button d-block text-center">
            <i class="fas fa-arrow-right me-2"></i>
            <span>Continue to Checkout</span>
          </a>
          @endif

          {{-- Trust Indicators --}}
          <div class="trust-badges mt-4">
            <div class="trust-item">
              <i class="fas fa-shield-alt"></i>
              <span>Secure</span>
            </div>
            <div class="trust-item">
              <i class="fas fa-undo"></i>
              <span>Returns</span>
            </div>
            <div class="trust-item">
              <i class="fas fa-truck"></i>
              <span>Shipping</span>
            </div>
          </div>

          <small class="text-muted text-center d-block mt-3">
            <i class="fas fa-lock text-success me-1"></i>
            Your payment information is encrypted and secure
          </small>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="empty-cart-state">
    <div class="empty-cart-icon">
      <i class="fas fa-shopping-cart"></i>
    </div>
    <h2 class="empty-cart-title">🛒 Your Cart is Empty</h2>
    <p class="empty-cart-text">Looks like you haven't added anything to your cart yet.</p>
    <div class="empty-cart-buttons">
      <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
        <i class="fas fa-store me-2"></i>Start Shopping
      </a>
      <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg px-5">
        <i class="fas fa-home me-2"></i>Browse Home
      </a>
    </div>
    <div class="mt-4">
      <small class="text-muted">
        👉 <strong>Pro Tip:</strong> Add items to cart from the <a
          href="{{ route('shop.index') }}">Shop</a> page
      </small>
    </div>
  </div>
  @endif
</div>

{{-- Cart Enhancement Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Enhanced quantity controls
  const quantityInputs = document.querySelectorAll('input[name="quantity"]');
  quantityInputs.forEach(input => {
    // Enable update button on change but do NOT auto-submit
    input.addEventListener('change', function () {
      let val = parseInt(this.value);
      if (isNaN(val) || val < 1) this.value = 1;
      if (val > 99) this.value = 99;

      // Animate input
      this.style.transform = 'scale(1.02)';
      setTimeout(() => this.style.transform = 'scale(1)', 150);

      // Enable the update button within the same form
      const form = this.closest('form');
      if (form) {
        const updateBtn = form.querySelector('.update-btn');
< / s c r i p t > @ e n d s e c t i o n  
 