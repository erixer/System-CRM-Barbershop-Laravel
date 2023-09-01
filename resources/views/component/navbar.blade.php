<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <img src="{{ asset('img/logo cool-guy.jpg') }}" style="width: 40px; margin:20px; border-radius: 50px" alt="">
        <a class="navbar-brand" href="#page-top">COOL GUY-BARBERSHOP</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/testimoni') }}" >Testimoni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/keluhan') }}" >Keluhan</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/orderss') }}">Booking</a></li>
                
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
                    <a class="nav-link" href="{{ route('carts.index') }}"><i class="bi-cart-fill me-1"></i>Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">{{ App\Models\cart::where('id_users', Auth::user()->id)->count(); }}</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->first_name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        </li>
                            <a class="nav-link" style="color: black" href="{{ route('profiles.index') }}"><i class="bi bi-person-fill"></i>Profile</a>
                        <li>
                        <li>
                            <a class="nav-link" style="color: black" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i>
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                            <a class="nav-link" style="color: black" href="{{ route('antrian') }}"><i class="fab fa-buffer"></i> Antrian</a>
                        <li>
                        <li>
                            <a class="nav-link" style="color: black" href="{{ route('search.code') }}"><i class="fas fa-search"></i> Search Code</a>
                        </li>

                        </li>
                    </ul>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

