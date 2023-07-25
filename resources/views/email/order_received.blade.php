<!DOCTYPE html>
<html>
<head>
    <title>Order Received</title>
</head>
<body>
    <h1>Order Received</h1>
    <p>Hello {{ $order->shop_name }},</p>
    <p>We want to inform you that {{ Auth::user()->name }} has received the product: "{{ $order->name }}" (Order #{{ $order->id }}).</p>
    <p>Thank you for your business!</p>
</body>
</html>

