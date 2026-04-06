# cPanel Server Setup Guide for WebXPay

## The Problem

Your .env file contains a Mac local development path:
```
WEBXPAY_PUBLIC_KEY_PATH=/Users/kavinduhettiarachchi/Documents/Development/IKICB/storage/app/webxpay_public.pem
```

This path does NOT exist on your cPanel Linux server, causing WebXPay to fail with "Invalid encryption" errors.

## The Solution

You need to update the path in your **server's .env file** (not your local one).

### Option 1: Use Relative Path (RECOMMENDED)

**Change this line in your server's .env:**

```env
WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
```

Laravel will automatically resolve this relative to your application root.

### Option 2: Use Absolute cPanel Path

If you prefer absolute paths, use your cPanel home directory:

```env
WEBXPAY_PUBLIC_KEY_PATH=/home/YOUR_CPANEL_USERNAME/public_html/storage/app/webxpay_public.pem
```

Replace `YOUR_CPANEL_USERNAME` with your actual cPanel username.

Common cPanel usernames look like:
- `ikicbco` (domain-based)
- `user123` (generic)
- `kavindu` (custom)

To find your username, run this in cPanel Terminal:
```bash
whoami
```

## Step-by-Step Instructions

### Step 1: Upload Public Key to Server

1. **Via cPanel File Manager:**
   - Login to cPanel
   - Open File Manager
   - Navigate to: `public_html/storage/app/`
   - Upload `webxpay_public.pem` file
   - Set permissions to 644

2. **Via FTP:**
   - Connect to your server via FTP
   - Navigate to: `/public_html/storage/app/`
   - Upload `webxpay_public.pem`

3. **Via Terminal/SSH:**
   ```bash
   cd ~/public_html/storage/app/
   # Upload file here or use nano/vim to paste contents
   nano webxpay_public.pem
   # Paste key content, press Ctrl+X, Y, Enter
   chmod 644 webxpay_public.pem
   ```

### Step 2: Update .env on Server

**Via cPanel File Manager:**
1. Go to File Manager
2. Navigate to `public_html/`
3. Right-click `.env` → Edit
4. Find the line:
   ```
   WEBXPAY_PUBLIC_KEY_PATH=/Users/kavinduhettiarachchi/...
   ```
5. Change it to:
   ```
   WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
   ```
6. Save file

**Via Terminal/SSH:**
```bash
cd ~/public_html
nano .env
# Find WEBXPAY_PUBLIC_KEY_PATH line
# Change to: WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
# Press Ctrl+X, Y, Enter
```

### Step 3: Clear Cache

Run these commands in cPanel Terminal or SSH:

```bash
cd ~/public_html
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### Step 4: Verify It Works

```bash
cd ~/public_html
php artisan webxpay:test-connection
```

You should see:
```
✓ Environment variables are configured
✓ Public key file exists and is readable
✓ Public key is valid and can be loaded
✓ Encryption test successful
✓ All tests passed! WebXPay is properly configured.
```

### Step 5: Test Payment

1. Go to your website
2. Try to make a course payment
3. You should be redirected to WebXPay gateway
4. Check logs if it fails:
   ```bash
   tail -100 storage/logs/laravel.log
   ```

## Complete Server .env Configuration

Make sure your server's .env has these settings:

```env
# WebXPay Payment Gateway
WEBXPAY_SECRET_KEY=your_actual_secret_key_here
WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
WEBXPAY_API_USERNAME=your_api_username
WEBXPAY_API_PASSWORD=your_api_password
WEBXPAY_SANDBOX=true
WEBXPAY_CMS=PHP
```

**Important Notes:**
- For production, change `WEBXPAY_SANDBOX=false`
- For sandbox testing, use `WEBXPAY_SANDBOX=true`
- Make sure secret key matches the environment (sandbox vs production)

## Common Issues After Path Fix

### Issue 1: "Public key file not found"

**Check file exists:**
```bash
ls -la ~/public_html/storage/app/webxpay_public.pem
```

**Should show:**
```
-rw-r--r-- 1 username username 451 Apr 6 10:00 webxpay_public.pem
```

**If file doesn't exist:**
- Re-upload the public key file
- Check you're in the correct directory

### Issue 2: "Permission denied"

**Fix permissions:**
```bash
cd ~/public_html/storage/app
chmod 644 webxpay_public.pem
```

### Issue 3: Still getting "Invalid encryption"

This means the path is now correct, but there's a **key mismatch** issue:

**Possible causes:**
1. Secret key doesn't match public key
2. Using sandbox secret key with production public key (or vice versa)
3. Wrong merchant account credentials

**Solution:**
- Download fresh credentials from WebXPay dashboard
- Make sure both secret key and public key are from SAME merchant account
- Make sure both are from SAME environment (sandbox or production)

## Quick Checklist

- [ ] Uploaded webxpay_public.pem to server
- [ ] File is in: `public_html/storage/app/webxpay_public.pem`
- [ ] File permissions are 644
- [ ] Updated server .env with correct path
- [ ] Ran `php artisan config:clear`
- [ ] Ran `php artisan cache:clear`
- [ ] Ran `php artisan webxpay:test-connection`
- [ ] Test command shows all checks passed
- [ ] Tested payment on website

## Need Help Finding cPanel Terminal?

1. Login to cPanel
2. Scroll down to "Advanced" section
3. Click "Terminal" icon
4. You'll get a command-line interface
5. Run: `cd ~/public_html`
6. You're now in your application root directory

## Local vs Server .env

**IMPORTANT:** Keep different paths for different environments!

**Local .env (your Mac):**
```env
WEBXPAY_PUBLIC_KEY_PATH=/Users/kavinduhettiarachchi/Documents/Development/IKICB/storage/app/webxpay_public.pem
```

**Server .env (cPanel):**
```env
WEBXPAY_PUBLIC_KEY_PATH=storage/app/webxpay_public.pem
```

This is why `.env` is in `.gitignore` - each environment has its own configuration!

## Testing Checklist After Fix

1. **Test file access:**
   ```bash
   cd ~/public_html
   php -r "echo file_exists('storage/app/webxpay_public.pem') ? 'Found' : 'Not found';"
   ```
   Should output: `Found`

2. **Test key validity:**
   ```bash
   openssl rsa -pubin -in storage/app/webxpay_public.pem -text -noout
   ```
   Should show RSA key details without errors

3. **Test Laravel can read it:**
   ```bash
   php artisan tinker
   ```
   ```php
   $path = config('services.webxpay.public_key_path');
   echo $path . "\n";
   echo file_exists($path) ? "File exists\n" : "File not found\n";
   exit
   ```

4. **Test encryption:**
   ```bash
   php artisan webxpay:test-connection
   ```

5. **Test actual payment:**
   - Go to your website
   - Select a course
   - Click "Pay Now"
   - Should redirect to WebXPay gateway

## Next Steps After Path Fix

Once the path is fixed and `php artisan webxpay:test-connection` passes:

1. **If you still get "Invalid encryption" on actual payment:**
   - Issue is with your secret key or public key credentials
   - Contact WebXPay support with your merchant ID
   - Request fresh credentials

2. **If test connection passes but payment fails:**
   - Check `storage/logs/laravel.log` for detailed errors
   - Verify return URL is configured in WebXPay dashboard
   - Verify IP is whitelisted (if required)

3. **If everything works:**
   - Test with small amount first (LKR 10)
   - Verify payment is recorded in database
   - Verify course access is granted after payment
   - Then switch to production credentials

Good luck!
