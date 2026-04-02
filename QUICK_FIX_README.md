# 🎯 QUICK FIX - Video Upload Error (12288 KB)

## The Problem
You're getting this error:
```
The mountedTableActionsData.0.temp_file_path field must not be greater than 12288 kilobytes.
```

## The Real Cause

**Livewire/Filament has a HARDCODED 12MB upload limit** - completely separate from cPanel/PHP settings!

Even if you set cPanel to 1024M, Livewire still blocks files > 12MB.

---

## ✅ THE FIX (3 Steps)

### Step 1: Upload Updated Livewire Config

Upload this file from your project to your server:
```
config/livewire.php  →  [your-server]/config/livewire.php
```

This file has been updated to allow 10GB uploads instead of 12MB.

### Step 2: Clear Laravel Cache

**Via cPanel Terminal/SSH:**
```bash
cd ~/public_html  # Or wherever your Laravel root is
php artisan config:cache
```

**If no Terminal/SSH access:**
- Go to cPanel → File Manager
- Navigate to `bootstrap/cache/`
- Delete the file `config.php`

### Step 3: Also Increase cPanel PHP Limits

Even with Step 1 & 2 done, you still need proper PHP settings:

1. cPanel → **Software** → **MultiPHP INI Editor**
2. Select your domain
3. Set:
   - `upload_max_filesize` = **11000M**
   - `post_max_size` = **11000M** ← Important!
   - `max_execution_time` = **3600**
   - `max_input_time` = **3600**
   - `memory_limit` = **512M**
4. Click **Apply**

---

## 🧪 Test It

After completing all 3 steps:

1. Wait 2 minutes for changes to take effect
2. Go to your admin panel
3. Try uploading a video (start with ~50MB to test)

---

## 📋 Files to Upload to Server

From this project, upload these files to your production server:

| Local File | Server Path |
|------------|-------------|
| `config/livewire.php` | `~/public_html/config/livewire.php` |
| `public/.user.ini` | `~/public_html/public/.user.ini` |
| `public/check-limits.php` | `~/public_html/public/check-limits.php` (for testing only, delete after) |

---

## 🔍 Verify It Worked

**Option 1: Visit the diagnostic page**
- Upload `public/check-limits.php` to your server
- Visit `https://yourdomain.com/check-limits.php`
- Check if all values show ✓ OK
- **DELETE the file immediately after checking!**

**Option 2: Check Laravel config**
If you have SSH access:
```bash
cd ~/public_html
php artisan tinker
>>> config('livewire.temporary_file_upload.rules')
```

Should show:
```php
array:3 [
  0 => "required"
  1 => "file"
  2 => "max:10485760"  // This should be 10485760, not 12288!
]
```

---

## ❓ Still Not Working?

If you still get the error after following all steps:

1. **Clear browser cache** (Ctrl+Shift+Delete)
2. **Hard refresh** the admin page (Ctrl+F5)
3. **Check config was uploaded**: Download the `config/livewire.php` file from your server and verify line 68 shows `'max:10485760'`
4. **Check cache was cleared**: Make sure `bootstrap/cache/config.php` was deleted or recreated

---

## 📞 Need Help?

Check the detailed guide: `DEPLOYMENT_VIDEO_UPLOAD_FIX.md`
