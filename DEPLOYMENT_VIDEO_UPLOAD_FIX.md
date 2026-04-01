# Video Upload Fix - Production Deployment Guide

## Problem
Video uploads fail on production server with error:
```
The mountedTableActionsData.0.temp_file_path field must not be greater than 12288 kilobytes.
```

## Root Cause
PHP's `post_max_size` (8M) and `upload_max_filesize` (2M) are too small for the 10GB video uploads configured in the application.

---

## 🚀 Step-by-Step Fix for cPanel

### Step 1: Configure PHP Settings in cPanel (MultiPHP INI Editor)

1. **Log into cPanel**
2. **Go to:** Software → **MultiPHP INI Editor**
3. **Select your domain** from the dropdown at the top
4. **Set these values:**

   ```
   upload_max_filesize = 11000M
   post_max_size = 11000M
   max_execution_time = 3600
   max_input_time = 3600
   memory_limit = 512M
   max_input_vars = 10000
   ```

5. **Click "Apply"** at the bottom

**IMPORTANT:** You mentioned you set "max upload size 1024M" - you need to set BOTH:
- `upload_max_filesize` = 11000M
- `post_max_size` = 11000M (this is the key one!)

The error happens because `post_max_size` is different from upload size and might still be at default 8M.

### Step 2: Upload `.user.ini` File (Double Protection)

Even with cPanel settings, upload the `public/.user.ini` file as backup:

**Via cPanel File Manager:**
1. Go to **File Manager**
2. Navigate to `public_html/public/` (or wherever your Laravel `public/` folder is)
3. Click **Upload**
4. Upload the `public/.user.ini` file from this project
5. Make sure it's in the same directory as `index.php`

**File contents (already created in this project):**
```ini
upload_max_filesize = 11G
post_max_size = 11G
max_execution_time = 3600
max_input_time = 3600
memory_limit = 512M
```

### Step 3: Add `.htaccess` Rules

In cPanel File Manager, edit your `public/.htaccess` file and add these lines at the TOP (before any Laravel rules):

```apache
# Large file upload support - Add at the very top
<IfModule mod_php.c>
    php_value upload_max_filesize 11000M
    php_value post_max_size 11000M
    php_value max_execution_time 3600
    php_value max_input_time 3600
    php_value memory_limit 512M
</IfModule>

# Increase Apache request body limit
LimitRequestBody 11811160064
```

**cPanel usually uses Apache or LiteSpeed** - the `.htaccess` rules in Step 3 should work.

If you have **SSH access**, you can also restart PHP-FPM:
```bash
# Only if you have SSH/shell access
sudo systemctl restart php-fpm
# Or specific version:
sudo systemctl restart ea-php82-php-fpm  # Adjust to your PHP version
```

**If no SSH access:** cPanel will automatically apply changes when you save MultiPHP INI settings.

**Note:** Configuration changes may take 1-2 minutes to take effect. Try a hard refresh (Ctrl+F5) in your browser after making changes.

### Step 5: Verify Configuration in cPanel

**Check if settings were applied:**

1. In cPanel, go to **MultiPHP INI Editor** again
2. Look at the current values displayed
3. Make sure both `upload_max_filesize` and `post_max_size` show **11000M** or higher

**Alternative check via phpinfo:**
1. Create a file named `info.php` in your `public/` directory with:
   ```php
   <?php phpinfo(); ?>
   ```
2. Visit `https://yourdomain.com/info.php` in browser
3. Search for `upload_max_filesize` and `post_max_size`
4. **Delete this file immediately after checking** (security risk!)

### Step 6: Clear Laravel Cache

**If you have SSH access:**

```bash
cd /path/to/your/project
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL; echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
```

**Expected output:**
```
post_max_size: 11G (or 11000M)
upload_max_filesize: 11G (or 11000M)
```

**If no SSH access:** Use the phpinfo method described in Step 5.

### Step 7: Set Storage Symlink (If Not Already Done)

**Via SSH (if available):**
```bash
cd /path/to/your/project
php artisan storage:link
chmod -R 775 storage/
```

**Via cPanel Terminal (if SSH not available but Terminal is enabled):**
```bash
cd ~/public_html  # Or your Laravel root directory
php artisan storage:link
chmod -R 775 storage/
```

**Via cPanel File Manager (if no SSH/Terminal):**
1. Go to **File Manager**
2. Navigate to `public_html/storage/`
3. Check permissions (should be 755 or 775)
4. If needed, select `storage` folder → Permissions → Set to 775

### Step 8: Verify Bunny.net Credentials

Check your production `.env` file has:

```env
BUNNY_STREAM_API_KEY=your_actual_api_key
BUNNY_LIBRARY_ID=your_actual_library_id
```

Clear config cache:
```bash
php artisan config:cache
```

---

## 🧪 Testing

