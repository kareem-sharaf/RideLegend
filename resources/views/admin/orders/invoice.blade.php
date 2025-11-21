<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice #{{ $order->order_number }}</h1>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <div class="info">
        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $order->buyer->first_name }} {{ $order->buyer->last_name }}</p>
        <p><strong>Email:</strong> {{ $order->buyer->email }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->title ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Subtotal:</td>
                <td class="total">${{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Tax:</td>
                <td class="total">${{ number_format($order->tax, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Shipping:</td>
                <td class="total">${{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Discount:</td>
                <td class="total">-${{ number_format($order->discount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="total">Total:</td>
                <td class="total">${{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="info">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        @if($order->payments->count() > 0)
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payments->first()->payment_method)) }}</p>
        @endif
    </div>
</body>
</html>

