<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our CARTIFY</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
        }

        .content {
            padding: 20px 0;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }

        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">{{ asset('assets/images/logo.svg') }}</div>
    </div>

    <div class="content">
        <h1>Welcome, {{ $user->name }}!</h1>

        <p>Thank you for registering with our E-commerce Store. We're excited to have you as a member of our community!
        </p>

        <p>With your new account, you can:</p>
        <ul>
            <li>Browse our extensive product catalog</li>
            <li>Track your orders</li>
        </ul>

        <p>Ready to start shopping?</p>

        <a href="{{ url('/') }}" class="button">Visit Our Store</a>

        <p>If you have any questions or need assistance, please don't hesitate to contact our customer support team.</p>

        <p>Happy shopping!</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} CARTIFY. All rights reserved.</p>
        <p>This email was sent to {{ $user->email }}. If you didn't create an account with us, please ignore this
            email.</p>
    </div>
</body>

</html>
