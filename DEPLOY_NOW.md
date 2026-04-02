# 🚀 DEPLOY NOW - Video Upload Fix

## Your Situation
- Server: **LiteSpeed** with PHP 8.4
- Current limits: **1024M** (too small)
- No MultiPHP INI Editor available
- Error: "must not be greater than 12288 kilobytes"

---

## ✅ SOLUTION: Upload 4 Files to Your Server

I've prepared all the configuration files you need. Just upload them!

### Files to Upload:

| # | Local File | Upload To Server | Why |
|---|------------|------------------|-----|
| 1 | `config/livewire.php` | `~/public_html/config/livewire.php` | **CRITICAL** - Removes Livewire's 12MB limit |
| 2 | `public/.htaccess` | `~/public_html/public/.htaccess` | Sets PHP limits for LiteSpeed |
| 3 | `public/.user.ini` | `~/public_html/public/.user.ini` | Backup PHP config |
| 4 | `.htaccess` (root) | `~/public_html/.htaccess` | Backup PHP config for root |

---

## 📤 Step-by-Step Upload Instructions

### Step 1: Upload Files via cPanel File Manager

1. **Log into cPanel**
2. Open **File Manager**
3. Navigate to your Laravel installation directory (usually `public_html`)

### Step 2: Upload Each File

#### File 1: config/livewire.php (MOST IMPORTANT!)
1. In File Manager, go to `public_html/config/`
2. Upload `config/livewire.php` from your local project
3. **Overwrite** the existing file when asked
4. This fixes the Livewire 12MB limit!

#### File 2: public/.htaccess
1. In File Manager, go to `public_html/public/`
2. Upload `public/.htaccess` from your local project
3. **Overwrite** the existing file when asked
4. This sets PHP limits in .htaccess

#### File 3: public/.user.ini
1. Still in `public_html/public/`
2. Upload `public/.user.ini` from your local project
3. This provides backup PHP configuration

#### File 4: .htaccess (root directory)
1. In File Manager, go to `public_html/` (root)
2. Upload `.htaccess` from your local project
3. **Only if there's no existing .htaccess** there
4. If one exists, skip this file

### Step 3: Clear Laravel Cache

**Option A - If cPanel has Terminal:**
1. Go to **Terminal** in cPanel
2. Run:
```bash
cd ~/public_html
php artisan config:cache
```

**Option B - No Terminal (use File Manager):**
1. In File Manager, navigate to `public_html/bootstrap/cache/`
2. Find the file named `config.php`
3. **Delete it** (Laravel will recreate it automatically)

### Step 4: Restart LiteSpeed (if possible)

**If cPanel has "Restart LiteSpeed" option:**
- Look for it under Server or Software section
- Click to restart

**If not available:**
- Don't worry, changes should apply within 1-2 minutes

### Step 5: Test Upload

1. Wait **2 minutes** for changes to take effect
2. Clear your browser cache (Ctrl+Shift+Delete)
3. Go to admin panel
4. Try uploading a video
5. Start with a small file (~50MB) to test

---

## 🔍 Verify It Worked

### Check the diagnostic page:

1. Visit: `https://yourdomain.com/check-limits.php`
2. You should now see:
   - upload_max_filesize: **11000M** ✓ OK
   - post_max_size: **11000M** ✓ OK
   - All items should show green checkmarks

3. **DELETE check-limits.php after checking!**

---

## 📋 What These Files Do

### 1. config/livewire.php
**Changes:**
- Line 68: `'max:10485760'` instead of `'max:12288'`
- Line 76: `'max_upload_time' => 60` instead of `5`

**Effect:** Allows Livewire to accept files up to 10GB instead of 12MB

### 2. public/.htaccess
**Added at top:**
```apache
php_value upload_max_filesize 11000M
php_value post_max_size 11000M
php_value max_execution_time 3600
php_value max_input_time 3600
php_value memory_limit 1024M
LimitRequestBody 11811160064
```

**Effect:** Tells LiteSpeed/Apache to allow large uploads

### 3. public/.user.ini
**Contains:**
```ini
upload_max_filesize = 11000M
post_max_size = 11000M
max_execution_time = 3600
max_input_time = 3600
memory_limit = 1024M
```

**Effect:** Alternative PHP configuration method (works with PHP-FPM)

---

## ❌ If It Still Doesn't Work

### Issue: Still getting 12288 KB error

**Possible causes:**

1. **Config cache not cleared**
   - Make sure you deleted `bootstrap/cache/config.php`
   - Or ran `php artisan config:cache`

2. **Old config still loaded in browser**
   - Clear browser cache (Ctrl+Shift+Delete)
   - Try in incognito/private window

3. **Files uploaded to wrong location**
   - Double-check file paths
   - Make sure `config/livewire.php` is in the `config/` folder, not `public/`

4. **Server has strict limits**
   - Your hosting provider may have hard limits
   - Contact their support and request they increase limits
   - Tell them: "Need `post_max_size = 11G` for video uploads"

### Issue: Upload starts but times out

**Solution:**
- This is normal for very large files (>1GB)
- The file is still uploading in the background
- Check Bunny.net dashboard to see if video appears

### Issue: .htaccess causes 500 error

**Solution:**
1. Remove the `php_value` lines from `.htaccess`
2. Keep only the `LimitRequestBody` line
3. Rely on `.user.ini` instead
4. Contact hosting support to increase PHP limits server-wide

---

## 🎯 Success Checklist

After uploading all files:

- [ ] Uploaded `config/livewire.php` to server
- [ ] Uploaded `public/.htaccess` to server (overwrote existing)
- [ ] Uploaded `public/.user.ini` to server
- [ ] Deleted `bootstrap/cache/config.php` OR ran `php artisan config:cache`
- [ ] Waited 2 minutes
- [ ] Cleared browser cache
- [ ] Checked `check-limits.php` shows 11000M
- [ ] Tested upload with small video (~50MB)
- [ ] **Deleted `check-limits.php` from server**

---

## 💡 Quick Test Command

If you have SSH/Terminal access:

```bash
# Go to your Laravel directory
cd ~/public_html

# Check current PHP settings
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"

# Check Livewire config
php artisan tinker
>>> config('livewire.temporary_file_upload.rules')
# Should show: ["required", "file", "max:10485760"]
>>> exit

# Clear cache
php artisan config:cache
```

Expected output:
```
upload_max_filesize: 11000M
post_max_size: 11000M
```

---

## 📞 Still Need Help?

1. Take a screenshot of the `check-limits.php` page after uploading files
2. Check `storage/logs/laravel.log` for errors
3. Share the error message you're getting

The files are ready - just upload them and you should be good to go! 🚀
