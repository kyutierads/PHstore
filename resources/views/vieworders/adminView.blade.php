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
                            @if ($orders->isEmpty())
                                <p>No orders available.</p>
                            @else
                                @php
                                    $orderGroups = $orders->groupBy('order_id');
                                @endphp

                                @foreach ($orderGroups as $orderId => $orderGroup)
                                    <div class="order-container card mb-3">
                                        <div class="card-header">
                                            <h4>Order ID: {{ $orderId }}</h4>
                                            <p>User: {{ $orderGroup->first()->user_name }}</p>
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
                                            <h5>Total:
                                                ${{ $orderGroup->sum(function ($item) {
                                                    return $item->price * $item->quantity;
                                                }) }}
                                            </h5>

                                            <form action="{{ route('confirmOrders', $orderId) }}"method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary float-right">Confirm
                                                    Order</button>
                                            </form>
                                            <form action="{{ route('cancelOrders', $orderId) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger float-right mr-2">Cancel
                                                    Order</button>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
