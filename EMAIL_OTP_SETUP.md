# Email OTP Verification System - Setup Guide

## Overview
This system replaces the dummy phone OTP with a proper **Email OTP verification** for user registration.

---

## 🗄️ Database Setup

### Step 1: Create the `email_otps` Table

Run the SQL migration file to create the required table:

```bash
# Open MySQL/phpMyAdmin and run:
```

```sql
-- Or execute the file directly:
mysql -u root shoecommerce < create_email_otps_table.sql
```

The table structure:
- `id` - Auto increment primary key
- `email` - User's email address
- `otp` - 6-digit OTP code
- `created_at` - When OTP was generated
- `expires_at` - OTP expiration time (5 minutes)
- `is_verified` - Verification status (0 or 1)

---

## 📁 Files Created/Updated

### New Files:
1. **`create_email_otps_table.sql`** - Database migration
2. **`send_email_otp.php`** - Generates and sends OTP via email
3. **`verify_email_otp.php`** - Verifies the OTP entered by user
4. **`email-otp-frontend.js`** - Frontend JavaScript for OTP functionality

### Updated Files:
1. **`register.html`** - Updated with Email OTP fields
2. **`register.php`** - Updated to verify email OTP before registration

---

## 🚀 How It Works

### User Flow:
1. User enters **Email** → clicks **"Send OTP"**
2. System generates 6-digit OTP → saves to database with 5-min expiry
3. OTP is sent to user's email
4. User enters OTP → system verifies it
5. Once verified → user completes registration with other details
6. System checks OTP verification before creating account

---

## ✅ Validation Rules

### Full Name:
- Only letters and spaces allowed
- Minimum 2 characters
- No special characters or numbers

### Email:
- Must be valid format (e.g., user@example.com)
- Must be verified via OTP

### Phone Number:
- Exactly 10 digits
- Must start with 6, 7, 8, or 9
- Only numeric characters

### Password:
- Minimum 6 characters
- Must match confirmation

---

## 📧 Email Configuration

### Using PHP `mail()` Function:

The system currently uses PHP's built-in `mail()` function. To make this work:

#### On Windows (XAMPP):

1. Open `php.ini` (in `C:\xampp\php\php.ini`)
2. Find and update these lines:

```ini
[mail function]
SMTP = smtp.gmail.com
smtp_port = 587
sendmail_from = your-email@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
```

3. Open `sendmail.ini` (in `C:\xampp\sendmail\sendmail.ini`)
4. Update these lines:

```ini
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=your-email@gmail.com
auth_password=your-app-password
force_sender=your-email@gmail.com
```

5. **Important:** Use Gmail App Password (not regular password)
   - Go to Google Account → Security → 2-Step Verification → App Passwords
   - Generate new app password for "Mail"

6. Restart Apache in XAMPP

#### Testing Email Locally:

For development, the system includes a **debug mode** that shows the OTP in the response:

```json
{
  "success": true,
  "message": "OTP sent successfully",
  "debug_otp": "123456"  // Only for testing!
}
```

**⚠️ IMPORTANT:** Remove `debug_otp` from production code in `send_email_otp.php`

---

## 🔧 Testing the System

### Step 1: Setup Database
```sql
CREATE TABLE IF NOT EXISTS email_otps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    otp VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    INDEX idx_email (email),
    INDEX idx_expires (expires_at)
);
```

### Step 2: Update Users Table (if needed)
Make sure your `users` table has these columns:
```sql
ALTER TABLE users ADD COLUMN email VARCHAR(255) UNIQUE AFTER name;
ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;
```

### Step 3: Test Registration Flow

1. Open `register.html` in browser
2. Enter full name (only letters/spaces)
3. Enter email → click "Send OTP"
4. Check email OR see debug OTP in browser console
5. Enter the 6-digit OTP
6. System auto-verifies when you type 6 digits
7. Enter phone (10 digits, starts with 6-9)
8. Enter password and confirm
9. Click Register

---

## 🐛 Troubleshooting

### Issue: OTP not sending to email
**Solution:** 
- Check email configuration in `php.ini` and `sendmail.ini`
- Use debug_otp in response for testing
- Check Apache error logs

### Issue: "Email not verified" error
**Solution:**
- Make sure you clicked "Send OTP" and verified it
- Check if OTP expired (5 minutes)
- Clear old OTP records from database

### Issue: Phone validation failing
**Solution:**
- Phone must be exactly 10 digits
- Must start with 6, 7, 8, or 9
- No spaces, dashes, or other characters

### Issue: Name validation failing
**Solution:**
- Remove any numbers or special characters
- Only letters (A-Z, a-z) and spaces allowed

---

## 🔒 Security Notes

1. **OTP Expiry:** OTPs expire in 5 minutes
2. **One-time Use:** OTPs are deleted after successful registration
3. **Rate Limiting:** Consider adding rate limiting to prevent OTP spam
4. **HTTPS:** Use HTTPS in production to encrypt data transmission
5. **Password Hashing:** Passwords are hashed using bcrypt

---

## 📝 Database Table Reference

```sql
-- Check OTP records
SELECT * FROM email_otps ORDER BY created_at DESC;

-- Clean expired OTPs
DELETE FROM email_otps WHERE expires_at < NOW();

-- Check verified OTPs
SELECT * FROM email_otps WHERE is_verified = 1;
```

---

## 🎯 Next Steps

1. ✅ Run the database migration
2. ✅ Configure email settings (or use debug mode for testing)
3. ✅ Test the complete registration flow
4. ✅ Remove `debug_otp` from production code
5. ✅ Add rate limiting for OTP requests (optional)
6. ✅ Set up proper email service (SendGrid, AWS SES, etc.) for production

---

## 📞 Support

If you encounter any issues:
1. Check browser console for JavaScript errors
2. Check Apache error logs for PHP errors
3. Verify database connection and table structure
4. Test with debug_otp enabled first

---

**System Ready! 🚀**
