<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-info {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .totals {
            float: right;
            width: 300px;
        }

        .totals table {
            border: none;
        }

        .totals td {
            border: none;
            padding: 5px 10px;
        }

        .totals tr:last-child td {
            font-weight: bold;
            border-top: 2px solid #333;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>Invoice #{{ $invoice->invoice_number }}</p>
        <p>Date: {{ $invoice->issue_date->format('d M Y') }}</p>
    </div>

    <div class="invoice-info">
        <h3>Bill To:</h3>
        <p>{{ $user->name }}</p>
        <p>{{ $user->email }}</p>
        @if ($order->addresses->where('type', 'billing')->first())
            @php $billingAddress = $order->addresses->where('type', 'billing')->first(); @endphp
            <p>{{ $billingAddress->address_line1 }}</p>
            @if ($billingAddress->address_line2)
                <p>{{ $billingAddress->address_line2 }}</p>
            @endif
            <p>{{ $billingAddress->city }}, {{ $billingAddress->state }} {{ $billingAddress->postal_code }}</p>
            <p>{{ $billingAddress->country }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td>${{ number_format($invoice->tax, 2) }}</td>
            </tr>
            <tr>
                <td>Total:</td>
                <td>${{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is an automatically generated invoice. Please do not reply to this email.</p>
    </div>
</body>

</html>
