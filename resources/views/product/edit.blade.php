<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Brand </title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 20px;">



    <div class="card">
        <div class="card-body">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product
                            <a href="{{route('viewproducts')}}" class="btn btn-danger btn-sm text-white float-end">Back to lists</a>
                        </h4>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('updateproducts',$product->id)}}" method="POST" enctype="multipart/form-data">
                        <!-- @method('PUT')       -->
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-2 mb-2">
                                <label>Brand select</label>
                                
                                <select name="brand_id" class="form-control">
                                <option value="{{ $previousbrand->id }}">{{ $previousbrand->bname }}</option>
                                    @foreach ($branding as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text" name="name" value=" {{ $product->name }} " class="form-control" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Slug</label>
                                <input type="text" name="slug" value="{{ $product->slug }}" class="form-control" />
                            </div>


                            <div class="col-md-6 mb-3">
                                <label>PRICE</label>
                                <input type="text" name="price" value="{{ $product->price }} " class="form-control" />
                            </div>


                            <div class="col-md-6 mb-3">
                                <label>QUANTITY</label>
                                <input type="text" name="quantity" value="{{ $product->quantity }}"  class="form-control" />
                            </div>


                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <input name="description" value=" {{ $product->description }} " class="form-control" rows="10"></input>
                            </div>


                            <div class="col-md-3 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" /></br>
                                <img src="{{asset('storage/uploads/brands/'.$product->image)}}" width="100px" height="100px">

                            </div>


                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-danger float-end">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection