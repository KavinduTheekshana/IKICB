<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
</head>
<body style="margin:0;padding:0;background:#f9fafb;font-family:'Segoe UI',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;border:2px solid #fde68a;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.07);">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#f59e0b,#d97706);padding:32px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:900;letter-spacing:-0.5px;">ICBC Campus</h1>
                            <p style="margin:6px 0 0;color:#fef3c7;font-size:14px;">Password Reset Request</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 40px 32px;">
                            <p style="margin:0 0 16px;color:#374151;font-size:16px;line-height:1.6;">Hello,</p>
                            <p style="margin:0 0 24px;color:#374151;font-size:16px;line-height:1.6;">
                                We received a request to reset your ICBC Campus account password. Use the OTP code below to proceed. This code is valid for <strong>10 minutes</strong>.
                            </p>

                            <!-- OTP Box -->
                            <div style="background:#fffbeb;border:2px dashed #f59e0b;border-radius:12px;padding:28px;text-align:center;margin:0 0 28px;">
                                <p style="margin:0 0 8px;color:#92400e;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;">Your OTP Code</p>
                                <p style="margin:0;font-size:48px;font-weight:900;letter-spacing:12px;color:#d97706;">{{ $otp }}</p>
                            </div>

                            <p style="margin:0 0 16px;color:#6b7280;font-size:14px;line-height:1.6;">
                                If you did not request a password reset, please ignore this email. Your password will remain unchanged.
                            </p>
                            <p style="margin:0;color:#6b7280;font-size:14px;line-height:1.6;">
                                For security reasons, never share this OTP with anyone.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9fafb;border-top:1px solid #e5e7eb;padding:20px 40px;text-align:center;">
                            <p style="margin:0;color:#9ca3af;font-size:12px;">© {{ date('Y') }} IKICB Campus. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
