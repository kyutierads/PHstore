<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
 
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<link rel="stylesheet" href="{{asset('assets/css/styleshit.css')}}">
</head>
@extends('layouts.app')
@section('content')

<body>
  <div class="container py-5">
    <div class="row">
      @foreach ($brandproducts as $brand)
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
          <div class="bg-dark card-header">
            <h4 class="font-weight-bold text-warning">{{ $brand->name }}</h4>
          </div>
          <div class="card-body">
            <div class="product-image">
              <img src="{{ asset('storage/uploads/brands/' . $brand->image) }}" class="w-100" alt="{{ $brand->name }}" />
            </div>
            <div class="product-info ">
              <p class="price"><strong>Price:</strong> ${{ $brand->price }}</p>
              <p class="stocks"><strong>Availability:</strong> {{ $brand->quantity }}</p>
              <div class="rating">
                <span class="rating-stars">
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star text-warning"></i>
                  <i class="fas fa-star-half-alt text-warning"></i>
                </span>
                <span class="rating-label">(4.5)</span>
              </div>
              <form action="{{ route('addtocart', $brand->id) }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                  <!-- Input group for any additional options or inputs -->
                </div>
                <button type="submit" class="btn btn-dark btn-block">
                  <i class="fas fa-cart-plus me-2"></i>Add to Cart
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  
</body>
@endsection

</html>
