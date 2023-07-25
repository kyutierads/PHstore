<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PhoneHub</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Styles -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #ffbb00;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    PhoneHub
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">

                            <!-- <form class="d-flex" action="" method="GET">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form> -->

                            <form class="d-flex" action="{{ route('productSearch') }}" method="GET">
                                <input class="form-control me-2 bg-warning" type="search" placeholder="Search..."
                                    aria-label="Search" name="search_query">
                                <button class="btn btn-outline-warning" type="submit">Search</button>
                            </form>

                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-link" href="{{route('brandcollection')}}">
                            <i class="fas fa-shopping-cart"></i> Brand Categories
                            <span class="badge bg-secondary"></span>
                        </a> 
                    </li> --}}
                        {{-- <li class="nav-item">
                        <a class="nav-link" href="{{route('productcollection')}}">
                            <i class="fas fa-shopping-cart"></i> Product Categories
                            <span class="badge bg-secondary"></span>
                        </a> 
                    </li> --}}
                    </ul>

                    <!-- Right Side Of Navbar -->

                    <ul class="navbar-nav ms-auto">

                        @guest

                            <!-- Authentication Links -->


                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCart" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-shopping-cart"></i> Cart
                                    <span class="badge bg-secondary"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownCart">
                                    <a class="dropdown-item" href="{{ route('cartindex') }}">View Cart</a>
                                    <a class="dropdown-item" href="{{ route('Orders') }}">View Order</a>
                                    <a class="dropdown-item" href="{{ route('orderHistory') }}">Order History</a>
                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Admin Panel Navbar -->
                                    @if (Auth::user()->role == 'admin')
                                        <h6 class="dropdown-header">CRUDs</h6>
                                        <a class="dropdown-item" href="{{ route('viewproducts') }}">Products</a>
                                        <a class="dropdown-item" href="{{ route('viewbrands') }}">Brands</a>
                                        <a class="dropdown-item" href="{{ route('viewshippings') }}">Shipping Methods</a>
                                        <a class="dropdown-item" href="{{ route('viewpayments') }}">Payment Methods</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                            
                                    <h6 class="dropdown-header">Transactions</h6>
                                    <a class="dropdown-item" href="{{ route('viewAllorders') }}">Orders</a>
                                    <a class="dropdown-item" href="{{ route('viewTransactions') }}">Transactions</a>
                            
                                    <div class="dropdown-divider"></div>
                            
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                            
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                                


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


</body>


</html>
