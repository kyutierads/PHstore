@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{route('searchTransactions')}}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Search by product name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                            <div class="col-md-6 text-right float-right">
                                <a href="" class="btn btn-primary" target="_blank">Print All Data</a>
                            </div>
                        </div>

                        <h3>Transaction History</h3>

                        @if ($transactions->isEmpty())
                            <p>No transaction history.</p>
                        @else
                            <table class="table table-striped" id="transactionTable">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $overallTotal = 0;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->order_id }}</td>
                                            <td>{{ $transaction->username}}</td>
                                            <td>{{ $transaction->name }}</td>
                                            <td>{{ $transaction->quantity }}</td>
                                            <td>{{ $transaction->price }}</td>
                                            <td>{{ $transaction->status }}</td>
                                        </tr>
                                        @php
                                            $overallTotal += $transaction->price * $transaction->quantity;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>Overall Total: ${{ $overallTotal }}</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection