<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Your ShoeCommerce Verification Code</title>
    <style>
        /* Professional Email Styles - Amazon/Flipkart Inspired */
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .email-wrapper {
            width: 100%;
            background-color: #f5f5f5;
            padding: 20px 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 40px;
            text-align: center;
        }
        
        .logo {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin: 0;
        }
        
        .logo-icon {
            font-size: 32px;
            margin-right: 8px;
        }
        
        /* Content */
        .email-body {
            padding: 40px;
        }
        
        .greeting {
            font-size: 18px;
            color: #1a1a1a;
            margin: 0 0 20px 0;
            font-weight: 600;
        }
        
        .message {
            font-size: 15px;
            color: #4a4a4a;
            line-height: 1.6;
            margin: 0 0 30px 0;
        }
        
        /* OTP Box */
        .otp-container {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8ecff 100%);
            border: 2px dashed #667eea;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        
        .otp-label {
            font-size: 14px;
            color: #667eea;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 15px 0;
        }
        
        .otp-code {
            font-size: 42px;
            font-weight: 700;
            color: #667eea;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
            user-select: all;
            -webkit-user-select: all;
            -moz-user-select: all;
        }
        
        .otp-validity {
            font-size: 13px;
            color: #e74c3c;
            margin: 15px 0 0 0;
            font-weight: 600;
        }
        
        /* Info Box */
        .info-box {
            background-color: #fff9f0;
            border-left: 4px solid #f39c12;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #856404;
            line-height: 1.5;
        }
        
        /* Security Notice */
        .security-notice {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .security-notice h3 {
            font-size: 15px;
            color: #1a1a1a;
            margin: 0 0 10px 0;
            font-weight: 600;
        }
        
        .security-notice ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .security-notice li {
            font-size: 13px;
            color: #4a4a4a;
            margin: 5px 0;
            line-height: 1.5;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        
        .footer-text {
            font-size: 13px;
            color: #6c757d;
            margin: 0 0 10px 0;
            line-height: 1.6;
        }
        
        .footer-links {
            margin: 15px 0 0 0;
        }
        
        .footer-link {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
            margin: 0 10px;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .copyright {
            font-size: 12px;
            color: #9e9e9e;
            margin: 15px 0 0 0;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-body,
            .email-header,
            .email-footer {
                padding: 25px 20px;
            }
            
            .otp-code {
                font-size: 36px;
                letter-spacing: 6px;
            }
            
            .logo {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <!-- Header -->
            <div class="email-header">
                <h1 class="logo">
                    <span class="logo-icon">👟</span>
                    ShoeCommerce
                </h1>
            </div>
            
            <!-- Body -->
            <div class="email-body">
                <p class="greeting">Hello!</p>
                
                <p class="message">
                    Thank you for choosing <strong>ShoeCommerce</strong>! To complete your registration and verify your email address, please use the One-Time Password (OTP) below:
                </p>
                
                <!-- OTP Box -->
                <div class="otp-container">
                    <p class="otp-label">Your Verification Code</p>
                    <p class="otp-code">{{ $otp }}</p>
                    <p class="otp-validity">⏱️ Valid for 5 minutes only</p>
                </div>
                
                <!-- Info Box -->
                <div class="info-box">
                    <p>
                        <strong>💡 Quick Tip:</strong> Enter this code on the registration page to verify your email and activate your account.
                    </p>
                </div>
                
                <!-- Security Notice -->
                <div class="security-notice">
                    <h3>🔒 Security Guidelines</h3>
                    <ul>
                        <li>Never share this OTP with anyone, including ShoeCommerce staff</li>
                        <li>This code expires in 5 minutes for your security</li>
                        <li>If you didn't request this code, please ignore this email</li>
                        <li>Our team will never ask for your OTP via phone or email</li>
                    </ul>
                </div>
                
                <p class="message">
                    If you have any questions or need assistance, feel free to contact our support team.
                </p>
                
                <p class="message" style="margin-bottom: 0;">
                    Best regards,<br>
                    <strong>The ShoeCommerce Team</strong>
                </p>
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                <p class="footer-text">
                    This is an automated message. Please do not reply to this email.
                </p>
                
                <div class="footer-links">
                    <a href="#" class="footer-link">Help Center</a>
                    <span style="color: #dee2e6;">•</span>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <span style="color: #dee2e6;">•</span>
                    <a href="#" class="footer-link">Terms of Service</a>
                </div>
                
                <p class="copyright">
                    © {{ date('Y') }} ShoeCommerce. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
