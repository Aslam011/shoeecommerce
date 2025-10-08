/* otp-frontend.js */
const apiBase = 'http://localhost:4000'; // change if different origin

const phoneInput = document.getElementById('phoneNumber');
const otpInput = document.getElementById('otpCode');
const sendBtn = document.getElementById('sendOtpBtn');
const form = document.getElementById('registerForm');
const phoneMsg = document.getElementById('phoneMsg');
const otpMsg = document.getElementById('otpMsg');

let otpSent = false;
let otpVerified = false;
let countdownTimer = null;
let secondsLeft = 0;

function isValidIndianMobile(v) {
  return /^[6-9]\d{9}$/.test((v || '').replace(/\D/g, ''));
}
function setMsg(el, msg, ok=false) {
  if (!el) return;
  el.textContent = msg || '';
  el.style.color = ok ? '#1a7f37' : '#b42318';
}

async function sendOTP() {
  const raw = phoneInput.value.trim();
  if (!isValidIndianMobile(raw)) {
    setMsg(phoneMsg, 'Enter a valid 10-digit mobile (starts with 6-9).');
    return;
  }
  sendBtn.disabled = true;
  setMsg(phoneMsg, '');
  try {
    const res = await fetch(`${apiBase}/api/otp/send`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ phone: raw })
    });
    const data = await res.json();
    if (!data.success) throw new Error(data.message);
    otpSent = true;
    otpVerified = false;
    startCountdown(60);
    setMsg(otpMsg, 'OTP sent. Please check your SMS.', true);
    otpInput.focus();
  } catch (e) {
    setMsg(otpMsg, e.message || 'Failed to send OTP');
    sendBtn.disabled = false;
  }
}

function startCountdown(sec) {
  secondsLeft = sec;
  renderBtn();
  clearInterval(countdownTimer);
  countdownTimer = setInterval(() => {
    secondsLeft -= 1;
    renderBtn();
    if (secondsLeft <= 0) {
      clearInterval(countdownTimer);
      sendBtn.disabled = false;
      sendBtn.textContent = 'Resend OTP';
    }
  }, 1000);
}
function renderBtn() {
  if (secondsLeft > 0) {
    sendBtn.textContent = `Resend in ${secondsLeft}s`;
    sendBtn.disabled = true;
  }
}

async function verifyOTP() {
  const rawPhone = phoneInput.value.trim();
  const code = otpInput.value.trim().replace(/\D/g, '');
  if (!otpSent) { setMsg(otpMsg, 'Send OTP first.'); return false; }
  if (!/^\d{6}$/.test(code)) { setMsg(otpMsg, 'Enter the 6-digit OTP.'); return false; }

  try {
    const res = await fetch(`${apiBase}/api/otp/verify`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ phone: rawPhone, code })
    });
    const data = await res.json();
    if (!data.success) {
      setMsg(otpMsg, data.message || 'Invalid OTP');
      otpVerified = false;
      return false;
    }
    setMsg(otpMsg, 'Phone verified ✔', true);
    otpVerified = true;
    return true;
  } catch (e) {
    setMsg(otpMsg, e.message || 'Verification error');
    return false;
  }
}

// Wire up events
sendBtn?.addEventListener('click', sendOTP);

// Auto-verify when 6 digits entered
otpInput?.addEventListener('input', async () => {
  if (otpInput.value.replace(/\D/g, '').length === 6) {
    await verifyOTP();
  }
});

// Gate the form submit on OTP verification
form?.addEventListener('submit', async (e) => {
  // Allow the rest of your validations first if you want
  if (!otpVerified) {
    e.preventDefault();
    const ok = await verifyOTP();
    if (ok) form.submit(); // submit after verification passes
  }
});