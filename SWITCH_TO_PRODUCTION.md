# 🚀 Switch Cashfree from SANDBOX to PRODUCTION (Real Payments)

## ⚠️ Current Status: SANDBOX MODE

You're currently in **SANDBOX/TEST mode** where:
- ❌ No real money is transferred
- ❌ Test OTP (111000) is shown
- ❌ Payments are simulated
- ✅ Safe for testing without risk

## ✅ To Enable REAL Payments (PRODUCTION Mode)

### Step 1: Complete Cashfree KYC Verification

Before you can accept real payments, Cashfree requires:

1. **Login to Cashfree Dashboard**: https://merchant.cashfree.com/
2. **Complete KYC** (Know Your Customer):
   - Business details
   - Bank account details
   - PAN card
   - GST details (if applicable)
   - Address proof

3. Wait for Cashfree to approve your KYC (usually 1-2 business days)

### Step 2: Get PRODUCTION Credentials

Once KYC is approved:

1. Login to Cashfree Dashboard
2. **Switch to PRODUCTION mode** (toggle in top-right corner)
3. Go to: **Developers → API Keys**
4. Copy your **PRODUCTION credentials**:
   - App ID (will be different from TEST...)
   - Secret Key (will start with `cfsk_ma_prod_...`)

### Step 3: Update Your .env File

Replace sandbox credentials with production:

```env
# Change from sandbox to production
CASHFREE_APP_ID=your_production_app_id_here
CASHFREE_SECRET_KEY=your_production_secret_key_here
CASHFREE_ENV=production
CASHFREE_API_VERSION=2023-08-01
```

### Step 4: Configure Production Webhook

In Cashfree Dashboard (Production mode):

1. Go to **Developers → Webhooks**
2. Add Webhook URL: `https://yourdomain.com/cashfree/webhook`
3. Enable event: **"Payment Success"** or **"Order Paid"**
4. Save

⚠️ **Important**: Webhook URL must be:
- HTTPS (not HTTP)
- Publicly accessible (not localhost)
- Your live domain

### Step 5: Test Setup

1. Clear cache:
```bash
php artisan config:clear
php artisan cache:clear
```

2. Create a test order with a small amount (₹1 or ₹10)
3. Scan QR code with real UPI app
4. **Enter your real UPI PIN**
5. Payment will be deducted from your account
6. Money goes to your Cashfree merchant account
7. Order will be marked as "Paid" automatically

### Step 6: Link Bank Account for Settlement

To receive money in your bank:

1. Go to Cashfree Dashboard → **Settings → Bank Accounts**
2. Add your bank account details
3. Verify the account (micro-deposit verification)
4. Cashfree will settle funds to this account daily/weekly

## 💰 Payment Flow in PRODUCTION

### Real Payment Flow:

1. **Customer scans QR** → Opens in UPI app (PhonePe, Google Pay, etc.)
2. **Customer enters UPI PIN** → Real money is deducted
3. **Money goes to Cashfree** → Your merchant account balance
4. **Webhook triggers** → Your Laravel app marks order as "Paid"
5. **Settlement** → Cashfree transfers to your bank (T+1 or T+2 days)

### vs SANDBOX Flow (What you're seeing now):

1. Customer scans QR → Redirects to test page
2. Test OTP shown (111000) → No real verification
3. Simulated payment → No money transferred
4. Webhook may or may not trigger → Testing only

## 🔒 Security Notes for Production

### Before Going Live:

✅ Ensure your .env file has production credentials
✅ Never commit .env to git (check .gitignore)
✅ Use HTTPS on your domain
✅ Test with small amounts first (₹1)
✅ Verify webhook signature is enabled
✅ Monitor logs for first few transactions

## 🧪 Testing SANDBOX vs PRODUCTION

| Feature | SANDBOX | PRODUCTION |
|---------|---------|------------|
| Real Money | ❌ No | ✅ Yes |
| UPI PIN Required | ❌ No | ✅ Yes |
| Test OTP | ✅ 111000 | ❌ N/A |
| Funds in Bank | ❌ No | ✅ Yes (T+1/T+2) |
| KYC Required | ❌ No | ✅ Yes |
| Transaction Fees | ❌ Free | ✅ As per pricing |

## 📞 Need Help?

If you face issues switching to production:

1. **Cashfree Support**: support@cashfree.com
2. **Documentation**: https://docs.cashfree.com/
3. **Check KYC Status**: Cashfree Dashboard → Profile

## ⚡ Quick Checklist

Before accepting real payments:

- [ ] KYC completed and approved
- [ ] Production credentials obtained
- [ ] .env updated with production credentials
- [ ] Website has HTTPS (SSL certificate)
- [ ] Webhook URL configured in Cashfree Dashboard
- [ ] Bank account linked and verified
- [ ] Tested with ₹1 transaction
- [ ] Cache cleared
- [ ] Webhook logs verified

## 🎯 Current State

Your integration is **100% ready** for production! 

✅ Code is complete and tested
✅ Webhook handler working
✅ QR code generation working
✅ Payment detection working
✅ Order status updates working

**You just need to switch from SANDBOX to PRODUCTION credentials!**

---

**Once you get production credentials and update .env, real UPI payments will work immediately with actual money transfer!** 💰
