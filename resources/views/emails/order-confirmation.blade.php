<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
        }

        .order-summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .order-total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">{{ asset('assets/images/logo.svg') }}</div>
    </div>

    <div class="content">
        <h1>Thank You for Your Order!</h1>

        <p>Hello {{ $order->user->name }},</p>

        <p>Your order has been received and is now being processed. Here's a summary of your purchase:</p>

        <div class="order-summary">
            <p><strong>Order Number:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}
            </p>
        </div>

        <h3>Order Details</h3>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-total">
            <p>Total: ${{ number_format($order->total_price, 2) }}</p>
        </div>

        <p>You can track your order status by visiting your account dashboard:</p>

        <a href="{{ url('/user/orders/' . $order->id) }}" class="button">View Order</a>

        <p>If you have any questions or need assistance with your order, please don't hesitate to contact our customer
            support team.</p>

        <p>Thank you for shopping with us!</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} CARTIFY. All rights reserved.</p>
        <p>This email was sent to {{ $order->user->email }} regarding your recent purchase.</p>
    </div>
</body>

</html>
