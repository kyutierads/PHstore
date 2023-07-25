<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CheckOut</title>

</head>
@extends('layouts.app')
@section('content')

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-8">
          <div class="card mb-4">
            <div class="card-header">
              <h5 class="card-title">Order Details</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('checkOut') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="brand_id">Shipment Type</label>
                <select name="shipping_id" id="brand_id" class="form-control" required>
                  <option value="" disabled selected>Select a shipment</option>
                  @foreach ($shippings as $shipment)
                  <option value="{{ $shipment->id }}">{{ $shipment->type }}</option>
                  @endforeach
                </select>

                <label for="brand_id">Payment Type</label>
                <select name="payment_id" class="form-control" required>
                  <option value="" disabled selected>Select a payment</option>
                  @foreach ($payments as $payment)
                  <option value="{{ $payment->id }}">{{ $payment->type }}</option>
                  @endforeach
                </select>
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea name="address" id="address" class="form-control" placeholder="Enter your address" required></textarea>
                </div>
                <hr>
                <div class="form-group" style="margin-bottom: 20px;">
                  <label for="card-details">Card Details</label>
                  <input type="text" name="card_num" id="card-details" class="form-control" placeholder="Enter your card details" required>
                </div>
                <button type="submit" class="btn btn-primary">Checkout</button>
              </form>
            </div>
          </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title">Order Summary</h5>
          </div>
          <div class="card-body">
            @foreach($cart as $productcarts)
            <div class="row mb-3">
              <div class="col-md-6">
                <img src="{{asset('storage/uploads/brands/'.$productcarts->product->image)}}" class="img-fluid" alt="Product image">
              </div>
              <div class="col-md-6">
                <strong>
                  <p class="mb-2">Product:
                </strong>{{ $productcarts->product->name }}</p>
                <strong>
                  <p class="mb-2">Price:
                </strong>${{ number_format($productcarts->product->price, 2) }}</p>
                <strong>
                  <p class="mb-2">Quantity:
                </strong>{{ $productcarts->quantity }}</p>
                <strong>
                  <p class="mb-0">Subtotal:
                </strong> ${{ number_format($productcarts->product->price * $productcarts->quantity, 2) }}</p>
              </div>
            </div>
            @endforeach

            @php
            $total = 0;
            @endphp

            @foreach($cart as $productcarts)
            @php
            $total += ($productcarts->product->price * $productcarts->quantity);
            @endphp
            @endforeach
            <hr>
            <div class="row">
              <div class="col-md-6">
                <h6 class="mb-2">Total:</h6>
              </div>
              <div class="col-md-6">
                <p class="mb-0">${{ number_format($total, 2) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    label {
      font-weight: bold;
    }

    input.form-control,
    textarea.form-control {
      background-color:
        #f9f9f9;
      border: none;
      border-radius: 0;
      border-bottom: 2px solid #ddd;
    }

    input.form-control:focus,
    textarea.form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }

    .card-title {
      font-size: 1.5rem;
      margin-bottom: 0;
    }

    .card-body hr {
      margin: 1rem 0;
      border: none;
      border-top: 1px solid #ddd;
    }
  </style>

</body>
@endsection

</html>