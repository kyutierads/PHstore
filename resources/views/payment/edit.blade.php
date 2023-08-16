<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Payment Methods </title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body background="{{ asset('storage/uploads/brands/1.jpg') }}">


    <div class="container" style="margin-top: 20px;">


        @if(session('message'))
        <div class="alert alert-success">{{session('message')}}</div>
        @endif
        <div class="card">
            <div class="card-body card-outline-primary">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Payment Method
                                <a href="{{route('viewpayments')}}" class="btn btn-danger btn-sm text-white float-end">Back to lists</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-body">

                        <form action="{{route('updatePayment',$payment->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="payment-method">Payment Method</label>
                                    <input type="text" name="type" value=" {{ $payment->type }} " class="form-control" required />
                                    @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Payment Image</label>
                                    <input type="file" name="payment_image" class="form-control" /></br>
                                    <img src="{{asset('storage/uploads/brands/'.$payment->payment_image)}}" width="100px" height="100px">

                                </div>

                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-success float-end">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>