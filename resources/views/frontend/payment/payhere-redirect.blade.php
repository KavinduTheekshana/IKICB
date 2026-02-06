<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to PayHere...</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        <h2>Redirecting to PayHere</h2>
        <p>Please wait while we redirect you to the secure payment gateway...</p>
    </div>

    <form id="payhere-form" action="https://sandbox.payhere.lk/pay/checkout" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="merchant_id" value="{{ $payHereData['merchant_id'] }}">
        <input type="hidden" name="return_url" value="{{ $payHereData['return_url'] }}">
        <input type="hidden" name="cancel_url" value="{{ $payHereData['cancel_url'] }}">
        <input type="hidden" name="notify_url" value="{{ $payHereData['notify_url'] }}">
        <input type="hidden" name="order_id" value="{{ $payHereData['order_id'] }}">
        <input type="hidden" name="items" value="{{ $payHereData['items'] }}">
        <input type="hidden" name="currency" value="{{ $payHereData['currency'] }}">
        <input type="hidden" name="amount" value="{{ $payHereData['amount'] }}">
        <input type="hidden" name="first_name" value="{{ $payHereData['first_name'] }}">
        <input type="hidden" name="last_name" value="{{ $payHereData['last_name'] }}">
        <input type="hidden" name="email" value="{{ $payHereData['email'] }}">
        <input type="hidden" name="phone" value="{{ $payHereData['phone'] }}">
        <input type="hidden" name="address" value="{{ $payHereData['address'] }}">
        <input type="hidden" name="city" value="{{ $payHereData['city'] }}">
        <input type="hidden" name="country" value="{{ $payHereData['country'] }}">
        <input type="hidden" name="hash" value="{{ $payHereData['hash'] }}">
    </form>

    <script>
        // Auto-submit form after a brief delay
        setTimeout(function() {
            document.getElementById('payhere-form').submit();
        }, 1000);
    </script>
</body>
</html>
