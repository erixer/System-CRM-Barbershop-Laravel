<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset('css/styless.css') }}" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <img src="{{ asset('img/logo cool-guy.jpg') }}" style="width: 40px; margin:20px; border-radius: 50px" alt="">
                <a class="navbar-brand" href="{{ url('/') }}">
                    COOL-GUY BARBERSHOP
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarResponsive">
        
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}" >Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/testimoni') }}" >Testimoni</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/keluhan') }}" >Keluhan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('front') }}" @yield('booking')>Booking</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('carts.index') }}" @yield('booking')><i class="bi-cart-fill me-1"></i>Cart
                                    <span class="badge bg-dark text-white ms-1 rounded-pill">{{ App\Models\cart::where('id_users', Auth::user()->id)->count(); }}</span>
                                </a>  
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->first_name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    
                                    </li>
                                        <a class="nav-link" href="{{ route('profiles.index') }}"><i class="bi bi-person-fill"></i>Profile</a>
                                    <li>
                                    <li>
                                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                        <a class="nav-link" href="{{ route('antrian') }}"><i class="fab fa-buffer"></i> Antrian</a>
                                    <li>
                                    <li>
                                        <a class="nav-link" href="{{ route('search.code') }}"><i class="fas fa-search"></i> Search Code</a>
                                    </li>
    
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Navigation
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        -->
        <!-- Product section-->
        <form action="{{ route('carts.store') }}" method="post">
            @csrf
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" name="images" src="{{ url('img/produk/')}}/{{ $produk->images }}" alt="..." /></div>
                    <div class="col-md-6">
                        <input type="hidden" name="id_produk" value="{{ $produk->id }}" class="form-control">
                        
                        <h1 name="name" class="display-5 fw-bolder">{{ $produk ->name }}</h1>
                        <div class="small mb-1">{{ $produk ->slug }}</div>
                        <div class="fs-5 mb-5">
                            <span name="price">{{ $produk ->price }} K</span>
                        </div>
                        <h5>Deskripsi</h5>
                        <p class="lead">{{ $produk ->desc }}</p>
                        <div class="d-flex">
                            <input class="form-control text-center me-3" name="qty" id="inputQuantity" type="hidden" value="1" style="max-width: 3rem" />
                            <button type="submit" class="btn btn-outline-dark flex-shrink-0">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Related items section-->
        </form>
        
            
        
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($produks as $produk)
                    <div class="col mb-5">
                            <div class="card h-100">
                            <!-- Product image-->
                            <a href="{{ route('showFront', $produk->id) }}"><img class="card-img-top" src="{{ url('img/produk/')}}/{{ $produk->images }}" alt="..." /></a>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $produk->name }}</h5>
                                    <!-- Product price-->
                                    {{ $produk->price }} K
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('showFront', $produk->id) }}">View Detail</a></div>
                            </div>
                            
                        </div>
                        
                    </div>
                    @endforeach
        

                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scriptss.js') }}"></script>
    </body>
</html>
