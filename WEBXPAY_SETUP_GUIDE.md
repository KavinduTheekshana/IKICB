# WebXPay Integration Setup & Troubleshooting Guide

## Overview
This guide will help you set up and troubleshoot the WebXPay payment gateway integration for course payments.

## Initial Setup

### Step 1: Get WebXPay Credentials

1. **Login to WebXPay Merchant Dashboard**
   - Production: https://webxpay.com/
   - Sandbox: https://stagingxpay.info/

2. **Get Your Secret Key**
   - Navigate to: Settings → API Settings
   - Copy your **Secret Key**

3. **Download Public Key**
   - In the same API Settings page
   - Download the **Public Key** file (usually named `webxpay_public.pem`)
   - This is a PEM-formatted RSA public key file

4. **Configure Return URL**
   - In WebXPay dashboard, set your return URL to:
   - Production: `https://yourdomain.com/payment/webxpay/return`
   - Local: `http://localhost/payment/webxpay/return`

### Step 2: Configure Your Application

1. **Place the Public Key File**
   ```bash
   # Copy the downloaded public key to:
   cp webxpay_public.pem storage/app/webxpay_public.pem

   # Ensure proper permissions
   chmod 644 storage/app/webxpay_public.pem
   ```

2. **Update Your `.env` File**
   ```env
   # WebXPay Payment Gateway
   WEBXPAY_SECRET_KEY=your_secret_key_here
   WEBXPAY_PUBLIC_KEY_PATH=/full/path/to/storage/app/webxpay_public.pem
   WEBXPAY_SANDBOX=true
   WEBXPAY_CMS=custom
   WEBXPAY_TIMEOUT=120
   WEBXPAY_CONNECT_TIMEOUT=60
   ```

3. **Clear Configuration Cache**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

### Step 3: Test Your Configuration

Run the test command to verify everything is set up correctly:

```bash
php artisan webxpay:test-connection
```

This will check:
- ✅ Environment variables are set
- ✅ Public key file exists and is valid
- ✅ Encryption/decryption works
- ✅ Connection to WebXPay gateway is successful

## Common Issues & Solutions

### Issue 1: "Public key file not found"

**Error Message:**
```
WEBXPAY: Public key file not found at: storage/app/webxpay_public.pem
```

**Solution:**
1. Download the public key from your WebXPay dashboard
2. Place it at `storage/app/webxpay_public.pem`
3. Check file permissions: `chmod 644 storage/app/webxpay_public.pem`
4. Update `.env` with the correct path (use absolute path on server)

**For Server (Production):**
```env
WEBXPAY_PUBLIC_KEY_PATH=/var/www/html/storage/app/webxpay_public.pem
```

**For Local Development:**
```env
WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
```

---

### Issue 2: "Failed to encrypt payment data"

**Error Message:**
```
WEBXPAY: Failed to encrypt payment data
```

**Possible Causes:**
1. **Invalid public key format**
   - The file might be corrupted
   - Re-download from WebXPay dashboard
   - Verify it starts with `-----BEGIN PUBLIC KEY-----`

2. **OpenSSL not available**
   ```bash
   # Check if OpenSSL extension is enabled
   php -m | grep openssl
   ```

   If not installed:
   ```bash
   # Ubuntu/Debian
   sudo apt-get install php-openssl
   sudo systemctl restart php-fpm

   # CentOS/RHEL
   sudo yum install php-openssl
   sudo systemctl restart php-fpm
   ```

3. **Wrong key type**
   - Ensure you downloaded the PUBLIC key, not the private key
   - The file should be for RSA encryption

---

### Issue 3: "Connection timeout" when redirecting to WebXPay

**Error Message:**
```
Connection timed out after 60000 milliseconds
```

**Solutions:**

1. **Increase timeout values in `.env`:**
   ```env
   WEBXPAY_TIMEOUT=180
   WEBXPAY_CONNECT_TIMEOUT=90
   ```

2. **Check firewall settings:**
   ```bash
   # Allow outbound HTTPS
   sudo ufw allow out 443/tcp
   ```

3. **Test connectivity to WebXPay:**
   ```bash
   # Sandbox
   curl -v https://stagingxpay.info/index.php?route=checkout/billing

   # Production
   curl -v https://webxpay.com/index.php?route=checkout/billing
   ```

4. **Check server's DNS resolution:**
   ```bash
   # Test DNS
   nslookup stagingxpay.info
   nslookup webxpay.com
   ```

---

### Issue 4: "SECRET_KEY is not set"

**Error Message:**
```
WEBXPAY: SECRET_KEY is not configured in .env
```

**Solution:**
1. Add to your `.env` file:
   ```env
   WEBXPAY_SECRET_KEY=your_secret_key_from_webxpay_dashboard
   ```

2. Clear config cache:
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

---

### Issue 5: Payment Returns but Shows Error

**Symptoms:**
- User completes payment on WebXPay
- Returns to your site but payment shows as failed

**Debug Steps:**

1. **Check Laravel logs:**
   ```bash
   tail -100 storage/logs/laravel.log
   ```

2. **Enable detailed logging in PaymentController:**
   - Logs are automatically added to failed payments
   - Check for "WebXPay payment processing failed" entries

3. **Verify decryption is working:**
   ```bash
   php artisan webxpay:test-connection
   ```

4. **Common causes:**
   - Public key mismatch (different from WebXPay dashboard)
   - Return URL not configured correctly in WebXPay dashboard
   - Status code mapping issue (check if WebXPay changed status codes)

---

### Issue 6: "Invalid payment response format"

