/* email-otp-frontend.js - Email OTP Verification Frontend */

// Get form elements
const form = document.getElementById('registerForm');
const fullNameInput = document.getElementById('fullName');
const emailInput = document.getElementById('email');
const otpInput = document.getElementById('otpCode');
const phoneInput = document.getElementById('phone');
const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirm');
const sendOtpBtn = document.getElementById('sendOtpBtn');
const registerBtn = document.getElementById('registerBtn');
const emailVerifiedBadge = document.getElementById('emailVerifiedBadge');

// Get message elements
const nameMsg = document.getElementById('nameMsg');
const emailMsg = document.getElementById('emailMsg');
const otpMsg = document.getElementById('otpMsg');
const phoneMsg = document.getElementById('phoneMsg');
const passwordMsg = document.getElementById('passwordMsg');
const confirmMsg = document.getElementById('confirmMsg');

// State variables
let otpSent = false;
let otpVerified = false;
let countdownTimer = null;
let secondsLeft = 0;

// Helper function to set messages
function setMsg(element, message, type = 'error') {
  if (!element) return;
  element.textContent = message || '';
  element.className = 'message';
  
  if (message) {
    if (type === 'error') element.classList.add('error-msg');
    else if (type === 'success') element.classList.add('success-msg');
    else if (type === 'info') element.classList.add('info-msg');
  }
}

// Validation functions
function isValidEmail(email) {
  const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return regex.test(email);
}

function isValidPhone(phone) {
  // Must start with 6-9 and be exactly 10 digits
  const regex = /^[6-9]\d{9}$/;
  return regex.test(phone);
}

function isValidName(name) {
  // Only letters and spaces, no special characters
  const regex = /^[a-zA-Z\s]+$/;
  return regex.test(name.trim()) && name.trim().length >= 2;
}

// Real-time validation
fullNameInput.addEventListener('input', function() {
  const name = this.value.trim();
  if (name && !isValidName(name)) {
    setMsg(nameMsg, 'Name can only contain letters and spaces', 'error');
    this.classList.add('error');
    this.classList.remove('success');
  } else if (name) {
    setMsg(nameMsg, '');
    this.classList.remove('error');
    this.classList.add('success');
  } else {
    setMsg(nameMsg, '');
    this.classList.remove('error', 'success');
  }
});

emailInput.addEventListener('input', function() {
  const email = this.value.trim();
  if (email && !isValidEmail(email)) {
    setMsg(emailMsg, 'Please enter a valid email (e.g., user@example.com)', 'error');
    this.classList.add('error');
    this.classList.remove('success');
  } else if (email) {
    setMsg(emailMsg, '');
    this.classList.remove('error');
    this.classList.add('success');
  } else {
    setMsg(emailMsg, '');
    this.classList.remove('error', 'success');
  }
  
  // Reset OTP state if email changes
  if (otpSent || otpVerified) {
    otpSent = false;
    otpVerified = false;
    emailVerifiedBadge.style.display = 'none';
    sendOtpBtn.textContent = 'Send OTP';
    sendOtpBtn.disabled = false;
    setMsg(otpMsg, '');
  }
});

phoneInput.addEventListener('input', function() {
  // Only allow numbers
  this.value = this.value.replace(/\D/g, '');
  
  const phone = this.value.trim();
  if (phone && !isValidPhone(phone)) {
    if (phone.length !== 10) {
      setMsg(phoneMsg, 'Phone must be exactly 10 digits', 'error');
    } else if (!/^[6-9]/.test(phone)) {
      setMsg(phoneMsg, 'Phone must start with 6, 7, 8, or 9', 'error');
    }
    this.classList.add('error');
    this.classList.remove('success');
  } else if (phone.length === 10) {
    setMsg(phoneMsg, '');
    this.classList.remove('error');
    this.classList.add('success');
  } else {
    setMsg(phoneMsg, '');
    this.classList.remove('error', 'success');
  }
});

otpInput.addEventListener('input', function() {
  // Only allow numbers
  this.value = this.value.replace(/\D/g, '');
  
  // Auto-verify when 6 digits entered
  if (this.value.length === 6 && otpSent && !otpVerified) {
    verifyOTP();
  }
});

passwordInput.addEventListener('input', function() {
  const password = this.value;
  if (password && password.length < 6) {
    setMsg(passwordMsg, 'Password must be at least 6 characters', 'error');
    this.classList.add('error');
    this.classList.remove('success');
  } else if (password) {
    setMsg(passwordMsg, '');
    this.classList.remove('error');
    this.classList.add('success');
  } else {
    setMsg(passwordMsg, '');
    this.classList.remove('error', 'success');
  }
  
  // Check confirm password match
  if (confirmInput.value) {
    checkPasswordMatch();
  }
});

confirmInput.addEventListener('input', checkPasswordMatch);

function checkPasswordMatch() {
  const password = passwordInput.value;
  const confirm = confirmInput.value;
  
  if (confirm && password !== confirm) {
    setMsg(confirmMsg, 'Passwords do not match', 'error');
    confirmInput.classList.add('error');
    confirmInput.classList.remove('success');
  } else if (confirm) {
    setMsg(confirmMsg, '');
    confirmInput.classList.remove('error');
    confirmInput.classList.add('success');
  } else {
    setMsg(confirmMsg, '');
    confirmInput.classList.remove('error', 'success');
  }
}

