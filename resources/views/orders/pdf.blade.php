<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; background-color: #f4f4f9; padding: 20px; }
        h1 { color: #4CAF50; }
        p { font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .total-row { background-color: #e2f7e1; font-weight: bold; }
        .user-info { background-color: #e0f7fa; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .user-info p { margin: 5px 0; }
        .header { background-color: #4CAF50; color: white; padding: 10px; text-align: center; font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        {{ config('app.name', 'Laravel') }}
    </div>

    <div class="user-info">
        <p><strong>User:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
    </div>

    <h1>Order #{{ $order->id }}</h1>
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
                    <td>€{{ number_format($product->price, 2) }}</td>
                    <td>€{{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>€{{ number_format($total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