1. Log into admin panel
2. Navigate to Modules → Select a module → Videos tab
3. Try uploading a video file (start with a small one ~50MB)
4. Gradually test larger files up to your maximum size

---

## 📋 Troubleshooting for cPanel

### Issue: Still getting 12288 KB error after setting cPanel to 1024M

**Root Cause:** You set `upload_max_filesize` to 1024M, but `post_max_size` is still at default (8M or 12M).

**The Fix - Check BOTH settings in MultiPHP INI Editor:**

cPanel has TWO separate settings:
1. `upload_max_filesize` = 11000M ← File size limit
2. `post_max_size` = 11000M ← **THIS IS THE ONE CAUSING YOUR ERROR**

**post_max_size MUST be equal to or larger than upload_max_filesize!**

**Steps:**
1. Go to cPanel → **MultiPHP INI Editor**
2. Scroll down to find **both** settings
3. Set BOTH to 11000M
4. Click Apply
5. Wait 2 minutes
6. Try uploading again

### Issue: cPanel won't let me set values higher than 1024M

**Cause:** Your hosting provider has set a maximum limit.

**Solution:**
1. Contact your hosting provider's support
2. Ask them to increase the PHP limits for your account
3. Mention you need: `post_max_size = 11G` and `upload_max_filesize = 11G`
4. Explain it's for a video upload application

**Alternative:** Consider upgrading to VPS/dedicated hosting for more control.

### Issue: Settings show correct in cPanel but still getting error

**Cause:** Multiple PHP versions or `.user.ini` conflicts.

**Solution:**
1. Check which PHP version your site is using: cPanel → **MultiPHP Manager**
2. Make sure you edited settings for the CORRECT PHP version
3. Check if there's an existing `.user.ini` or `php.ini` file in your directories with conflicting values
4. Remove any conflicting local PHP config files

### Issue: Upload starts but times out

**Cause:** Web server timeout is too short.

**Solution:** Increase timeout in Nginx/Apache configuration (Step 2 above).

### Issue: Upload fails with "Failed to create video on Bunny.net"

**Cause:** Bunny credentials are missing or incorrect.

**Solution:** Verify credentials in `.env` and run `php artisan config:cache`.

### Issue: Permission denied on storage

**Cause:** Web server user doesn't have write permissions.

**Solution:**
```bash
chmod -R 775 storage/
chown -R www-data:www-data storage/  # Change www-data to your web server user
```

---

## 🎯 Alternative: Switch to Asynchronous Upload (Recommended for Large Files)

For files > 1GB, consider implementing queue-based uploads to prevent browser timeouts:

1. Ensure queue worker is running:
```bash
php artisan queue:work --daemon &
```

2. Add to your supervisor/systemd to keep queue running

This prevents the admin from having to wait for the entire upload to complete.

---

## 📞 Support

If issues persist after following these steps, check:
- `storage/logs/laravel.log` - Application errors
- Web server error logs (Nginx: `/var/log/nginx/error.log`, Apache: `/var/log/apache2/error.log`)
- PHP error logs (`/var/log/php-fpm/error.log` or as configured)

---

## ✅ cPanel Deployment Checklist

### In cPanel:
- [ ] Go to **MultiPHP INI Editor**
- [ ] Set `upload_max_filesize = 11000M`
- [ ] Set `post_max_size = 11000M` ← **MOST IMPORTANT**
- [ ] Set `max_execution_time = 3600`
- [ ] Set `max_input_time = 3600`
- [ ] Set `memory_limit = 512M`
- [ ] Click **Apply** and wait 2 minutes

### Via cPanel File Manager:
- [ ] Upload `public/.user.ini` to your `public/` folder
- [ ] Edit `public/.htaccess` and add the large file upload rules at the top
- [ ] Verify storage permissions on `storage/` folder (775)

### Verify (via phpinfo or SSH):
- [ ] Confirm `post_max_size` shows 11000M or higher
- [ ] Confirm `upload_max_filesize` shows 11000M or higher
- [ ] Run `php artisan storage:link` (if SSH available)
- [ ] Run `php artisan config:cache` (if SSH available)

### Test:
- [ ] Test with small video first (~50MB)
- [ ] Test with medium video (~500MB)
- [ ] Test with large video (1GB+)

---

## 🎯 Quick Summary for cPanel Users

**The issue:** You set "max upload 1024M" but the error still says 12288KB (12MB).

**The problem:** In cPanel, there are TWO settings:
1. `upload_max_filesize` - you already set this to 1024M ✓
2. `post_max_size` - **this is probably still 8M or 12M** ✗

**The fix:**
1. cPanel → **Software** → **MultiPHP INI Editor**
2. Find `post_max_size` and change it to **11000M**
3. Also increase `upload_max_filesize` to **11000M** (to match your 10GB videos)
4. Click **Apply**
5. Wait 2 minutes and try uploading again

That should fix it! The `post_max_size` is the limit that's causing your "12288 kilobytes" error.
