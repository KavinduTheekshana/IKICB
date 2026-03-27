<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to WEBXPAY...</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .loader-container {
            text-align: center;
            color: white;
        }
        .loader {
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2 {
            margin: 0 0 10px;
            font-size: 24px;
            font-weight: 600;
        }
        p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="loader-container">
        <div class="loader"></div>
        <h2>Redirecting to WEBXPAY</h2>
        <p>Please wait while we redirect you to the secure payment gateway...</p>
    </div>

    <form id="webxpay-form" action="{{ $webxpayData['payment_url'] }}" method="POST" style="display: none;">
        <input type="hidden" name="secret_key"       value="{{ $webxpayData['secret_key'] }}">
        <input type="hidden" name="payment"          value="{{ $webxpayData['payment'] }}">
        <input type="hidden" name="custom_fields"    value="{{ $webxpayData['custom_fields'] }}">
        <input type="hidden" name="first_name"       value="{{ $webxpayData['first_name'] }}">
        <input type="hidden" name="last_name"        value="{{ $webxpayData['last_name'] }}">
        <input type="hidden" name="email"            value="{{ $webxpayData['email'] }}">
        <input type="hidden" name="contact_number"   value="{{ $webxpayData['contact_number'] }}">
        <input type="hidden" name="address_line_one" value="{{ $webxpayData['address_line_one'] }}">
        <input type="hidden" name="process_currency" value="{{ $webxpayData['process_currency'] }}">
        <input type="hidden" name="cms"              value="{{ $webxpayData['cms'] }}">
    </form>

    <script>
        setTimeout(function () {
            document.getElementById('webxpay-form').submit();
        }, 1000);
    </script>
</body>
</html>
