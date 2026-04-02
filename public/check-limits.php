<?php
/**
 * PHP Upload Limits Diagnostic Script
 * Upload this file to your public/ directory and visit it in your browser
 * DELETE THIS FILE after checking!
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Upload Limits Check</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .setting { margin: 15px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #2196F3; }
        .label { font-weight: bold; color: #555; margin-bottom: 5px; }
        .value { font-size: 18px; color: #000; font-family: monospace; }
        .good { color: #4CAF50; font-weight: bold; }
        .bad { color: #f44336; font-weight: bold; }
        .warning { color: #ff9800; font-weight: bold; }
        .status { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .status.good { background: #dff0d8; border: 1px solid #4CAF50; }
        .status.bad { background: #f2dede; border: 1px solid #f44336; }
        .status.warning { background: #fcf8e3; border: 1px solid #ff9800; }
        .delete-warning { background: #ffebee; border: 2px solid #f44336; padding: 15px; margin-top: 30px; border-radius: 4px; }
        code { background: #eee; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 PHP Upload Limits Diagnostic</h1>

        <?php
        // Get current PHP settings
        $upload_max = ini_get('upload_max_filesize');
        $post_max = ini_get('post_max_size');
        $memory = ini_get('memory_limit');
        $max_exec = ini_get('max_execution_time');
        $max_input = ini_get('max_input_time');

        // Convert to bytes for comparison
        function convertToBytes($value) {
            $value = trim($value);
            $last = strtolower($value[strlen($value)-1]);
            $value = (int)$value;

            switch($last) {
                case 'g': $value *= 1024;
                case 'm': $value *= 1024;
                case 'k': $value *= 1024;
            }
            return $value;
        }

        $upload_bytes = convertToBytes($upload_max);
        $post_bytes = convertToBytes($post_max);
        $memory_bytes = convertToBytes($memory);

        // Required: 10GB + overhead = 11GB
        $required_bytes = 11 * 1024 * 1024 * 1024; // 11GB in bytes

        $upload_ok = $upload_bytes >= $required_bytes;
        $post_ok = $post_bytes >= $required_bytes;
        $memory_ok = $memory_bytes >= (512 * 1024 * 1024); // 512MB
        $exec_ok = $max_exec_time >= 3600 || $max_exec_time == 0;
        $input_ok = $max_input_time >= 3600 || $max_input_time == 0;

        $all_ok = $upload_ok && $post_ok && $memory_ok && $exec_ok && $input_ok;
        ?>

        <?php if ($all_ok): ?>
            <div class="status good">
                <strong>✅ All settings are configured correctly!</strong><br>
                Your PHP configuration supports large video uploads (11GB).
            </div>
        <?php else: ?>
            <div class="status bad">
                <strong>❌ Some settings need adjustment</strong><br>
                See details below for what needs to be fixed.
            </div>
        <?php endif; ?>

        <h2>📊 Current PHP Settings</h2>

        <div class="setting">
            <div class="label">upload_max_filesize</div>
            <div class="value">
                <?php echo $upload_max; ?>
                <?php if ($upload_ok): ?>
                    <span class="good">✓ OK (≥ 11GB)</span>
                <?php else: ?>
                    <span class="bad">✗ TOO SMALL (need 11000M or 11G)</span>
                <?php endif; ?>
            </div>
            <small>Maximum size of a single uploaded file</small>
        </div>

        <div class="setting">
            <div class="label">post_max_size</div>
            <div class="value">
                <?php echo $post_max; ?>
                <?php if ($post_ok): ?>
                    <span class="good">✓ OK (≥ 11GB)</span>
                <?php else: ?>
                    <span class="bad">✗ TOO SMALL (need 11000M or 11G) - THIS IS YOUR ERROR!</span>
                <?php endif; ?>
            </div>
            <small><strong>This is the setting causing your "12288 kilobytes" error!</strong></small>
        </div>

        <div class="setting">
            <div class="label">memory_limit</div>
            <div class="value">
                <?php echo $memory; ?>
                <?php if ($memory_ok): ?>
                    <span class="good">✓ OK (≥ 512M)</span>
                <?php else: ?>
                    <span class="warning">⚠ Should be at least 512M</span>
                <?php endif; ?>
            </div>
            <small>Maximum memory a script can use</small>
        </div>

        <div class="setting">
            <div class="label">max_execution_time</div>
            <div class="value">
                <?php echo $max_exec; ?> seconds
                <?php if ($exec_ok): ?>
                    <span class="good">✓ OK</span>
                <?php else: ?>
                    <span class="warning">⚠ Should be 3600 or 0 (unlimited)</span>
                <?php endif; ?>
            </div>
            <small>Maximum time a script can run</small>
        </div>

        <div class="setting">
            <div class="label">max_input_time</div>
            <div class="value">
                <?php echo $max_input; ?> seconds
                <?php if ($input_ok): ?>
                    <span class="good">✓ OK</span>
                <?php else: ?>
                    <span class="warning">⚠ Should be 3600 or 0 (unlimited)</span>
                <?php endif; ?>
            </div>
            <small>Maximum time for parsing input data</small>
        </div>

        <h2>📋 Additional Information</h2>

        <div class="setting">
            <div class="label">PHP Version</div>
            <div class="value"><?php echo PHP_VERSION; ?></div>
        </div>

        <div class="setting">
            <div class="label">Server API</div>
            <div class="value"><?php echo PHP_SAPI; ?></div>
        </div>

        <div class="setting">
            <div class="label">Loaded php.ini</div>
            <div class="value" style="font-size: 12px;"><?php echo php_ini_loaded_file() ?: 'None'; ?></div>
        </div>

        <div class="setting">
            <div class="label">Additional .ini files</div>
            <div class="value" style="font-size: 12px;">
                <?php
                $scanned = php_ini_scanned_files();
                echo $scanned ? nl2br($scanned) : 'None';
                ?>
            </div>
        </div>

        <?php if (!$all_ok): ?>
        <h2>🔧 What To Do Next</h2>

        <div class="status warning">
            <strong>Step 1: Go to cPanel MultiPHP INI Editor</strong><br>
            <ol style="margin: 10px 0;">
                <li>Log into your cPanel</li>
                <li>Go to <strong>Software → MultiPHP INI Editor</strong></li>
                <li>Select your domain from the dropdown</li>
                <li>Set these values:</li>
            </ol>
            <ul style="background: white; padding: 15px; border-radius: 4px; font-family: monospace;">
                <?php if (!$upload_ok): ?>
                <li style="color: #f44336;">upload_max_filesize = <strong>11000M</strong></li>
                <?php endif; ?>
                <?php if (!$post_ok): ?>
                <li style="color: #f44336;">post_max_size = <strong>11000M</strong> ← MOST IMPORTANT</li>
                <?php endif; ?>
                <?php if (!$memory_ok): ?>
                <li style="color: #ff9800;">memory_limit = <strong>512M</strong></li>
                <?php endif; ?>
                <?php if (!$exec_ok): ?>
                <li style="color: #ff9800;">max_execution_time = <strong>3600</strong></li>
                <?php endif; ?>
                <?php if (!$input_ok): ?>
                <li style="color: #ff9800;">max_input_time = <strong>3600</strong></li>
                <?php endif; ?>
            </ul>
            <ol start="5" style="margin: 10px 0;">
                <li>Click <strong>"Apply"</strong></li>
                <li>Wait 2-3 minutes</li>
                <li><strong>Refresh this page</strong> to see if changes took effect</li>
            </ol>
        </div>

        <div class="status bad">
            <strong>If cPanel won't let you set values higher than 1024M:</strong><br>
            Your hosting provider has restricted the maximum values. You need to:
            <ul>
                <li>Contact your hosting provider's support</li>
                <li>Request they increase PHP limits to: <code>post_max_size = 11G</code> and <code>upload_max_filesize = 11G</code></li>
                <li>OR upgrade to VPS/Dedicated hosting for full control</li>
            </ul>
        </div>
        <?php endif; ?>

        <div class="delete-warning">
            <strong>⚠️ SECURITY WARNING</strong><br>
            <strong>DELETE THIS FILE (<code>check-limits.php</code>) IMMEDIATELY AFTER CHECKING!</strong><br>
            This file exposes your server configuration and should not be left publicly accessible.
        </div>
    </div>
</body>
</html>
