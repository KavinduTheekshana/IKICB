# Deployment Checklist for IKICB

## On Your Local Machine (Before Deployment)

### 1. Build Assets for Production
```bash
npm run build
```
This creates optimized CSS and JavaScript files in `public/build/`

### 2. Commit and Push
```bash
git add public/build
git commit -m "Build assets for production"
git push origin main
```

## On Your Server

### 1. Pull Latest Changes
```bash
cd /path/to/your/project
git pull origin main
```

### 2. Clear All Caches
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 3. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Set Proper Permissions
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Ensure .env is Configured
Make sure your `.env` file has:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ikicbcampus.com

# Make sure these are set correctly
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## If Assets Still Not Loading

### Option 1: Build Assets on Server (Not Recommended)
```bash
cd /path/to/your/project
npm install
npm run build
```

### Option 2: Copy Built Assets Manually
If you can't run npm on server, copy the `public/build` directory from your local machine to the server:
```bash
# On local machine
scp -r public/build user@your-server:/path/to/project/public/

# Or use FTP/SFTP to upload the public/build folder
```

## Troubleshooting

### Issue: "Vite manifest not found"
**Solution:** Make sure `public/build/manifest.json` exists
```bash
ls -la public/build/manifest.json
```

### Issue: CSS/JS files return 404
**Solution:** Check file permissions and ensure web server can read the files
```bash
chmod -R 755 public/build
```

### Issue: Changes not reflecting
**Solution:** Clear browser cache and Laravel caches
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Issue: "mix() or vite() helper not working"
**Solution:** Make sure you're using `@vite()` directive (not commented out)
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## Post-Deployment Verification

1. **Check Homepage**: Visit https://ikicbcampus.com
2. **Check Styling**: Ensure gold/black theme is applied
3. **Check Console**: Open browser DevTools, check for any errors
4. **Test Navigation**: Click through all pages
5. **Test Forms**: Try login/register forms
6. **Check Mobile**: Test on mobile devices

## Quick Fix Commands (Run on Server)

If something breaks, run these commands:
```bash
# Clear everything
php artisan optimize:clear

# Rebuild caches
php artisan optimize

# Fix permissions
sudo chown -R www-data:www-data /path/to/project
sudo chmod -R 775 /path/to/project/storage
sudo chmod -R 775 /path/to/project/bootstrap/cache
```

## Apache/Nginx Configuration

### Apache (.htaccess)
Make sure your `.htaccess` in `public/` directory exists:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ /public/$1 [L]
</IfModule>
```

### Nginx
Make sure your nginx config points to the `public` directory:
```nginx
root /path/to/project/public;

location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## Environment-Specific Notes

### Development (Local)
- `APP_ENV=local`
- `APP_DEBUG=true`
- Vite dev server runs on `npm run dev`

### Production (Server)
- `APP_ENV=production`
- `APP_DEBUG=false`
- Uses built assets from `public/build/`

## Common Server Issues

1. **500 Error**: Check Laravel logs in `storage/logs/laravel.log`
2. **403 Forbidden**: Check file permissions and web server configuration
3. **404 Not Found**: Ensure web server is pointing to `public` directory
4. **White Screen**: Enable debug mode temporarily to see error

## Contact & Support

If issues persist:
1. Check `storage/logs/laravel.log` for errors
2. Check web server error logs (`/var/log/apache2/error.log` or `/var/log/nginx/error.log`)
3. Verify PHP version is 8.1 or higher
4. Ensure all required PHP extensions are installed
