<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Create Account - ShoeCommerce</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --primary-light: #818cf8;
      --success: #10b981;
      --error: #ef4444;
      --warning: #f59e0b;
      --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --glass-bg: rgba(255, 255, 255, 0.95);
      --glass-border: rgba(255, 255, 255, 0.18);
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.16);
      --text-dark: #1e293b;
      --text-muted: #64748b;
      --border: #e2e8f0;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg-gradient);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow-x: hidden;
    }

    /* Animated Background */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(236, 72, 153, 0.2) 0%, transparent 50%);
      animation: gradient 15s ease infinite;
      z-index: -1;
    }

    @keyframes gradient {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }

    /* Container */
    .register-wrapper {
      width: 100%;
      max-width: 480px;
      animation: fadeInUp 0.8s ease-out;
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

    /* Card */
    .register-card {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--glass-border);
      overflow: hidden;
      position: relative;
    }

    .register-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: var(--bg-gradient);
    }

    /* Header */
    .card-header {
      padding: 40px 32px 32px;
      text-align: center;
      background: linear-gradient(180deg, rgba(99, 102, 241, 0.05) 0%, transparent 100%);
    }

    .logo {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 16px;
    }

    .logo-icon {
      width: 48px;
      height: 48px;
      background: var(--bg-gradient);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: white;
      box-shadow: var(--shadow-md);
    }

    .logo-text {
      font-size: 28px;
      font-weight: 800;
      background: var(--bg-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .card-title {
      font-size: 24px;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 8px;
    }

    .card-subtitle {
      font-size: 14px;
      color: var(--text-muted);
    }

    /* Form */
    .card-body {
      padding: 0 32px 40px;
    }

    .form-group {
      margin-bottom: 24px;
      position: relative;
    }

    .form-label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .form-label i {
      color: var(--primary);
      font-size: 16px;
    }

    .verified-badge {
      margin-left: auto;
      color: var(--success);
      font-size: 13px;
      font-weight: 600;
      display: none;
      align-items: center;
      gap: 4px;
    }

    .verified-badge.show {
      display: flex;
    }

    .form-input {
      width: 100%;
      padding: 14px 16px;
      font-size: 15px;
      font-family: 'Poppins', sans-serif;
      color: var(--text-dark);
      background: white;
      border: 2px solid var(--border);
      border-radius: 12px;
      transition: all 0.3s ease;
      outline: none;
    }

    .form-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
      transform: translateY(-2px);
    }

    .form-input.valid {
      border-color: var(--success);
      background: rgba(16, 185, 129, 0.02);
    }

    .form-input.invalid {
      border-color: var(--error);
      background: rgba(239, 68, 68, 0.02);
    }

    .form-input::placeholder {
      color: #cbd5e1;
    }

    /* OTP Group */
    .otp-group {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 8px;
    }

    .otp-btn {
      padding: 14px 24px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
      color: white;
      background: var(--bg-gradient);
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      box-shadow: var(--shadow-sm);
    }

    .otp-btn:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .otp-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .otp-btn.verified {
      background: var(--success);
    }

    /* Password Toggle */
    .password-wrapper {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--text-muted);
      cursor: pointer;
      padding: 4px;
      border-radius: 6px;
      transition: all 0.2s;
    }

    .password-toggle:hover {
      color: var(--primary);
      background: rgba(99, 102, 241, 0.1);
    }

    /* Messages */
    .message {
      font-size: 13px;
      margin-top: 8px;
      display: none;
      align-items: center;
      gap: 6px;
      padding: 8px 12px;
      border-radius: 8px;
      font-weight: 500;
    }

    .message.show {
      display: flex;
    }

    .message.error {
      color: #dc2626;
      background: rgba(239, 68, 68, 0.08);
    }

    .message.success {
      color: #059669;
      background: rgba(16, 185, 129, 0.08);
    }

    .message.info {
      color: #0284c7;
      background: rgba(14, 165, 233, 0.08);
    }

    .message.warning {
      color: #d97706;
      background: rgba(245, 158, 11, 0.08);
    }

    /* Helper Text */
    .helper-text {
      font-size: 12px;
      color: var(--text-muted);
      margin-top: 6px;
    }

    /* Submit Button */
    .submit-btn {
      width: 100%;
      padding: 16px;
      font-size: 16px;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      color: white;
      background: var(--bg-gradient);
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: var(--shadow-md);
      margin-top: 8px;
      position: relative;
      overflow: hidden;
    }

    .submit-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    .submit-btn:hover:not(:disabled)::before {
      left: 100%;
    }

    .submit-btn:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 12px 32px rgba(99, 102, 241, 0.4);
    }

    .submit-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .submit-btn.loading {
      pointer-events: none;
    }

    .submit-btn.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Footer */
    .card-footer {
      text-align: center;
      padding: 24px 32px 32px;
      border-top: 1px solid var(--border);
    }

    .footer-link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.2s;
    }

    .footer-link:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }

    /* Alert */
    .alert {
      padding: 14px 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .alert.error {
      background: rgba(239, 68, 68, 0.1);
      color: #dc2626;
      border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Responsive */
    @media (max-width: 576px) {
      body {
        padding: 10px;
      }

      .card-header {
        padding: 32px 24px 24px;
      }

      .card-body {
        padding: 0 24px 32px;
      }

      .logo-text {
        font-size: 24px;
      }

      .card-title {
        font-size: 20px;
      }

      .otp-group {
        grid-template-columns: 1fr;
      }

      .otp-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="register-wrapper">
    <form id="registerForm" class="register-card" method="POST" action="{{ route('customer.register') }}" novalidate>
      @csrf
      
      <div class="card-header">
        <div class="logo">
          <div class="logo-icon">
            <i class="fas fa-shoe-prints"></i>
          </div>
          <div class="logo-text">ShoeCommerce</div>
        </div>
        <h1 class="card-title">Create Your Account</h1>
        <p class="card-subtitle">Join thousands of happy customers</p>
      </div>

      <div class="card-body">
        @if (session('error'))
          <div class="alert error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
          </div>
        @endif

        <!-- Full Name -->
        <div class="form-group">
          <label for="fullName" class="form-label">
            <i class="fas fa-user"></i>
            Full Name
          </label>
          <input 
            id="fullName" 
            name="name" 
            type="text" 
            class="form-input" 
            placeholder="Enter your full name"
            required 
            autocomplete="name"
            value="{{ old('name') }}"
          />
          <div id="nameErr" class="message error"></div>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label for="email" class="form-label">
            <i class="fas fa-envelope"></i>
            Email Address
            <span id="emailVerifiedBadge" class="verified-badge">
              <i class="fas fa-check-circle"></i>
              Verified
            </span>
          </label>
          <div class="otp-group">
            <input 
              id="email" 
              name="email" 
              type="email" 
              class="form-input" 
              placeholder="you@example.com"
              required 
              autocomplete="email"
              value="{{ old('email') }}"
            />
            <button type="button" id="sendOtpBtn" class="otp-btn">
              <i class="fas fa-paper-plane"></i>
              Send OTP
            </button>
          </div>
          <div id="emailErr" class="message error"></div>
        </div>

        <!-- Email OTP -->
        <div class="form-group">
          <label for="otp" class="form-label">
            <i class="fas fa-shield-alt"></i>
            Email Verification Code
          </label>
          <input 
            id="otp" 
            name="otp" 
            type="text" 
            class="form-input" 
            placeholder="Enter 6-digit OTP"
            inputmode="numeric" 
            maxlength="6"
          />
          <div id="otpStatus" class="message info"></div>
        </div>

        <!-- Phone -->
        <div class="form-group">
          <label for="phone" class="form-label">
            <i class="fas fa-phone"></i>
            Phone Number
          </label>
          <input 
            id="phone" 
            name="phone" 
            type="tel" 
            class="form-input" 
            placeholder="Enter 10-digit mobile number"
            inputmode="numeric"
            pattern="[0-9]{10}"
            maxlength="10"
            required
            value="{{ old('phone') }}"
          />
          <div class="helper-text">Must start with 6, 7, 8, or 9</div>
          <div id="phoneErr" class="message error"></div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password" class="form-label">
            <i class="fas fa-lock"></i>
            Password
          </label>
          <div class="password-wrapper">
            <input 
              id="password" 
              name="password" 
              type="password" 
              class="form-input" 
              placeholder="Minimum 6 characters"
              minlength="6"
              required
            />
            <button type="button" class="password-toggle" data-toggle="#password">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div id="passErr" class="message error"></div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
          <label for="confirm" class="form-label">
            <i class="fas fa-lock"></i>
            Confirm Password
          </label>
          <div class="password-wrapper">
            <input 
              id="confirm" 
              name="password_confirmation" 
              type="password" 
              class="form-input" 
              placeholder="Re-enter your password"
              required
            />
            <button type="button" class="password-toggle" data-toggle="#confirm">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div id="confirmErr" class="message error"></div>
        </div>

        <button type="submit" id="createBtn" class="submit-btn" disabled>
          <i class="fas fa-user-plus"></i>
          Create Account
        </button>
      </div>

      <div class="card-footer">
        <span style="color: var(--text-muted); font-size: 14px;">Already have an account?</span>
        <a href="{{ route('customer.login') }}" class="footer-link">Sign In</a>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Helpers
      const $ = sel => document.querySelector(sel);
      const show = (el, flag = true) => { 
        if (flag) el.classList.add('show');
        else el.classList.remove('show');
      };

      // State
      let otpVerified = false;
      let resendTimer = null;
      let resendLeft = 0;

      // Elements
      const form = $('#registerForm');
      const createBtn = $('#createBtn');
      const nameEl = $('#fullName');
      const emailEl = $('#email');
      const phoneEl = $('#phone');
      const otpEl = $('#otp');
      const pwdEl = $('#password');
      const confirmEl = $('#confirm');
      const nameErr = $('#nameErr');
      const emailErr = $('#emailErr');
      const phoneErr = $('#phoneErr');
      const passErr = $('#passErr');
      const confirmErr = $('#confirmErr');
      const otpStatus = $('#otpStatus');
      const sendOtpBtn = $('#sendOtpBtn');
      const emailVerifiedBadge = $('#emailVerifiedBadge');

      // Validation rules
      const emailRE = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      const phoneRE = /^[6-9][0-9]{9}$/;
      const nameRE = /^[a-zA-Z\s]+$/;

      // Validation functions
      function validateName() {
        const val = nameEl.value.trim();
        const ok = (val.length >= 2 && nameRE.test(val));
        
        if (val) {
          if (ok) {
            nameEl.classList.add('valid');
            nameEl.classList.remove('invalid');
            nameErr.textContent = '';
            show(nameErr, false);
          } else {
            nameEl.classList.add('invalid');
            nameEl.classList.remove('valid');
            nameErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Name can only contain letters and spaces';
            show(nameErr, true);
          }
        } else {
          nameEl.classList.remove('valid', 'invalid');
          show(nameErr, false);
        }
        return ok;
      }

      function validateEmail() {
        const val = emailEl.value.trim();
        const ok = emailRE.test(val);
        
        if (val) {
          if (ok) {
            emailEl.classList.add('valid');
            emailEl.classList.remove('invalid');
            emailErr.textContent = '';
            show(emailErr, false);
          } else {
            emailEl.classList.add('invalid');
            emailEl.classList.remove('valid');
            emailErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please enter a valid email';
            show(emailErr, true);
          }
        } else {
          emailEl.classList.remove('valid', 'invalid');
          show(emailErr, false);
        }
        return ok;
      }

      function validatePhone() {
        const val = phoneEl.value.trim();
        const ok = phoneRE.test(val);
        
        if (val) {
          if (ok) {
            phoneEl.classList.add('valid');
            phoneEl.classList.remove('invalid');
            phoneErr.textContent = '';
            show(phoneErr, false);
          } else if (val.length === 10) {
            phoneEl.classList.add('invalid');
            phoneEl.classList.remove('valid');
            phoneErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Phone must start with 6, 7, 8, or 9';
            show(phoneErr, true);
          } else {
            phoneEl.classList.add('invalid');
            phoneEl.classList.remove('valid');
            phoneErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Enter a valid 10-digit number';
            show(phoneErr, true);
          }
        } else {
          phoneEl.classList.remove('valid', 'invalid');
          show(phoneErr, false);
        }
        return ok;
      }

      function validatePassword() {
        const ok = (pwdEl.value.length >= 6);
        
        if (pwdEl.value) {
          if (ok) {
            pwdEl.classList.add('valid');
            pwdEl.classList.remove('invalid');
            passErr.textContent = '';
            show(passErr, false);
          } else {
            pwdEl.classList.add('invalid');
            pwdEl.classList.remove('valid');
            passErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Password must be at least 6 characters';
            show(passErr, true);
          }
        } else {
          pwdEl.classList.remove('valid', 'invalid');
          show(passErr, false);
        }
        return ok;
      }

      function validateConfirm() {
        const ok = (pwdEl.value === confirmEl.value && confirmEl.value.length > 0);
        
        if (confirmEl.value) {
          if (ok) {
            confirmEl.classList.add('valid');
            confirmEl.classList.remove('invalid');
            confirmErr.textContent = '';
            show(confirmErr, false);
          } else {
            confirmEl.classList.add('invalid');
            confirmEl.classList.remove('valid');
            confirmErr.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Passwords do not match';
            show(confirmErr, true);
          }
        } else {
          confirmEl.classList.remove('valid', 'invalid');
          show(confirmErr, false);
        }
        return ok;
      }

      function gateSubmit() {
        const allOk = validateName() && validateEmail() && validatePhone() && validatePassword() && validateConfirm() && otpVerified;
        createBtn.disabled = !allOk;
        return allOk;
      }

      // Send Email OTP
      async function sendOTP() {
        if (!validateEmail()) {
          otpStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> Please enter a valid email address';
          otpStatus.className = 'message error show';
          return;
        }
        
        const email = emailEl.value.trim();
        sendOtpBtn.disabled = true;
        sendOtpBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        try {
          const response = await fetch('{{ url("/api/email-otp/send") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
          });
          
          const contentType = response.headers.get('content-type');
          if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned non-JSON response');
          }
          
          const data = await response.json();
          
          if (!data.success || !response.ok) {
            // Show error message from server
            otpStatus.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message || 'Failed to send OTP'}`;
            otpStatus.className = 'message error show';
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send OTP';
            emailEl.classList.add('invalid');
            emailEl.classList.remove('valid');
            return;
          }
          
          otpVerified = false;
          otpEl.value = "";
          gateSubmit();
          
          startResend(60);
          
          otpStatus.innerHTML = '<i class="fas fa-check-circle"></i> OTP sent! Check your email inbox.';
          otpStatus.className = 'message success show';
          otpEl.focus();
          
        } catch (error) {
          otpStatus.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${error.message || 'Failed to send OTP'}`;
          otpStatus.className = 'message error show';
          sendOtpBtn.disabled = false;
          sendOtpBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send OTP';
        }
      }

      function startResend(seconds) {
        resendLeft = seconds;
        tick();
        clearInterval(resendTimer);
        resendTimer = setInterval(tick, 1000);
        
        function tick() {
          resendLeft--;
          if (resendLeft > 0) {
            sendOtpBtn.innerHTML = `<i class="fas fa-clock"></i> ${resendLeft}s`;
            sendOtpBtn.disabled = true;
          } else {
            clearInterval(resendTimer);
            resendTimer = null;
            sendOtpBtn.disabled = false;
            sendOtpBtn.innerHTML = '<i class="fas fa-redo"></i> Resend';
          }
        }
      }

      // Verify OTP
      async function verifyOTPIfReady() {
        const v = otpEl.value.trim();
        if (v.length < 6) {
          otpVerified = false;
          if (v.length > 0) {
            otpStatus.innerHTML = '<i class="fas fa-info-circle"></i> Enter 6 digits';
            otpStatus.className = 'message warning show';
          }
          gateSubmit();
          return;
        }
        if (!/^\d{6}$/.test(v)) {
          otpVerified = false;
          otpStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> OTP should contain digits only';
          otpStatus.className = 'message error show';
          gateSubmit();
          return;
        }
        
        const email = emailEl.value.trim();
        if (!email) {
          otpVerified = false;
          otpStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> Enter your email first';
          otpStatus.className = 'message error show';
          gateSubmit();
          return;
        }
        
        try {
          otpStatus.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
          otpStatus.className = 'message info show';
          
          const response = await fetch('{{ url("/api/email-otp/verify") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email, code: v })
          });
          
          const data = await response.json();
          
          if (data.success) {
            otpVerified = true;
            otpStatus.innerHTML = '<i class="fas fa-check-circle"></i> Email verified successfully!';
            otpStatus.className = 'message success show';
            otpEl.classList.add('valid');
            otpEl.classList.remove('invalid');
            emailVerifiedBadge.classList.add('show');
            sendOtpBtn.innerHTML = '<i class="fas fa-check"></i> Verified';
            sendOtpBtn.classList.add('verified');
            sendOtpBtn.disabled = true;
          } else {
            otpVerified = false;
            otpStatus.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message || "Invalid OTP"}`;
            otpStatus.className = 'message error show';
            otpEl.classList.add('invalid');
            otpEl.classList.remove('valid');
          }
        } catch (error) {
          otpVerified = false;
          otpStatus.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${error.message || "Verification failed"}`;
          otpStatus.className = 'message error show';
          otpEl.classList.add('invalid');
          otpEl.classList.remove('valid');
        }
        gateSubmit();
      }

      // Password visibility toggles
      document.querySelectorAll('.password-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
          const target = $(btn.dataset.toggle);
          const icon = btn.querySelector('i');
          if (target.type === 'password') {
            target.type = 'text';
            icon.className = 'fas fa-eye-slash';
          } else {
            target.type = 'password';
            icon.className = 'fas fa-eye';
          }
        });
      });

      // Events
      nameEl.addEventListener('input', () => { validateName(); gateSubmit(); });
      emailEl.addEventListener('input', () => { 
        validateEmail(); 
        otpVerified = false;
        emailVerifiedBadge.classList.remove('show');
        show(otpStatus, false);
        gateSubmit(); 
      });
      let phoneCheckTimeout;
      phoneEl.addEventListener('input', async () => { 
        phoneEl.value = phoneEl.value.replace(/\D/g, '');
        const isValid = validatePhone();
        
        // Clear previous timeout
        clearTimeout(phoneCheckTimeout);
        
        // Check if phone is already registered (debounced)
        if (isValid && phoneEl.value.length === 10) {
          phoneCheckTimeout = setTimeout(async () => {
            try {
              const response = await fetch('{{ url("/api/email-otp/check-phone") }}', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ phone: phoneEl.value.trim() })
              });
              
              const data = await response.json();
              
              if (!data.success || !response.ok) {
                phoneEl.classList.add('invalid');
                phoneEl.classList.remove('valid');
                phoneErr.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message || 'This phone number is already registered'}`;
                show(phoneErr, true);
              } else {
                // Phone is available
                phoneEl.classList.add('valid');
                phoneEl.classList.remove('invalid');
                phoneErr.textContent = '';
                show(phoneErr, false);
              }
              gateSubmit();
            } catch (error) {
              console.error('Phone check error:', error);
            }
          }, 500); // Wait 500ms after user stops typing
        }
        
        gateSubmit(); 
      });
      pwdEl.addEventListener('input', () => { validatePassword(); validateConfirm(); gateSubmit(); });
      confirmEl.addEventListener('input', () => { validateConfirm(); gateSubmit(); });
      otpEl.addEventListener('input', () => {
        otpEl.value = otpEl.value.replace(/\D/g, '');
        verifyOTPIfReady();
      });

      sendOtpBtn.addEventListener('click', sendOTP);

      // Form submit
      form.addEventListener('submit', function(e) {
        if (!gateSubmit()) {
          e.preventDefault();
          return;
        }
        createBtn.classList.add('loading');
        createBtn.innerHTML = 'Creating Account...';
      });

      gateSubmit();
    });
  </script>
</body>
</html>
