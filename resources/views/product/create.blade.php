<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Create Product </title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    @extends('layouts.app')
    @section('content')
</head>

<body>



    <div class="container" style="margin-top: 20px;">

        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <h4>Add Product
                        <a href="{{route('viewproducts')}}" class="btn btn-danger btn-sm text-white float-end">Back to lists</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="card-body">

        <form action="{{ route('addproducts') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="row">
    <div class="form-group col-md-6">
      <label for="brand_id">Brand</label>
      <select name="brand_id" id="brand_id" class="form-control" >
        <option value="" disabled selected>Select a brand</option>
        @foreach ($brands as $brand)
        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
      </select>
      @error('brand_id')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" class="form-control"  />
      @error('name')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="slug">Slug</label>
      <input type="text" name="slug" id="slug" class="form-control"  />
      @error('slug')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="price">Price</label>
      <input type="text" name="price" id="price" class="form-control"  />
      @error('price')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="quantity">Quantity</label>
      <input type="text" name="quantity" id="quantity" class="form-control"  />
      @error('quantity')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-12">
      <label for="description">Description</label>
      <textarea name="description" id="description" class="form-control" rows="3" ></textarea>
      @error('description')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="form-group col-md-6">
      <label for="image">Image</label>
      <input type="file" name="image" id="image" class="form-control"  />
      @error('image')
      <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>

    <div class="col-md-12 mt-3">
      <button type="submit" class="btn btn-success">Save</button>
      <button type="reset" class="btn btn-secondary">Clear</button>
    </div>
  </div>

</form>

        </div>
    </div>


</body>
@endsection

</html>