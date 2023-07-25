<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
@extends('layouts.app')
@section('content')

    <body>
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <p><span class="h2">Shopping Cart </span><span class="h4"></span></p>
                    @foreach ($cart as $productcarts)
                        <div class="card mb-4">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/uploads/brands/' . $productcarts->product->image) }}"
                                            class="img-fluid" alt="Product image">
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <strong>
                                                <p class="small text-muted mb-4 pb-2">Name</p>
                                            </strong>
                                            <p class="lead fw-normal mb-0">{{ $productcarts->product->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <br>
                                            <form action="{{ route('updatecartitem', $productcarts->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <strong>
                                                    <p class="small text-muted mb-4 pb-2">Quantity</p>
                                                </strong>
                                                <div class="input-group mb-3">
                                                    <input type="number" name="quantity"
                                                        value="{{ $productcarts->quantity }}" class="form-control"
                                                        min="1">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-success ">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <strong>
                                                <p class="small text-muted mb-4 pb-2">Price</p>
                                            </strong>
                                            <p class="lead fw-normal mb-0">
                                                ${{ number_format($productcarts->product->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <strong>
                                                <p class="small text-muted mb-4 pb-2">Subtotal</p>
                                            </strong>
                                            <p class="lead fw-normal mb-0">
                                                ${{ number_format($productcarts->product->price * $productcarts->quantity, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex justify-content-center">
                                        <div>
                                            <strong>
                                                <p class="small text-muted mb-4 pb-2">Action</p>
                                            </strong>
                                            <a href="{{ route('deletecartitem', $productcarts->id) }}"
                                                class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach






                    @php
                        $total = 0;
                    @endphp

                    @foreach ($cart as $productcarts)
                        @php
                            $total += $productcarts->product->price * $productcarts->quantity;
                        @endphp
                    @endforeach
                    <div class="card mb-5">
                        <div class="card-body p-4">

                            <div class="float-end">
                                <p class="mb-0 me-5 d-flex align-items-center">
                                    <strong><span class="small text-muted me-2">Total Orders:</span> <span
                                            class="lead fw-normal">${{ number_format($total, 2) }}</span></strong>
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('productcollection') }}"><button type="button"
                                class="btn btn-dark btn-lg me-2">Continue shopping</button></a>
                        <a href="{{ route('gocheckout') }}"><button type="button"
                                class="btn btn-success btn-lg">CheckOut</button></a>
                        <!-- <button type="button" class="btn btn-success btn-lg">CheckOut</button> -->
                    </div>
                </div>
            </div>
    </body>
@endsection

</html>
