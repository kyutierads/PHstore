<!DOCTYPE html>
<html>

<head>
    <title>New Order Notification</title>
</head>

<body>
    <h1>New Order Notification</h1>
    <p>Hello PhoneHub store,</p>
    <p>There is a new order placed by {{ $order->user->name }}. Below are the order details:</p>
    <p>Order ID: {{ $order->id }}</p>
    <p>Product Name:
        @foreach ($order->products as $product)
        <tr> <b> {{ $product->pivot->quantity }}x </b></tr>
        <tr> {{ $product->name }}</tr>
       <br>     {{-- {{ $product->pivot->quantity }}x {{ $product->name }} --}}
        @endforeach
    </p>
    {{-- <p>Quantity: {{ $order->product->quantity }}</p> --}}
    <p>Price: @php
        $price = $order->products
            ->map(function ($product) {
                return $product->price * $product->pivot->quantity;
            })
            ->sum();
    @endphp
        {{ $price }}
    </p>
    <!-- Include other order details as needed -->

    <p>Please review and approve the order.</p>
    <p>Thank you!</p>
</body>

</html>
