const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const PORT = 3000;

// In-memory store for demo purpose
const otpStore = {};

/**
 * Helper: Generate 6-digit OTP
 */
function generateOTP() {
  return Math.floor(100000 + Math.random() * 900000).toString();
}

/**
 * POST /send-otp
 * Expects JSON: {phone: '9876543210'}
 */
app.post('/send-otp', (req, res) => {
  const { phone } = req.body;

  if (!phone || !phone.match(/^[6-9][0-9]{9}$/)) {
    return res.json({success: false, message: 'Invalid phone number'});
  }

  const otp = generateOTP();
  otpStore[phone] = otp;

  // For demo, we just log OTP to console
  console.log(`Sending OTP ${otp} to phone ${phone}`);

  // In production, integrate an SMS API here to send the OTP to user

  res.json({ success: true });
});

/**
 * POST /verify-otp
 * Expects JSON: {phone: '9876543210', otp: '123456'}
 */
app.post('/verify-otp', (req, res) => {
  const { phone, otp } = req.body;

  if (!phone || !otp) {
    return res.json({ success: false, message: 'Missing phone or otp' });
  }

  if (otpStore[phone] && otpStore[phone] === otp) {
    delete otpStore[phone]; // OTP can be used only once
    return res.json({ success: true });
  } else {
    return res.json({ success: false, message: 'Invalid OTP' });
  }
});

// Serve frontend (optional)
// Place your index.html in same folder and uncomment this block to serve it
/*
const path = require('path');
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});
*/

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});