# WebXPay Error 442 - Invalid Encryption Fix

## Error Message
```
442
Invalid encryption
We couldn't process your transaction and please contact your merchant for more information or please try again
```

## What This Error Means

Error 442 from WebXPay specifically means they **cannot decrypt the payment field** you're sending. This happens when:

1. ✗ Public key doesn't match your secret key (different merchant accounts)
2. ✗ Using sandbox secret key with production public key (or vice versa)
3. ✗ Public key file is corrupted or outdated
4. ✗ Secret key is incorrect

## ✅ Solution Steps

### Step 1: Verify You're Using Matching Credentials

**IMPORTANT:** Your secret key and public key MUST come from the same merchant dashboard (both sandbox OR both production).

#### If Using Sandbox (`WEBXPAY_SANDBOX=true`):

1. **Login to Sandbox Dashboard:**
   - URL: https://stagingxpay.info/
   - Login with your sandbox credentials

2. **Get Sandbox Secret Key:**
   - Navigate to: Settings → API Settings
   - Copy the **Sandbox Secret Key**
   - It should look like: `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`

3. **Download Sandbox Public Key:**
   - In the same API Settings page
   - Download the **Sandbox Public Key** (webxpay_public.pem)
   - Replace your current file: `storage/app/webxpay_public.pem`

4. **Update .env with Sandbox Credentials:**
   ```env
   WEBXPAY_SECRET_KEY=your_sandbox_secret_key_here
   WEBXPAY_SANDBOX=true
   ```

#### If Using Production (`WEBXPAY_SANDBOX=false`):

1. **Login to Production Dashboard:**
   - URL: https://webxpay.com/
   - Login with your production credentials

2. **Get Production Secret Key:**
   - Navigate to: Settings → API Settings
   - Copy the **Production Secret Key**

3. **Download Production Public Key:**
   - Download the **Production Public Key**
   - Replace: `storage/app/webxpay_public.pem`

4. **Update .env with Production Credentials:**
   ```env
   WEBXPAY_SECRET_KEY=your_production_secret_key_here
   WEBXPAY_SANDBOX=false
   ```

### Step 2: Verify Public Key File

```bash
# Check if public key is valid
openssl rsa -pubin -in storage/app/webxpay_public.pem -text -noout

# Should output RSA key details without errors
# If it shows "unable to load Public Key" - the file is corrupted
```

### Step 3: Clear Cache and Test

```bash
php artisan config:clear
php artisan config:cache
php artisan webxpay:test-connection
```

### Step 4: Test Payment Again

After updating credentials:
1. Try processing a small test payment (LKR 100)
2. Check Laravel logs if it fails: `tail -f storage/logs/laravel.log`

## Common Mistakes

### ❌ Mistake 1: Mixed Credentials
```env
# WRONG - Sandbox secret key with Production mode
WEBXPAY_SECRET_KEY=sandbox-key-xxxxxx
WEBXPAY_SANDBOX=false  ← Should be true!
```

```env
# CORRECT
WEBXPAY_SECRET_KEY=sandbox-key-xxxxxx
WEBXPAY_SANDBOX=true  ← Matches!
```

### ❌ Mistake 2: Old Public Key
- WebXPay may rotate keys for security
- Always download fresh public key if payments suddenly stop working
- Key rotation happens without notice

### ❌ Mistake 3: Wrong Merchant Account
- You might have multiple WebXPay merchant accounts
- Ensure the secret key and public key are from the SAME merchant account
- Check merchant ID in dashboard matches

### ❌ Mistake 4: File Encoding Issues
- Public key must be UTF-8 encoded
- No BOM (Byte Order Mark)
- Unix line endings (LF, not CRLF)

```bash
# Fix line endings if needed
dos2unix storage/app/webxpay_public.pem
```

## Advanced Debugging

### Check What's Being Encrypted

Add temporary logging (remove after debugging):

```php
// In app/Services/WebxpayService.php, in generatePaymentField():
Log::info('WebXPay Encryption Debug', [
    'order_id' => $orderId,
    'amount' => $amount,
    'plaintext' => $plaintext,
    'secret_key' => substr($this->secretKey, 0, 8) . '...',  // First 8 chars only
    'public_key_size' => strlen($this->getPublicKey()),
]);
```

Then check logs:
```bash
tail -f storage/logs/laravel.log | grep "WebXPay"
```

### Test Encryption Manually

```bash
php artisan tinker
```

```php
$service = app('App\Services\WebxpayService');

// Test encryption
$encrypted = $service->generatePaymentField('TEST123', 100.00);
echo "Encrypted: " . $encrypted . "\n";
echo "Length: " . strlen($encrypted) . "\n";

// Verify public key
$key = file_get_contents(storage_path('app/webxpay_public.pem'));
$keyResource = openssl_pkey_get_public($key);
$keyDetails = openssl_pkey_get_details($keyResource);
print_r($keyDetails);
```

Expected output:
- Encrypted string length: ~172 characters
- Key type: 0 (OPENSSL_KEYTYPE_RSA)
- Key bits: 1024

### Contact WebXPay Support

If error persists after trying all above:

**Email:** support@webxpay.com

**Include:**
1. Your merchant ID
2. Environment (sandbox/production)
3. First 8 characters of your secret key
4. Screenshot of the error
5. Confirmation that public key was downloaded from correct dashboard

**What to ask:**
- "I'm getting error 442 - Invalid encryption"
- "Can you verify my secret key is active and matches my public key?"
- "Is there a new public key I should download?"

## Quick Checklist

Before contacting support, verify:

- [ ] Secret key and public key from SAME dashboard (both sandbox or both production)
- [ ] `WEBXPAY_SANDBOX` setting matches the environment
- [ ] Public key file is valid (openssl command works)
- [ ] Config cache cleared: `php artisan config:clear`
- [ ] Test command passes: `php artisan webxpay:test-connection`
- [ ] No typos in secret key (copy-paste, don't type manually)
- [ ] Public key file has correct permissions: `chmod 644 storage/app/webxpay_public.pem`
- [ ] Secret key is not wrapped in quotes in .env

## Most Likely Solution

**99% of the time, error 442 is caused by:**

1. **Using sandbox secret key with production public key**
   - Solution: Download public key from sandbox dashboard

2. **Secret key copied incorrectly**
   - Solution: Delete and re-copy (watch for extra spaces)

3. **Old/expired public key**
   - Solution: Download fresh public key from dashboard

**Try these first before anything else!**

---

## After Fixing

Once you get past error 442:

1. Complete a test payment in sandbox
2. Verify payment is recorded in database
3. Check return URL receives success callback
4. Only then switch to production

## Production Deployment

When deploying to production server:

```env
# Production .env
WEBXPAY_SECRET_KEY=production_secret_key_here
WEBXPAY_PUBLIC_KEY_PATH=/var/www/html/storage/app/webxpay_public.pem
WEBXPAY_SANDBOX=false
WEBXPAY_CMS=custom
```

```bash
# On server
php artisan config:cache
php artisan webxpay:test-connection
```

Ensure both secret key and public key are from **production dashboard**.
