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
                                <h3 class="card-title">Order History</h3>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="container">
                                    <h4>Cancelled Orders:</h4>
                                    @if ($cancelledOrders->isEmpty())
                                        <p>No cancelled orders.</p>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cancelledOrders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->name }}</td>
                                                        <td>{{ $order->price }}</td>
                                                        <td>{{ $order->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="container">
                                    <h4>Received Orders:</h4>
                                    @if ($receivedOrders->isEmpty())
                                        <p>No received orders.</p>
                                    @else
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Product Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($receivedOrders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
                                                        <td>{{ $order->name }}</td>
                                                        <td>{{ $order->price }}</td>
                                                        <td>{{ $order->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
