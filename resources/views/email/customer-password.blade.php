<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your ShoeCommerce Account Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ffcc33;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ffcc33;
            margin-bottom: 10px;
        }
        .password-box {
            background-color: #f8f9fa;
            border: 2px solid #ffcc33;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .password {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .warning strong {
            color: #856404;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #ffcc33;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">👟 ShoeCommerce</div>
            <h1>Your Account Password</h1>
        </div>

        <p>Hello <strong>{{ $customer->name }}</strong>,</p>

        <p>You requested to recover your password for your ShoeCommerce account. Here is your current password:</p>

        <div class="password-box">
            <p><strong>Your Password:</strong></p>
            <div class="password">{{ $password }}</div>
        </div>

        <div class="warning">
            <strong>⚠️ Security Notice:</strong><br>
            Please save this password in a secure location. For your security, we recommend changing your password after logging in.
        </div>

        <p>You can now use this password to log in to your account:</p>

        <p style="text-align: center;">
            <a href="{{ route('customer.login') }}" class="btn">Login to Your Account</a>
        </p>

        <p>If you did not request this password recovery, please ignore this email. Your account remains secure.</p>

        <p>Thank you for shopping with ShoeCommerce!</p>

        <div class="footer">
            <p>
                This email was sent to {{ $customer->email }}<br>
                © {{ date('Y') }} ShoeCommerce. All rights reserved.<br>
                <a href="{{ url('/') }}">Visit our website</a>
            </p>
        </div>
    </div>
</body>
</html>
