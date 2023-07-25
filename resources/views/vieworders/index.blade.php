@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header car d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Pending Orders</h3>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                @php
                                    $pendingOrders = $orders->where('status', 'pending')->groupBy('order_id');
                                @endphp

                                @foreach ($pendingOrders as $orderId => $orderGroup)
                                    <div class="order-container card mb-3">
                                        <div class="card-header">
                                            <h4>Order ID: {{ $orderId }}</h4>
                                       
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orderGroup as $order)
                                                        <tr>
                                                            <td>{{ $order->name }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            <td>${{ $order->price }}</td>
                                                            <td>{{ $order->status }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <h5>Total: ${{ $orderGroup->sum(function ($item) {
                                                return $item->price * $item->quantity;
                                            }) }}</h5>
                                            @if($order->status == 'pending')
                                            <form action="{{ route('cancelOrders', $orderId) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger float-right">Cancel Order</button>
                                            </form>
                                            @else
                                            <form action="{{ route('confirmOrders', $orderId) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger float-right">Cancel Order</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                @php
                                    $inTransitOrders = $orders->where('status', 'intransit')->groupBy('order_id');
                                @endphp

                                @foreach ($inTransitOrders as $orderId => $orderGroup)
                                    <div class="order-container card mb-3">
                                        <div class="card-header">
                                            <h4>Order ID: {{ $orderId }}</h4>
                                      
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orderGroup as $order)
                                                        <tr>
                                                            <td>{{ $order->name }}</td>
                                                            <td>{{ $order->quantity }}</td>
                                                            <td>${{ $order->price }}</td>
                                                            <td>{{ $order->status }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center">
                                            <h5>Total: ${{ $orderGroup->sum(function ($item) {
                                                return $item->price * $item->quantity;
                                            }) }}</h5>
                                            @if($order->status == 'intransit')
                                            <form action="{{route('orderReceived', $orderId)}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary float-right">Order Received</button>
                                            </form>
                                            @else
                                            <form action="{{route('cancelOrders', $orderId)}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger float-right mr-2">Cancel Order</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
