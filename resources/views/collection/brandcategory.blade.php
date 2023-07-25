<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Brands</title>
   
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
@extends('layouts.app')
@section('content')

<body>

<div class="container py-5">
  <h4 class="text-center mt-4 mb-5"><strong>Brand Categories</strong></h4>
  
  <div class="row">
    @foreach ($brands as $brand)
    <div class="col-lg-4 col-md-6 mb-4">
      <a href="">
      <div class="card">
        <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
          <img src="{{ asset('storage/uploads/brands/' . $brand->image) }}" class="w-100" alt="{{ $brand->name }}" />
          <a href="#!">
            <div class="mask"></div>
            <div class="hover-overlay">
              <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
            </div>
          </a>
        </div>
        <div class="card-body">
          <a href="" class="text-reset">
            <h5 class="card-title mb-3">{{ $brand->name }}</h5>
          </a>
        </div>
      </div>
      </a>
    </div>
    @endforeach
  </div>
</div>

  

</body>
@endsection

</html>