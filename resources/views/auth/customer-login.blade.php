<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ShoeCommerce — Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      /* Modern Light Theme Colors */
      --primary: #667eea;
      --primary-dark: #5a67d8;
      --primary-light: #e0e7ff;
      --secondary: #764ba2;
      --accent: #f093fb;
      --success: #10b981;
      --warning: #f59e0b;
      --error: #ef4444;
      
      /* Background & Surface */
      --bg-primary: #ffffff;
      --bg-secondary: #f8fafc;
      --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --surface: #ffffff;
      --surface-hover: #f1f5f9;
      
      /* Text Colors */
      --text-primary: #1e293b;
      --text-secondary: #64748b;
      --text-muted: #94a3b8;
      --text-white: #ffffff;
      
      /* Borders & Shadows */
      --border: #e2e8f0;
      --border-focus: #667eea;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      
      /* Spacing & Sizing */
      --radius: 12px;
      --radius-lg: 16px;
      --spacing-xs: 0.25rem;
      --spacing-sm: 0.5rem;
      --spacing-md: 1rem;
      --spacing-lg: 1.5rem;
      --spacing-xl: 2rem;
    }

    /* Reset & Base Styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      height: 100%;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: var(--bg-gradient);
      color: var(--text-primary);
      line-height: 1.6;
      overflow-x: hidden;
      animation: fadeIn 0.8s ease-out;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    @keyframes shimmer {
      0% { background-position: -200px 0; }
      100% { background-position: calc(200px + 100%) 0; }
    }

    /* Background Elements */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
      z-index: -1;
      animation: float 6s ease-in-out infinite;
    }

    /* Header */
    header {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 100;
      animation: slideUp 0.6s ease-out;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 var(--spacing-lg);
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 70px;
    }

    .brand {
      font-size: 1.5rem;
      font-weight: 700;
      background: var(--bg-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.02em;
    }

    nav ul {
      display: flex;
      list-style: none;
      gap: var(--spacing-xl);
      align-items: center;
    }

    nav a {
      color: var(--text-secondary);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      padding: var(--spacing-sm) var(--spacing-md);
      border-radius: var(--radius);
    }

    nav a:hover {
      color: var(--primary);
      background: var(--primary-light);
      transform: translateY(-2px);
    }

    nav a[aria-current="page"] {
      color: var(--primary);
      background: var(--primary-light);
      font-weight: 600;
    }

    /* Main Content */
    main {
      min-height: calc(100vh - 140px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--spacing-xl);
      position: relative;
    }

    /* Login Card */
    .login-container {
      width: 100%;
      max-width: 440px;
      animation: slideUp 0.8s ease-out 0.2s both;
    }

    .card {
      background: var(--surface);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-xl);
      overflow: hidden;
      border: 1px solid var(--border);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--bg-gradient);
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .card-header {
      padding: var(--spacing-xl);
      text-align: center;
      background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
      border-bottom: 1px solid var(--border);
    }

    .card-title {
      font-size: 1.875rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: var(--spacing-sm);
      letter-spacing: -0.02em;
    }

    .card-subtitle {
      color: var(--text-secondary);
      font-size: 0.95rem;
    }

    .card-body {
      padding: var(--spacing-xl);
    }

    /* Form Styles */
    .form-group {
      margin-bottom: var(--spacing-lg);
      position: relative;
    }

    .form-group.floating-label {
      position: relative;
    }

    .form-input {
      width: 100%;
      padding: 1rem var(--spacing-md);
      border: 2px solid var(--border);
      border-radius: var(--radius);
      font-size: 1rem;
      transition: all 0.3s ease;
      background: var(--bg-secondary);
      color: var(--text-primary);
      outline: none;
    }

    .form-input:focus {
      border-color: var(--border-focus);
      background: var(--bg-primary);
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      transform: translateY(-2px);
    }

    .form-input:focus + .form-label,
    .form-input:not(:placeholder-shown) + .form-label {
      transform: translateY(-1.5rem) scale(0.85);
      color: var(--primary);
      font-weight: 600;
    }

    .form-label {
      position: absolute;
      left: var(--spacing-md);
      top: 1rem;
      color: var(--text-secondary);
      font-size: 1rem;
      font-weight: 500;
      transition: all 0.3s ease;
      pointer-events: none;
      background: var(--bg-secondary);
      padding: 0 var(--spacing-xs);
      border-radius: var(--spacing-xs);
    }

    .form-input:focus + .form-label {
      background: var(--bg-primary);
    }

    /* Checkbox Styles */
    .checkbox-group {
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
      margin: var(--spacing-lg) 0;
    }

    .checkbox-input {
      width: 18px;
      height: 18px;
      accent-color: var(--primary);
      cursor: pointer;
    }

    .checkbox-label {
      color: var(--text-secondary);
      font-size: 0.9rem;
      cursor: pointer;
      user-select: none;
    }

    /* Button Styles */
    .btn {
      width: 100%;
      padding: 1rem var(--spacing-lg);
      border: none;
      border-radius: var(--radius);
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-primary {
      background: var(--bg-gradient);
      color: var(--text-white);
      box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
      filter: brightness(1.1);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn-primary:hover::before {
      left: 100%;
    }

    /* Loading State */
    .btn.loading {
      pointer-events: none;
      opacity: 0.8;
    }

    .btn.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      border: 2px solid transparent;
      border-top: 2px solid currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    @keyframes spin {
      to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Error Message */
    .error-message {
      background: rgba(239, 68, 68, 0.1);
      color: var(--error);
      padding: var(--spacing-md);
      border-radius: var(--radius);
      border-left: 4px solid var(--error);
      margin-bottom: var(--spacing-lg);
      font-size: 0.9rem;
      animation: slideUp 0.3s ease-out;
    }

    /* Helper Links */
    .form-footer {
      text-align: center;
      margin-top: var(--spacing-xl);
      padding-top: var(--spacing-lg);
      border-top: 1px solid var(--border);
    }

    .helper-links {
      display: flex;
      justify-content: center;
      gap: var(--spacing-lg);
      flex-wrap: wrap;
    }

    .helper-link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      position: relative;
    }

    .helper-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 50%;
      background: var(--primary);
      transition: all 0.3s ease;
    }

    .helper-link:hover {
      color: var(--primary-dark);
      transform: translateY(-1px);
    }

    .helper-link:hover::after {
      width: 100%;
      left: 0;
    }

    /* Footer */
    footer {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-top: 1px solid var(--border);
      padding: var(--spacing-lg) 0;
      margin-top: auto;
    }

    .footer-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: var(--spacing-md);
      color: var(--text-secondary);
      font-size: 0.9rem;
    }

    .footer-links {
      display: flex;
      gap: var(--spacing-lg);
      align-items: center;
    }

    .footer-links a {
      color: var(--text-secondary);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .footer-links a:hover {
      color: var(--primary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .container {
        padding: 0 var(--spacing-md);
      }
      
      nav ul {
        gap: var(--spacing-md);
      }
      
      .card-header, .card-body {
        padding: var(--spacing-lg);
      }
      
      .card-title {
        font-size: 1.5rem;
      }
      
      .helper-links {
        flex-direction: column;
        gap: var(--spacing-md);
      }
      
      .footer-content {
        flex-direction: column;
        text-align: center;
      }
    }

    @media (max-width: 480px) {
      main {
        padding: var(--spacing-md);
      }
      
      .card-header, .card-body {
        padding: var(--spacing-md);
      }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    /* Focus styles for accessibility */
    .form-input:focus-visible,
    .btn:focus-visible,
    .helper-link:focus-visible {
      outline: 2px solid var(--primary);
      outline-offset: 2px;
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
      <div class="brand">
        <i class="fas fa-shoe-prints"></i>
        ShoeCommerce
      </div>
      <nav aria-label="Primary navigation">
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('shop.index') }}">Shop</a></li>
          <li><a href="#" aria-current="page">Login</a></li>
          <li><a href="{{ route('customer.register') }}">Sign Up</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="login-container">
      <form id="loginForm" class="card" method="POST" action="{{ route('customer.login.submit') }}">
        @csrf
        
        <div class="card-header">
          <h1 class="card-title">Welcome Back</h1>
          <p class="card-subtitle">Sign in to your account to continue</p>
        </div>

        <div class="card-body">
          @if (session('error'))
            <div class="error-message">
              <i class="fas fa-exclamation-circle"></i>
              {{ session('error') }}
            </div>
          @endif

          <div class="form-group floating-label">
            <input 
              id="email" 
              name="email" 
              type="email" 
              class="form-input" 
              placeholder=" "
              required 
              autocomplete="email"
              value="{{ old('email') }}"
            />
            <label for="email" class="form-label">
              <i class="fas fa-envelope"></i>
              Email Address
            </label>
          </div>

          <div class="form-group floating-label">
            <input 
              id="password" 
              name="password" 
              type="password" 
              class="form-input" 
              placeholder=" "
              required 
              autocomplete="current-password"
            />
            <label for="password" class="form-label">
              <i class="fas fa-lock"></i>
              Password
            </label>
          </div>

          <div class="checkbox-group">
            <input 
              id="remember" 
              type="checkbox" 
              name="remember" 
              class="checkbox-input"
              {{ old('remember') ? 'checked' : '' }}
            />
            <label for="remember" class="checkbox-label">
              Remember me for 30 days
            </label>
          </div>

          <button type="submit" class="btn btn-primary" id="loginBtn">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
          </button>

          <div class="form-footer">
            <div class="helper-links">
              <a href="{{ route('customer.password.request') }}" class="helper-link">
                <i class="fas fa-key"></i>
                Forgot Password?
              </a>
              <a href="{{ route('customer.register') }}" class="helper-link">
                <i class="fas fa-user-plus"></i>
                Create Account
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <div class="container">
      <div class="footer-content">
        <div>© 2025 ShoeCommerce. All rights reserved.</div>
        <div class="footer-links">
          <a href="#">Privacy Policy</a>
          <span>•</span>
          <a href="#">Terms of Service</a>
          <span>•</span>
          <a href="#">Contact</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Enhanced form interactions
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('loginForm');
      const loginBtn = document.getElementById('loginBtn');
      const inputs = document.querySelectorAll('.form-input');

      // Add loading state to button on form submit
      form.addEventListener('submit', function() {
        loginBtn.classList.add('loading');
        loginBtn.innerHTML = '<span>Signing In...</span>';
      });

      // Enhanced input interactions
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentElement.style.transform = 'scale(1.02)';
        });

        input.addEventListener('blur', function() {
          this.parentElement.style.transform = 'scale(1)';
        });

        // Add validation feedback
        input.addEventListener('input', function() {
          if (this.validity.valid) {
            this.style.borderColor = 'var(--success)';
