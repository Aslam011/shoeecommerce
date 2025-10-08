@extends('layouts.app')

@section('title', 'Checkout - ShoeCommerce')

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

  /* Header */
  .checkout-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
    animation: slideDown 0.8s ease-out;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .header-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--spacing-lg);
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 80px;
  }

  .brand {
    font-size: 1.8rem;
    font-weight: 800;
    background: var(--bg-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

  /* Form Styles */
  .form-group {
    margin-bottom: 24px;
    position: relative;
  }

  .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
    display: block;
    font-size: 1rem;
    transition: color 0.3s ease;
  }

  .form-control, .form-select {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid var(--border);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    position: relative;
    z-index: 1;
  }

  .form-control:focus, .form-select:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 16px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
    background: white;
  }

  .form-control:focus + .form-label,
  .form-control:not(:placeholder-shown) + .form-label {
    color: var(--primary);
    font-weight: 700;
  }

  /* Address Cards */
  .address-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .address-card {
    background: white;
    border: 2px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    transform: perspective(1000px) rotateX(0deg);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .address-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--bg-gradient);
    border-radius: 16px 16px 0 0;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .address-card:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    transform: perspective(1000px) rotateX(-2deg) translateY(-5px);
  }

  .address-card.selected {
    border-color: var(--primary);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02), rgba(118, 75, 162, 0.02));
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
    transform: perspective(1000px) rotateX(-2deg) translateY(-5px);
  }

  .address-card.selected::before {
    opacity: 1;
  }

  .address-radio {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 24px;
    height: 24px;
    accent-color: var(--primary);
    cursor: pointer;
    z-index: 2;
  }

  .address-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
  }

  .address-name {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.1rem;
  }

  .address-type {
    background: var(--bg-gradient);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .address-details {
    color: var(--text-secondary);
    line-height: 1.6;
    font-size: 0.95rem;
  }

  /* Payment Methods */
  .payment-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
  }

  .payment-option {
    background: white;
    border: 2px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    transform: perspective(1000px) rotateX(0deg);
  }

  .payment-option:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    transform: perspective(1000px) rotateX(-2deg) translateY(-3px);
  }

  .payment-option.selected {
    border-color: var(--primary);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    transform: perspective(1000px) rotateX(-2deg) translateY(-3px);
  }

  .payment-radio {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    accent-color: var(--primary);
    cursor: pointer;
  }

  .payment-content {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .payment-icon {
    width: 48px;
    height: 48px;
    background: var(--bg-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
  }

  .payment-info h6 {
    margin: 0;
    color: var(--text-primary);
    font-weight: 700;
  }

  .payment-info p {
    margin: 0;
    color: var(--text-secondary);
    font-size: 0.9rem;
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

  /* Place Order Button */
  .place-order-btn {
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

  .place-order-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .place-order-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
  }

  .place-order-btn.loading {
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

  /* Attractive Styles for Add Address Section */
  .add-address-section {
    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.1);
    padding: 32px;
    margin-top: 24px;
    animation: fadeInUp 0.8s ease-out;
  }

  .add-address-section h4 {
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
  }

  .add-address-section .autofill-text {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 24px;
  }

  .add-address-section .form-control {
    border-color: var(--primary-light);
  }

  .add-address-section .form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
  }

  .add-address-section .btn-primary {
    background: var(--bg-gradient);
    border: none;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
  }

  .add-address-section .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
  }

  .add-address-section .form-check-label {
    color: var(--text-primary);
  }

  .state-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 12px;
  }

  .is-invalid {
    border-color: var(--error) !important;
  }

  .invalid-feedback {
    color: var(--error);
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  .address-actions {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 8px;
  }

  .btn-sm {
    padding: 6px 12px;
    font-size: 0.875rem;
  }

  .d-flex {
    display: flex;
  }

  .gap-2 {
    gap: 0.5rem;
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
      <div class="step-line completed"></div>
      <div class="step-item">
        <div class="step-circle active">2</div>
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
  <!-- Error Messages -->
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</h5>
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(isset($cartItems) && !empty($cartItems))
  <div class="row g-4">
    <!-- Left Column: Forms -->
    <div class="col-lg-8">
      <form id="checkoutForm" method="POST" action="{{ route('checkout.placeOrder') }}">
        @csrf

        <!-- Address Section -->
<div class="checkout-card">
  <div class="card-header">
    <i class="fas fa-map-marker-alt"></i>
    <span>Delivery Address</span>
  </div>
  <div class="card-body">
    @auth('customer')
      <div id="addressSection">
        @if($addresses->count() > 0)
          <div class="address-grid" id="addressGrid">
            @foreach($addresses as $address)
            <div class="address-card {{ $address->is_default ? 'selected' : '' }}" onclick="selectAddress('{{ $address->id }}', event)">
              <input type="radio" name="selected_address" value="{{ $address->id }}" class="address-radio" id="address_{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
              <div class="address-header">
                <div class="address-name">{{ $address->first_name }} {{ $address->last_name }}</div>
                <div class="address-type">{{ strtoupper($address->type) }}</div>
              </div>
              <div class="address-details">
                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}
                <div class="mt-2">Phone: {{ $address->phone }}</div>
              </div>
              <div class="address-actions">
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteAddress('{{ $address->id }}', event)">
                  <i class="fas fa-trash me-1"></i>Delete
                </button>
              </div>
              <input type="hidden" data-address-id="{{ $address->id }}" 
                     data-full-name="{{ $address->first_name }} {{ $address->last_name }}"
                     data-phone="{{ $address->phone }}"
                     data-address="{{ $address->address }}"
                     data-city="{{ $address->city }}"
                     data-state="{{ $address->state }}"
                     data-postal="{{ $address->postal_code }}"
                     class="address-data">
            </div>
            @endforeach
          </div>
          <div class="mt-3 d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" onclick="editSelectedAddress()" id="changeAddressBtn">
              <i class="fas fa-edit me-2"></i>Change Selected Address
            </button>
            <button type="button" class="btn btn-outline-success" onclick="openAddNewAddressForm()" id="addNewAddressBtn">
              <i class="fas fa-plus me-2"></i>Add New Address
            </button>
          </div>
        @else
          <p class="text-muted mb-3" id="noAddressMessage">No saved addresses. Please add a new one.</p>
          <button type="button" class="btn btn-outline-primary mt-3" onclick="toggleAddAddressForm()" id="addAddressBtn">
            <i class="fas fa-plus me-2"></i>Add New Address
          </button>
        @endif
      </div>
    @else
      <button type="button" class="btn btn-outline-primary mt-3" onclick="toggleAddAddressForm()" id="addAddressBtn">
        <i class="fas fa-plus me-2"></i>Add New Address
      </button>
    @endauth

    <!-- Add New Address Section -->
    <div id="addAddressForm" style="display: none;" class="add-address-section">
      <h4 id="addressFormTitle">Enter a new delivery address</h4>
      <p class="autofill-text">Save time. Autofill your current location.</p>
      <p>India</p>
      <input type="hidden" id="editingAddressId" value="">
      <div class="row g-3">
        <div class="col-12 form-group">
          <label class="form-label">Full name (First and Last name) *</label>
          <input type="text" name="full_name" class="form-control" required value="{{ auth('customer')->check() ? auth('customer')->user()->full_name ?? '' : '' }}">
          <div class="invalid-feedback">Please enter your full name.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Mobile number *</label>
          <input type="tel" name="mobile_number" class="form-control" required pattern="[0-9]{10}" title="10-digit mobile number" value="{{ auth('customer')->check() ? auth('customer')->user()->mobile_number ?? '' : '' }}">
          <small class="text-muted">May be used to assist delivery</small>
          <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Pincode *</label>
          <input type="text" name="pincode" class="form-control" required pattern="\d{6}" title="6-digit PIN code">
          <div class="invalid-feedback">Please enter a valid 6-digit PIN code.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Flat, House no., Building, Company, Apartment *</label>
          <input type="text" name="flat_house_no" class="form-control" required>
          <div class="invalid-feedback">Please enter your house or flat number.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Area, Street, Sector, Village *</label>
          <input type="text" name="area_street" class="form-control" required>
          <div class="invalid-feedback">Please enter your street or area.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Landmark</label>
          <input type="text" name="landmark" class="form-control">
        </div>
        <div class="col-12 form-group">
          <label class="form-label">Town/City *</label>
          <input type="text" name="town_city" class="form-control" required>
          <div class="invalid-feedback">Please enter your town or city.</div>
        </div>
        <div class="col-12 form-group">
          <label class="form-label">State *</label>
          <select name="state" class="form-select state-select" required>
            <option value="">Choose a state</option>
            <option value="Andhra Pradesh">Andhra Pradesh</option>
            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
            <option value="Assam">Assam</option>
            <option value="Bihar">Bihar</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Goa">Goa</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Haryana">Haryana</option>
            <option value="Himachal Pradesh">Himachal Pradesh</option>
            <option value="Jharkhand">Jharkhand</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Kerala">Kerala</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Manipur">Manipur</option>
            <option value="Meghalaya">Meghalaya</option>
            <option value="Mizoram">Mizoram</option>
            <option value="Nagaland">Nagaland</option>
            <option value="Odisha">Odisha</option>
            <option value="Punjab">Punjab</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Sikkim">Sikkim</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Tripura">Tripura</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
            <option value="Uttarakhand">Uttarakhand</option>
            <option value="West Bengal">West Bengal</option>
            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
            <option value="Chandigarh">Chandigarh</option>
            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
            <option value="Delhi">Delhi</option>
            <option value="Lakshadweep">Lakshadweep</option>
            <option value="Puducherry">Puducherry</option>
          </select>
          <div class="invalid-feedback">Please select a state.</div>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="defaultAddress" name="default_address">
            <label class="form-check-label" for="defaultAddress">Make this my default address</label>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <button type="button" class="btn btn-primary" onclick="validateAndSaveAddress()">Use this address</button>
      </div>
    </div>
  </div>
</div>

        <!-- Payment Section -->
        <div class="checkout-card">
          <div class="card-header">
            <i class="fas fa-credit-card"></i>
            <span>Payment Method</span>
          </div>
          <div class="card-body">
            <div class="payment-methods">
              @forelse($paymentGateways as $gateway)
                <div class="payment-option" onclick="selectPayment('{{ $gateway->name }}', this)">
                  <div class="payment-content">
                    <div class="payment-icon">
                      @if($gateway->name == 'razorpay')
                        <i class="fas fa-credit-card"></i>
                      @elseif($gateway->name == 'phonepe')
                        <i class="fas fa-mobile-alt"></i>
                      @elseif($gateway->name == 'paytm')
                        <i class="fab fa-paypal"></i>
                      @elseif($gateway->name == 'cashfree')
                        <i class="fas fa-wallet"></i>
                      @else
                        <i class="fas fa-credit-card"></i>
                      @endif
                    </div>
                    <div class="payment-info">
                      <h6>{{ $gateway->display_name }}</h6>
                      <p>
                        @if($gateway->supports_upi)
                          <i class="fas fa-check-circle text-success"></i> UPI, Cards & More
                        @else
                          Cards & Net Banking
                        @endif
                      </p>
                    </div>
                  </div>
                  <input type="radio" name="payment_method" value="{{ $gateway->name }}" class="payment-radio" id="{{ $gateway->name }}">
                </div>
              @empty
                <div class="alert alert-warning">
                  <i class="fas fa-exclamation-triangle me-2"></i>
                  <strong>No payment methods available.</strong><br>
                  Please contact administrator to configure payment gateways.
                </div>
              @endforelse
            </div>
            <div class="mt-4 p-3 bg-light rounded">
              <small class="text-muted"><i class="fas fa-lock me-2"></i>Secure payment. Your info is protected.</small>
            </div>
          </div>
        </div>

        <!-- Hidden Inputs for Guest Address -->
        <div id="guestAddressInputs" style="display: none;">
          <input type="hidden" name="use_new_address" value="0">
          <input type="hidden" name="guest_full_name">
          <input type="hidden" name="guest_mobile_number">
          <input type="hidden" name="guest_pincode">
          <input type="hidden" name="guest_flat_house_no">
          <input type="hidden" name="guest_area_street">
          <input type="hidden" name="guest_landmark">
          <input type="hidden" name="guest_town_city">
          <input type="hidden" name="guest_state">
          <input type="hidden" name="guest_country" value="India">
        </div>
      </form>
    </div>

    <!-- Right Column: Order Summary -->
    <div class="col-lg-4">
      <div class="order-summary">
        <div class="summary-header">
          <i class="fas fa-receipt"></i>
          <span>Order Summary</span>
        </div>
        <div class="summary-body">
          @php 
            $calculatedSubtotal = 0; 
            $shipping = 10;
            $taxRate = 0.07;
          @endphp
          @foreach($cartItems as $item)
            @php
              $itemPrice = $item['price'] ?? 0;
              $itemQty = $item['quantity'] ?? 1;
              $itemTotal = $itemPrice * $itemQty;
              $calculatedSubtotal += $itemTotal;
            @endphp
            <div class="summary-item">
              <div class="summary-label">
                <div>{{ Str::limit($item['name'] ?? 'Product', 30) }}</div>
                <small class="text-muted">Qty: {{ $itemQty }}</small>
              </div>
              <div class="summary-value">₹{{ number_format($itemTotal, 2) }}</div>
            </div>
          @endforeach
          <div class="border-top pt-3">
            <div class="summary-item">
              <span class="summary-label">Subtotal</span>
              <span class="summary-value">₹{{ number_format($calculatedSubtotal, 2) }}</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Shipping</span>
              <span class="summary-value">₹{{ number_format($shipping, 2) }}</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Tax (7%)</span>
              <span class="summary-value">₹{{ number_format($calculatedSubtotal * $taxRate, 2) }}</span>
            </div>
            <div class="summary-item">
              <span class="summary-label fw-bold">Total</span>
              <span class="summary-value fw-bold text-primary">₹{{ number_format($calculatedSubtotal + $shipping + ($calculatedSubtotal * $taxRate), 2) }}</span>
            </div>
          </div>
          <button type="button" onclick="submitCheckoutForm()" class="place-order-btn" id="placeOrderBtn">
            <i class="fas fa-lock me-2"></i>Place Order - ₹{{ number_format($calculatedSubtotal + $shipping + ($calculatedSubtotal * $taxRate), 2) }}
          </button>
          <div class="trust-badges">
            <div class="trust-badge">
              <i class="fas fa-shield-alt"></i>
              <span>Secure</span>
            </div>
            <div class="trust-badge">
              <i class="fas fa-truck"></i>
              <span>Fast Shipping</span>
            </div>
            <div class="trust-badge">
              <i class="fas fa-undo"></i>
              <span>Returns</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="empty-cart-state">
    <div class="empty-cart-icon">
      <i class="fas fa-shopping-cart"></i>
    </div>
    <h2 class="empty-cart-title">Your Cart is Empty</h2>
    <p class="empty-cart-text">It looks like you haven't added any items to your cart yet.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
      <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
    </a>
  </div>
  @endif
</div>

<script>
let selectedAddressId = null;
let selectedPaymentMethod = null;
let isAuth = {!! auth('customer')->check() ? 'true' : 'false' !!};

// Function to submit checkout form
function submitCheckoutForm() {
  const form = document.getElementById('checkoutForm');
  const paymentChecked = document.querySelector('input[name="payment_method"]:checked');
  const addressChecked = document.querySelector('input[name="selected_address"]:checked');
  
  // Check if selections are made
  if (!addressChecked) {
    alert('Please select a delivery address');
    return false;
  }
  
  if (!paymentChecked) {
    alert('Please select a payment method');
    return false;
  }
  
  // Submit form
  form.submit();
}

// Initialize default address selection and enable button
document.addEventListener('DOMContentLoaded', function() {
  const defaultAddress = document.querySelector('.address-card.selected');
  if (defaultAddress) {
    const addressId = defaultAddress.querySelector('input[name="selected_address"]').value;
    selectedAddressId = addressId;
  }
  
  // ALWAYS enable button - server will validate
  const btn = document.getElementById('placeOrderBtn');
  if (btn) {
    btn.disabled = false;
    btn.style.cursor = 'pointer';
    btn.style.opacity = '1';
  }
  
  // Re-enable button every 500ms to prevent any script from disabling it
  setInterval(function() {
    const btn = document.getElementById('placeOrderBtn');
    if (btn && btn.disabled) {
      btn.disabled = false;
      btn.style.cursor = 'pointer';
      btn.style.opacity = '1';
    }
  }, 500);
});

function selectAddress(id, event) {
  if (event) {
    event.stopPropagation();
  }
  selectedAddressId = id;
  
  // Remove selected class from all cards
  document.querySelectorAll('.address-card').forEach(card => card.classList.remove('selected'));
  
  // Add selected class to clicked card
  if (event && event.currentTarget) {
    event.currentTarget.classList.add('selected');
  }
  
  // Check the radio button
  const radio = document.getElementById(`address_${id}`);
  if (radio) {
    radio.checked = true;
  }
  
  // Button always enabled - server validates
}

function openAddNewAddressForm() {
  const form = document.getElementById('addAddressForm');
  const title = document.getElementById('addressFormTitle');
  const editingId = document.getElementById('editingAddressId');
  
  // Clear form
  form.querySelectorAll('input[type="text"], input[type="tel"], select').forEach(input => {
    input.value = '';
  });
  form.querySelector('input[type="checkbox"]').checked = false;
  
  // Set to add mode
  editingId.value = '';
  title.textContent = 'Enter a new delivery address';
  form.style.display = 'block';
  
  // Hide address grid
  const addressGrid = document.getElementById('addressGrid');
  if (addressGrid) {
    addressGrid.style.display = 'none';
  }
}

function editSelectedAddress() {
  if (!selectedAddressId) {
    alert('Please select an address first');
    return;
  }
  
  const selectedCard = document.querySelector(`.address-card.selected`);
  if (!selectedCard) {
    alert('Please select an address first');
    return;
  }
  
  // Get address data from hidden input
  const addressDataInput = selectedCard.querySelector('.address-data');
  if (!addressDataInput) {
    alert('Address data not found');
    return;
  }
  
  const addressId = addressDataInput.dataset.addressId;
  const fullName = addressDataInput.dataset.fullName;
  const phone = addressDataInput.dataset.phone;
  const address = addressDataInput.dataset.address;
  const city = addressDataInput.dataset.city;
  const state = addressDataInput.dataset.state;
  const postal = addressDataInput.dataset.postal;
  
  // Fill the form
  const form = document.getElementById('addAddressForm');
  form.querySelector('[name="full_name"]').value = fullName;
  form.querySelector('[name="mobile_number"]').value = phone;
  form.querySelector('[name="pincode"]').value = postal;
  form.querySelector('[name="town_city"]').value = city;
  form.querySelector('[name="state"]').value = state;
  
  // Split address into parts
  const addressArr = address.split(',').map(part => part.trim());
  form.querySelector('[name="flat_house_no"]').value = addressArr[0] || '';
  form.querySelector('[name="area_street"]').value = addressArr[1] || '';
  form.querySelector('[name="landmark"]').value = addressArr[2] || '';
  
  // Set editing mode
  document.getElementById('editingAddressId').value = addressId;
  document.getElementById('addressFormTitle').textContent = 'Edit delivery address';
  
  // Show form, hide grid
  form.style.display = 'block';
  const addressGrid = document.getElementById('addressGrid');
  if (addressGrid) {
    addressGrid.style.display = 'none';
  }
}

function toggleAddAddressForm() {
  const form = document.getElementById('addAddressForm');
  if (form.style.display === 'none') {
    openAddNewAddressForm();
  } else {
    form.style.display = 'none';
    const addressGrid = document.getElementById('addressGrid');
    if (addressGrid) {
      addressGrid.style.display = 'grid';
    }
  }
}

function selectPayment(method, element) {
  selectedPaymentMethod = method;
  
  // Remove selected class from all payment options
  document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
  
  // Add selected class to clicked element
  if (element) {
    element.classList.add('selected');
  }
  
  // Check the radio button
  const radio = document.getElementById(method);
  if (radio) {
    radio.checked = true;
  }
  
  // Button always enabled - server validates
}

function validateAndSaveAddress() {
  const form = document.getElementById('addAddressForm');
  if (!form) {
    console.error('Form not found');
    return;
  }

  const inputs = form.querySelectorAll('input[required], select[required]');
  let valid = true;

  inputs.forEach(input => {
    if (!input.value || !input.value.trim()) {
      input.classList.add('is-invalid');
      valid = false;
    } else {
      input.classList.remove('is-invalid');
    }
  });

  if (!valid) {
    alert('Please fill all required fields.');
    return;
  }

  const fullName = form.querySelector('[name="full_name"]').value;
  const mobile = form.querySelector('[name="mobile_number"]').value;
  const pincode = form.querySelector('[name="pincode"]').value;
  const flatHouseNo = form.querySelector('[name="flat_house_no"]').value;
  const areaStreet = form.querySelector('[name="area_street"]').value;
  const landmark = form.querySelector('[name="landmark"]').value || '';
  const townCity = form.querySelector('[name="town_city"]').value;
  const state = form.querySelector('[name="state"]').value;
  const type = 'home';
  const defaultAddress = form.querySelector('[name="default_address"]').checked ? 1 : 0;

  console.log('Submitting address:', { fullName, mobile, pincode, flatHouseNo, areaStreet, townCity, state });

  form.style.display = 'none';
  const btn = document.getElementById('changeAddressBtn') || document.getElementById('addAddressBtn');
  btn.innerHTML = '<i class="fas fa-edit me-2"></i>Change or Add New Address';
  btn.style.display = 'block';

  if (!isAuth) {
    const addressGrid = document.getElementById('addressGrid') || document.createElement('div');
    if (!addressGrid.id) {
      addressGrid.className = 'address-grid';
      addressGrid.id = 'addressGrid';
      const addressSection = document.getElementById('addressSection') || document.querySelector('.card-body');
      addressSection.insertBefore(addressGrid, btn);
    }
    const noAddressMessage = document.getElementById('noAddressMessage');
    if (noAddressMessage) {
      noAddressMessage.remove();
    }
    const newCard = document.createElement('div');
    newCard.className = 'address-card selected';
    newCard.innerHTML = `
      <div class="address-header">
        <div class="address-name">${fullName}</div>
        <div class="address-type">${type.toUpperCase()}</div>
      </div>
      <div class="address-details">
        ${flatHouseNo}, ${areaStreet}${landmark ? ', ' + landmark : ''}, ${townCity}, ${state} - ${pincode}
      </div>
    `;
    addressGrid.appendChild(newCard);
    selectedAddressId = 'new';

    const guestInputs = document.getElementById('guestAddressInputs');
    guestInputs.querySelector('[name="use_new_address"]').value = '1';
    guestInputs.querySelector('[name="guest_full_name"]').value = fullName;
    guestInputs.querySelector('[name="guest_mobile_number"]').value = mobile;
    guestInputs.querySelector('[name="guest_pincode"]').value = pincode;
    guestInputs.querySelector('[name="guest_flat_house_no"]').value = flatHouseNo;
    guestInputs.querySelector('[name="guest_area_street"]').value = areaStreet;
    guestInputs.querySelector('[name="guest_landmark"]').value = landmark;
    guestInputs.querySelector('[name="guest_town_city"]').value = townCity;
    guestInputs.querySelector('[name="guest_state"]').value = state;

    // Button always enabled - server validates
    return;
  }

  const formData = new FormData();
  formData.append('full_name', fullName);
  formData.append('mobile_number', mobile);
  formData.append('pincode', pincode);
  formData.append('flat_house_no', flatHouseNo);
  formData.append('area_street', areaStreet);
  formData.append('landmark', landmark);
  formData.append('town_city', townCity);
  formData.append('state', state);
  formData.append('country', 'India');
  formData.append('type', type);
  formData.append('default_address', defaultAddress);
  // Get fresh CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
  formData.append('_token', csrfToken);

  const editingId = document.getElementById('editingAddressId').value;
  const isEditing = editingId && editingId !== '';
  
  const url = isEditing ? `{{ url('/addresses') }}/${editingId}` : '{{ route("addresses.store") }}';

  if (isEditing) {
    formData.append('_method', 'PUT');
  }

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    }
  })
  .then(response => {
    if (!response.ok) {
      return response.text().then(text => { throw new Error(`HTTP ${response.status}: ${text}`); });
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      const addressGrid = document.getElementById('addressGrid');
      const noAddressMessage = document.getElementById('noAddressMessage');
      
      if (isEditing) {
        // Update existing card
        const existingCard = document.querySelector(`.address-card input[value="${editingId}"]`)?.closest('.address-card');
        if (existingCard) {
          // Remove all selected classes
          document.querySelectorAll('.address-card').forEach(card => card.classList.remove('selected'));
          
          existingCard.classList.add('selected');
          existingCard.querySelector('.address-name').textContent = fullName;
          existingCard.querySelector('.address-details').innerHTML = `
            ${flatHouseNo}, ${areaStreet}${landmark ? ', ' + landmark : ''}, ${townCity}, ${state} - ${pincode}
            <div class="mt-2">Phone: ${mobile}</div>
          `;
          
          // Update hidden data
          const dataInput = existingCard.querySelector('.address-data');
          if (dataInput) {
            dataInput.dataset.fullName = fullName;
            dataInput.dataset.phone = mobile;
            dataInput.dataset.address = `${flatHouseNo}, ${areaStreet}${landmark ? ', ' + landmark : ''}`;
            dataInput.dataset.city = townCity;
            dataInput.dataset.state = state;
            dataInput.dataset.postal = pincode;
          }
        }
      } else {
        // Remove all previously selected addresses
        document.querySelectorAll('.address-card').forEach(card => card.classList.remove('selected'));
        
        const newCard = document.createElement('div');
        newCard.className = 'address-card selected';
        newCard.onclick = function(event) { selectAddress(data.address_id, event); };
        newCard.innerHTML = `
          <input type="radio" name="selected_address" value="${data.address_id}" class="address-radio" id="address_${data.address_id}" checked>
          <div class="address-header">
            <div class="address-name">${fullName}</div>
            <div class="address-type">${type.toUpperCase()}</div>
          </div>
          <div class="address-details">
            ${flatHouseNo}, ${areaStreet}${landmark ? ', ' + landmark : ''}, ${townCity}, ${state} - ${pincode}
            <div class="mt-2">Phone: ${mobile}</div>
          </div>
          <div class="address-actions">
            <button type="button" class="btn btn-sm btn-danger" onclick="deleteAddress('${data.address_id}', event)">
              <i class="fas fa-trash me-1"></i>Delete
            </button>
          </div>
          <input type="hidden" data-address-id="${data.address_id}" 
                 data-full-name="${fullName}"
                 data-phone="${mobile}"
                 data-address="${flatHouseNo}, ${areaStreet}${landmark ? ', ' + landmark : ''}"
                 data-city="${townCity}"
                 data-state="${state}"
                 data-postal="${pincode}"
                 class="address-data">
        `;
        
        if (addressGrid) {
          addressGrid.appendChild(newCard);
        } else {
          const newGrid = document.createElement('div');
          newGrid.className = 'address-grid';
          newGrid.id = 'addressGrid';
          newGrid.appendChild(newCard);
          const addressSection = document.getElementById('addressSection');
          if (noAddressMessage) {
            noAddressMessage.remove();
          }
          addressSection.insertBefore(newGrid, btn);
        }
      }
      
      selectedAddressId = data.address_id;
      
      // Show address grid and hide form
      if (addressGrid) {
        addressGrid.style.display = 'grid';
      }
      
      // Auto-select the newly created address
      const newAddressCard = document.querySelector(`.address-card[onclick*="${data.address_id}"]`);
      if (newAddressCard) {
        document.querySelectorAll('.address-card').forEach(card => card.classList.remove('selected'));
        newAddressCard.classList.add('selected');
        const newRadio = document.getElementById(`address_${data.address_id}`);
        if (newRadio) {
          newRadio.checked = true;
        }
      }
      
      // Button always enabled - server validates
      alert(isEditing ? 'Address updated successfully!' : 'Address saved successfully!');
    } else {
      form.style.display = 'block';
      btn.innerHTML = '<i class="fas fa-plus me-2"></i>Change or Add New Address';
      alert(data.message || 'Error saving address.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    form.style.display = 'block';
    btn.innerHTML = '<i class="fas fa-plus me-2"></i>Change or Add New Address';
    alert(`Error saving address: ${error.message}`);
  });
}

function toggleAddAddressForm(show = null) {
    const section = document.getElementById('addAddressForm');
    if (!section) return;

    if (show === true) {
        section.style.display = 'block';
    } else if (show === false) {
        section.style.display = 'none';
    } else {
        section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
    }
}

function deleteAddress(addressId, event) {
  event.stopPropagation();
  
  if (!confirm('Are you sure you want to delete this address?')) {
    return;
  }
  
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
  const formData = new FormData();
  formData.append('_method', 'DELETE');
  formData.append('_token', csrfToken);
  
  fetch(`{{ url('/addresses') }}/${addressId}`, {
    method: 'POST',
    body: formData,
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    }
  })
  .then(response => {
    if (!response.ok) {
      return response.text().then(text => { throw new Error(`HTTP ${response.status}: ${text}`); });
    }
    return response.json();
  })
  .then(data => {
    if (data.success) {
      // Find and remove the address card
      const addressCard = document.querySelector(`.address-card input[value="${addressId}"]`)?.closest('.address-card');
      if (addressCard) {
        const wasSelected = addressCard.classList.contains('selected');
        addressCard.remove();
        
        // If deleted address was selected, clear selection
        if (wasSelected) {
          selectedAddressId = null;
          // Button always enabled - server validates
        }
        
        // Check if there are any addresses left
        const remainingAddresses = document.querySelectorAll('.address-card');
        if (remainingAddresses.length === 0) {
          const addressGrid = document.getElementById('addressGrid');
          if (addressGrid) {
            addressGrid.innerHTML = '<p class="text-muted mb-3" id="noAddressMessage">No saved addresses. Please add a new one.</p>';
          }
        }
      }
      
      alert('Address deleted successfully!');
    } else {
      alert(data.message || 'Error deleting address.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert(`Error deleting address: ${error.message}`);
  });
}

</script>
@endsection