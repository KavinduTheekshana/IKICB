# WebXPay Error 442 - "Invalid Encryption" - SOLUTION

## The Problem

You're getting error **442 - Invalid encryption** from WebXPay, which means **WebXPay cannot decrypt the payment data you're sending**.

## Root Cause Analysis

After reviewing your setup, the issue is most likely **ONE** of these:

### 1. Wrong Public Key Downloaded ⚠️ MOST LIKELY

WebXPay provides **TWO different keys**:
- **WebXPay's Public Key** (for YOU to encrypt data TO WebXPay) ✅ YOU NEED THIS
- **Your Merchant Public Key** (for WebXPay to encrypt responses TO you) ❌ NOT FOR PAYMENT FORM

**Solution:**
1. Login to your WebXPay dashboard (sandbox: https://stagingxpay.info/)
2. Go to: **Settings → API Settings → Integration**
3. Look for: **"WebXPay Public Key for Encryption"** or **"Public Key for Payment Integration"**
4. Download the **CORRECT** public key
5. Replace: `storage/app/webxpay_public.pem`

**Important:** Make sure you're downloading the key labeled for **encrypting payment data**, NOT your merchant key!

---

### 2. Secret Key Doesn't Match Public Key

Your secret key and public key must be from the **SAME merchant account** and **SAME environment** (both sandbox or both production).

**Verify:**
```bash
# Check your current settings
grep "WEBXPAY" .env

# Make sure:
WEBXPAY_SECRET_KEY=<from sandbox dashboard>
WEBXPAY_SANDBOX=true  # Must match!
```

**If WEBXPAY_SANDBOX=true:**
- Secret Key must be from: stagingxpay.info dashboard
- Public Key must be from: stagingxpay.info dashboard

**If WEBXPAY_SANDBOX=false:**
- Secret Key must be from: webxpay.com dashboard
- Public Key must be from: webxpay.com dashboard

---

### 3. Public Key File is Corrupted

**Test your public key:**
```bash
openssl rsa -pubin -in storage/app/webxpay_public.pem -text -noout
```

**Should output:**
```
Public-Key: (1024 bit) or (2048 bit)
Modulus:
    00:xx:xx:xx...
Exponent: 65537 (0x10001)
```

**If you get an error:**
- Re-download the public key from WebXPay dashboard
- Make sure no extra characters or spaces were added
- Check file permissions: `chmod 644 storage/app/webxpay_public.pem`

---

### 4. API Username/Password Confusion

The **API Username and Password** you provided are for **API authentication** (for backend API calls), NOT for the payment gateway form.

**I've already fixed this** - they are no longer being sent in the payment form.

---

## ✅ RECOMMENDED SOLUTION STEPS

Follow these steps in order:

### Step 1: Verify Your Environment

```bash
grep "WEBXPAY_SANDBOX" .env
```

**If it shows `WEBXPAY_SANDBOX=true`:**
- You're using SANDBOX mode
- Continue to Step 2 (Sandbox)

**If it shows `WEBXPAY_SANDBOX=false`:**
- You're using PRODUCTION mode
- Continue to Step 2 (Production)

---

### Step 2a: For SANDBOX Mode

1. **Login to Sandbox Dashboard:**
   ```
   URL: https://stagingxpay.info/
   ```

2. **Navigate to API Settings:**
   - Settings → API Settings or Integration

3. **Copy/Download:**
   - ✅ **Secret Key** (copy to clipboard)
   - ✅ **Public Key** (download the .pem file)
   - Note: API Username/Password are for API calls, not payment forms

4. **Update your files:**
   ```bash
   # Update .env
   WEBXPAY_SECRET_KEY=<paste sandbox secret key here>
   WEBXPAY_SANDBOX=true

   # Replace public key
   cp ~/Downloads/webxpay_public.pem storage/app/webxpay_public.pem
   ```

---

### Step 2b: For PRODUCTION Mode

1. **Login to Production Dashboard:**
   ```
   URL: https://webxpay.com/
   ```

2. **Navigate to API Settings:**
   - Settings → API Settings or Integration

3. **Copy/Download:**
   - ✅ **Secret Key** (copy to clipboard)
   - ✅ **Public Key** (download the .pem file)

4. **Update your files:**
   ```bash
   # Update .env
   WEBXPAY_SECRET_KEY=<paste production secret key here>
   WEBXPAY_SANDBOX=false

   # Replace public key
   cp ~/Downloads/webxpay_public.pem storage/app/webxpay_public.pem
   ```

---

### Step 3: Clear Cache and Test

```bash
php artisan config:clear
php artisan config:cache
php artisan webxpay:test-connection
```

**Expected output:**
```
✓ All tests passed! WebXPay is properly configured.
```

---

### Step 4: Try Payment Again

1. Go to your application
2. Try processing a test payment
3. Monitor logs: `tail -f storage/logs/laravel.log`

---

## 🔍 Still Getting Error 442?

### Check WebXPay Dashboard Settings

1. **Verify Return URL is configured:**
   - In WebXPay dashboard → Settings → Integration
   - Return URL should be: `https://yourdomain.com/payment/webxpay/return`
   - For local testing: `http://localhost/payment/webxpay/return`

2. **Verify IP Whitelisting (if enabled):**
   - Some WebXPay accounts require IP whitelisting
   - Add your server's IP address to allowed IPs

3. **Verify Account is Active:**
   - Make sure your WebXPay merchant account is approved and active
   - Sandbox accounts might have restrictions

---

## 📞 Contact WebXPay Support

If the error persists after trying all above steps:

**Email:** support@webxpay.com

**Subject:** Error 442 - Invalid Encryption

**Include:**
1. Your merchant ID or email
2. Environment (Sandbox or Production)
3. First 8 characters of your secret key: `901d2017...`
4. Confirmation that you downloaded the public key from dashboard
5. Screenshot of the error
6. Ask: "Can you verify my secret key and public key are properly matched?"

---

## 💡 Quick Checklist

- [ ] Using correct environment (sandbox vs production)
- [ ] Secret key is from correct dashboard (sandbox/production)
- [ ] Public key is from correct dashboard (sandbox/production)
- [ ] Public key is the one FOR ENCRYPTING PAYMENTS (not merchant key)
- [ ] Both keys are from the SAME merchant account
- [ ] Public key file is valid (openssl command works)
- [ ] Config cache cleared
- [ ] Test command passes
- [ ] Return URL configured in WebXPay dashboard
- [ ] Merchant account is active

---

## Common WebXPay Key Names

When downloading from dashboard, look for keys labeled:

✅ **CORRECT - Use these:**
- "Public Key for Payment Integration"
- "WebXPay Public Key"
- "Encryption Public Key"
- "Payment Gateway Public Key"

❌ **WRONG - Don't use these:**
- "Merchant Public Key"
- "Your Public Key"
- "Response Encryption Key"
- "Callback Public Key"

---

## Test After Each Change

After making changes, ALWAYS test:

```bash
# 1. Clear cache
php artisan config:clear

# 2. Test connection
php artisan webxpay:test-connection

# 3. Try a small payment (LKR 10)
```

---

## Success Indicators

You'll know it's working when:
1. Test command shows: ✓ All tests passed
2. Payment form redirects to WebXPay gateway
3. No error 442 appears
4. WebXPay shows payment page (card input form)

Good luck! 🍀
