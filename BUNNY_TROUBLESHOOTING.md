# Bunny.net Connection Timeout Troubleshooting

## Problem
Getting `cURL error 28: Connection timed out` when uploading videos to Bunny.net on the server, but it works fine locally.

## Root Cause
Server environments often have:
- Stricter firewall rules
- Slower DNS resolution
- Different network routing
- IPv6 connectivity issues
- Proxy/NAT configurations

## Solutions Implemented

### 1. Increased Timeouts
Updated [app/Services/BunnyVideoService.php](app/Services/BunnyVideoService.php) with:
- **Connect timeout**: 60 seconds (time to establish connection)
- **Request timeout**: 120 seconds (total time for request)
- **Retry logic**: 3 attempts with 1 second delay

### 2. Force IPv4
Some servers have IPv6 configured but it's not working properly. Added:
```php
CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
```

### 3. Configuration File
Created [config/http.php](config/http.php) to make timeouts configurable via `.env`:

```env
BUNNY_TIMEOUT=120
BUNNY_CONNECT_TIMEOUT=60
BUNNY_RETRY_TIMES=3
BUNNY_RETRY_DELAY=1000
```

## Testing on Server

### Step 1: Run the diagnostic command
```bash
php artisan bunny:test-connection
```

This will test:
- DNS resolution
- cURL configuration
- Basic HTTPS connectivity
- API video creation

### Step 2: Check the output
If it fails, note where it fails:
- **DNS resolution failed**: Check your server's DNS settings
- **Connection timeout**: Firewall/network issue
- **SSL error**: SSL certificate or cURL SSL support issue
- **API error**: Check your API credentials

## Common Server Issues & Fixes

### Issue 1: Firewall Blocking Outbound HTTPS
**Symptoms**: Connection timeout on step 3 or 4

**Fix**: Allow outbound HTTPS to `video.bunnycdn.com`
```bash
# For UFW (Ubuntu)
sudo ufw allow out 443/tcp

# For iptables
sudo iptables -A OUTPUT -p tcp --dport 443 -j ACCEPT
```

### Issue 2: DNS Resolution Slow/Failing
**Symptoms**: DNS test takes > 1000ms or fails

**Fix**: Update `/etc/resolv.conf` with faster DNS
```bash
nameserver 8.8.8.8
nameserver 8.8.4.4
```

### Issue 3: IPv6 Issues
**Symptoms**: Works with IPv4 curl but times out with default

**Fix**: Already implemented - forcing IPv4 in the code

### Issue 4: Proxy Required
**Symptoms**: Direct connection fails but server uses proxy

**Fix**: Add to `.env`:
```env
HTTP_PROXY=http://proxy.example.com:8080
HTTPS_PROXY=http://proxy.example.com:8080
```

Then update [app/Services/BunnyVideoService.php](app/Services/BunnyVideoService.php):
```php
->withOptions([
    'proxy' => env('HTTPS_PROXY'),
    // ... other options
])
```

### Issue 5: SSL Certificate Issues
**Symptoms**: SSL verification errors

**Fix**: Ensure CA certificates are up to date
```bash
# Ubuntu/Debian
sudo apt-get update
sudo apt-get install --reinstall ca-certificates

# CentOS/RHEL
sudo yum reinstall ca-certificates
```

## Manual Testing

### Test 1: Basic cURL test
```bash
curl -v -X GET \
  -H "AccessKey: YOUR_API_KEY" \
  -H "Accept: application/json" \
  --connect-timeout 30 \
  --max-time 60 \
  "https://video.bunnycdn.com/library/YOUR_LIBRARY_ID/videos"
```

### Test 2: Test with IPv4 only
```bash
curl -v -4 -X GET \
  -H "AccessKey: YOUR_API_KEY" \
  "https://video.bunnycdn.com/library/YOUR_LIBRARY_ID/videos"
```

### Test 3: Create a test video
```bash
curl -v -X POST \
  -H "AccessKey: YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  --connect-timeout 60 \
  --max-time 120 \
  -d '{"title":"Test Video"}' \
  "https://video.bunnycdn.com/library/YOUR_LIBRARY_ID/videos"
```

## Still Having Issues?

### 1. Check PHP cURL extension
```bash
php -m | grep curl
```

### 2. Check cURL version and SSL support
```bash
curl --version
```

### 3. Check server's ability to reach Bunny.net
```bash
ping video.bunnycdn.com
traceroute video.bunnycdn.com
```

### 4. Check Laravel logs
```bash
tail -f storage/logs/laravel.log
```

### 5. Enable verbose cURL logging
Add to [app/Services/BunnyVideoService.php](app/Services/BunnyVideoService.php):
```php
->withOptions([
    'curl' => [
        CURLOPT_VERBOSE => true,
    ],
])
```

## Environment Variables Reference

Add these to your `.env` file on the server:

```env
# Required
BUNNY_STREAM_API_KEY=your_api_key_here
BUNNY_LIBRARY_ID=your_library_id_here

# Optional (defaults shown)
BUNNY_TIMEOUT=120
BUNNY_CONNECT_TIMEOUT=60
BUNNY_RETRY_TIMES=3
BUNNY_RETRY_DELAY=1000

# If behind proxy
HTTP_PROXY=
HTTPS_PROXY=

# HTTP client defaults
HTTP_TIMEOUT=120
HTTP_CONNECT_TIMEOUT=60
HTTP_VERIFY_SSL=true
```

## After Making Changes

1. Clear config cache:
```bash
php artisan config:clear
php artisan config:cache
```

2. Run the test command:
```bash
php artisan bunny:test-connection
```

3. Try uploading a video again

## Contact Server Administrator

If the diagnostic shows network/firewall issues, you'll need to work with your server administrator to:
1. Allow outbound HTTPS connections to `video.bunnycdn.com`
2. Ensure DNS resolution is working properly
3. Check if a proxy is required for outbound connections
4. Verify SSL certificates are up to date