// Send OTP function
async function sendOTP() {
  const email = emailInput.value.trim();
  
  // Validate email
  if (!email) {
    setMsg(emailMsg, 'Please enter your email address', 'error');
    emailInput.focus();
    return;
  }
  
  if (!isValidEmail(email)) {
    setMsg(emailMsg, 'Please enter a valid email (e.g., user@example.com)', 'error');
    emailInput.focus();
    return;
  }
  
  // Disable button and show loading
  sendOtpBtn.disabled = true;
  sendOtpBtn.textContent = 'Sending...';
  setMsg(emailMsg, '');
  setMsg(otpMsg, '');
  
  try {
    const response = await fetch('send_email_otp.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email })
    });
    
    const data = await response.json();
    
    if (!data.success) {
      throw new Error(data.message || 'Failed to send OTP');
    }
    
    // Success
    otpSent = true;
    otpVerified = false;
    startCountdown(60);
    
    // Show success message with debug OTP (remove in production)
    let message = 'OTP sent to your email! Check your inbox.';
    if (data.debug_otp) {
      message += ` (Debug: ${data.debug_otp})`;
    }
    setMsg(otpMsg, message, 'success');
    
    // Focus OTP input
    otpInput.focus();
    
  } catch (error) {
    setMsg(otpMsg, error.message || 'Failed to send OTP', 'error');
    sendOtpBtn.disabled = false;
    sendOtpBtn.textContent = 'Send OTP';
  }
}

// Countdown timer for resend
function startCountdown(seconds) {
  secondsLeft = seconds;
  updateCountdownButton();
  
  clearInterval(countdownTimer);
  countdownTimer = setInterval(() => {
    secondsLeft--;
    updateCountdownButton();
    
    if (secondsLeft <= 0) {
      clearInterval(countdownTimer);
      sendOtpBtn.disabled = false;
      sendOtpBtn.textContent = 'Resend OTP';
      sendOtpBtn.classList.remove('otp-sent');
    }
  }, 1000);
}

function updateCountdownButton() {
  if (secondsLeft > 0) {
    sendOtpBtn.textContent = `Resend in ${secondsLeft}s`;
    sendOtpBtn.disabled = true;
    sendOtpBtn.classList.add('otp-sent');
  }
}

// Verify OTP function
async function verifyOTP() {
  const email = emailInput.value.trim();
  const code = otpInput.value.trim();
  
  if (!otpSent) {
    setMsg(otpMsg, 'Please send OTP first', 'error');
    return false;
  }
  
  if (!code || code.length !== 6) {
    setMsg(otpMsg, 'Please enter the 6-digit OTP', 'error');
    return false;
  }
  
  // Disable OTP input during verification
  otpInput.disabled = true;
  setMsg(otpMsg, 'Verifying...', 'info');
  
  try {
    const response = await fetch('verify_email_otp.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email, code: code })
    });
    
    const data = await response.json();
    
    if (!data.success) {
      throw new Error(data.message || 'Invalid OTP');
    }
    
    // Success
    otpVerified = true;
    setMsg(otpMsg, '✓ Email verified successfully!', 'success');
    emailVerifiedBadge.style.display = 'inline-block';
    otpInput.classList.add('success');
    otpInput.classList.remove('error');
    
    // Stop countdown
    clearInterval(countdownTimer);
    sendOtpBtn.textContent = '✓ Verified';
    sendOtpBtn.disabled = true;
    sendOtpBtn.classList.remove('otp-sent');
    
    return true;
    
  } catch (error) {
    setMsg(otpMsg, error.message || 'Verification failed', 'error');
    otpInput.classList.add('error');
    otpInput.classList.remove('success');
    otpInput.disabled = false;
    otpInput.focus();
    return false;
  }
}

// Event listeners
sendOtpBtn.addEventListener('click', sendOTP);

// Form submission
form.addEventListener('submit', async function(e) {
  e.preventDefault();
  
  // Validate all fields
  const name = fullNameInput.value.trim();
  const email = emailInput.value.trim();
  const phone = phoneInput.value.trim();
  const password = passwordInput.value;
  const confirm = confirmInput.value;
  
  let hasError = false;
  
  // Validate name
  if (!isValidName(name)) {
    setMsg(nameMsg, 'Name can only contain letters and spaces', 'error');
    hasError = true;
  }
  
  // Validate email
  if (!isValidEmail(email)) {
    setMsg(emailMsg, 'Please enter a valid email', 'error');
    hasError = true;
  }
  
  // Check OTP verification
  if (!otpVerified) {
    if (!otpSent) {
      setMsg(otpMsg, 'Please send and verify OTP first', 'error');
      hasError = true;
    } else {
      setMsg(otpMsg, 'Please verify the OTP sent to your email', 'error');
      hasError = true;
    }
  }
  
  // Validate phone
  if (!isValidPhone(phone)) {
    setMsg(phoneMsg, 'Phone must be 10 digits starting with 6-9', 'error');
    hasError = true;
  }
  
  // Validate password
  if (password.length < 6) {
    setMsg(passwordMsg, 'Password must be at least 6 characters', 'error');
    hasError = true;
  }
  
  // Validate password match
  if (password !== confirm) {
    setMsg(confirmMsg, 'Passwords do not match', 'error');
    hasError = true;
  }
  
  if (hasError) {
    return false;
  }
  
  // All validations passed - submit form
  registerBtn.disabled = true;
  registerBtn.textContent = 'Creating Account...';
  
  // Submit the form
  this.submit();
});
