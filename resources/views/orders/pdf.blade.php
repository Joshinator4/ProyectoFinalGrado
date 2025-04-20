<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #6a1b9a;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .user-info {
            background-color:rgb(37, 160, 119);
            padding: 10px;
            margin-top: 20px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #6a1b9a;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        tr:nth-child(even) td {
            background-color: #f5f5f5;
        }

        .total-row td {
            background-color: #dcedc8;
            font-weight: bold;
        }

        .logo {
            margin-top: 40px;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ config('app.name', 'Laravel') }}
        </div>

        <div class="user-info">
            <p><strong>User:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>

        <h2>Order #{{ $order->id }}</h2>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y - H:i') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($order->orderDetails as $detail)
                    @php
                        $product = $detail->product;
                        $subtotal = $product->price * $detail->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($product->price, 2) }}€</td>
                        <td>{{ number_format($subtotal, 2) }}€</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3"><strong>Total</strong></td>
                    <td>{{ number_format($total, 2) }}€</td>
                </tr>
            </tbody>
        </table>

        <img src="{{ public_path('img/logo-ies-playamar.png') }}" alt="Logo" class="logo">
    </div>
</body>
</html>