**Error in logs:**
```
WEBXPAY: Invalid payment response format
```

**Solution:**
This means the decrypted response from WebXPay doesn't have the expected fields.

1. **Check WebXPay API version:**
   - Contact WebXPay support to confirm response format
   - They should return: `order_id|reference|datetime|gateway|status_code|comment`

2. **Temporary debug (remove after testing):**
   ```php
   // In app/Services/WebxpayService.php decryptPayment method
   Log::info('Decrypted payment response', ['raw' => $decrypted, 'parts' => $parts]);
   ```

3. **Re-run test:**
   - Process a small test payment
   - Check logs to see actual response structure
   - Update code if format changed

---

### Issue 7: Payments Work Locally but Not on Server

**Possible Causes:**

1. **Different PHP versions:**
   ```bash
   php -v  # Check version
   ```
   Ensure OpenSSL version is consistent

2. **File path differences:**
   - Use absolute paths in production `.env`:
   ```env
   WEBXPAY_PUBLIC_KEY_PATH=/var/www/html/storage/app/webxpay_public.pem
   ```

3. **Environment variable not loaded:**
   ```bash
   # On server, verify .env is loaded
   php artisan tinker
   >>> config('services.webxpay.secret_key')
   ```

4. **Server firewall blocking WebXPay:**
   - Contact your hosting provider
   - Request to whitelist:
     - `stagingxpay.info` (sandbox)
     - `webxpay.com` (production)

---

## Testing Payment Flow

### Test in Sandbox Mode

1. **Enable sandbox in `.env`:**
   ```env
   WEBXPAY_SANDBOX=true
   ```

2. **Use test cards provided by WebXPay:**
   - Contact WebXPay for test card numbers
   - Or check their developer documentation

3. **Process a test payment:**
   - Create a test course with small amount (LKR 100)
   - Go through full payment flow
   - Check logs for any errors

### Verify Payment Recording

```bash
# Check database for payment records
php artisan tinker
>>> App\Models\Payment::latest()->first()
```

Should show:
- `status`: 'pending' initially, 'completed' after successful payment
- `payment_gateway`: 'webxpay'
- `transaction_id`: Your order ID

---

## Production Checklist

Before going live with WebXPay:

- [ ] Public key file is in place and has correct permissions
- [ ] `.env` has production WebXPay credentials
- [ ] `WEBXPAY_SANDBOX=false` for production
- [ ] Return URL configured in WebXPay dashboard
- [ ] Test command passes: `php artisan webxpay:test-connection`
- [ ] Completed test payment in sandbox mode
- [ ] Logs are monitored: `storage/logs/laravel.log`
- [ ] Firewall allows HTTPS to `webxpay.com`

---

## Monitoring & Logging

### Check Payment Logs

```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log | grep -i webxpay
```

### Key Log Messages

**✅ Success indicators:**
```
Successfully encrypted test payment data
Payment record created
Payment successful
```

**❌ Error indicators:**
```
WEBXPAY: Could not read public key
WEBXPAY: Failed to encrypt payment field
Failed to decrypt payment response
Payment signature verification failed
```

---

## API Changes & Updates

WebXPay may update their API. If payments suddenly stop working:

1. **Check WebXPay announcements:**
   - Login to merchant dashboard
   - Look for API change notifications

2. **Verify field formats haven't changed:**
   ```bash
   php artisan webxpay:test-connection
   ```

3. **Re-download public key:**
   - Keys may be rotated for security
   - Download fresh copy from dashboard

4. **Contact WebXPay Support:**
   - Email: support@webxpay.com
   - Mention you're using their RSA encryption API

---

## Getting Help

### 1. Run Diagnostics
```bash
php artisan webxpay:test-connection
```

### 2. Check Laravel Logs
```bash
tail -100 storage/logs/laravel.log
```

### 3. Test Network Connectivity
```bash
curl -v https://webxpay.com/index.php?route=checkout/billing
```

### 4. Verify Configuration
```bash
php artisan tinker
>>> config('services.webxpay')
```

### 5. Contact Support
Include this information when contacting support:
- Output of test command
- Last 50 lines of Laravel log
- PHP version: `php -v`
- OpenSSL version: `php -i | grep -i openssl`
- Server environment (shared hosting, VPS, etc.)

---

## Additional Resources

- **WebXPay Developer Portal:** https://developers.webxpay.com/
- **WebXPay Merchant Dashboard (Production):** https://webxpay.com/
- **WebXPay Sandbox:** https://stagingxpay.info/
- **WebXPay Support:** support@webxpay.com

---

## Quick Reference

### Environment Variables
```env
WEBXPAY_SECRET_KEY=          # From dashboard
WEBXPAY_PUBLIC_KEY_PATH=     # Path to .pem file
WEBXPAY_SANDBOX=true         # true/false
WEBXPAY_CMS=custom           # Leave as 'custom'
WEBXPAY_TIMEOUT=120          # Request timeout in seconds
WEBXPAY_CONNECT_TIMEOUT=60   # Connection timeout in seconds
```

### Artisan Commands
```bash
php artisan webxpay:test-connection  # Test configuration
php artisan config:clear              # Clear config cache
php artisan config:cache              # Cache config
php artisan cache:clear               # Clear application cache
```

### File Locations
- Public Key: `storage/app/webxpay_public.pem`
- Service: `app/Services/WebxpayService.php`
- Controller: `app/Http/Controllers/Frontend/PaymentController.php`
- Config: `config/services.php`
- Logs: `storage/logs/laravel.log`
