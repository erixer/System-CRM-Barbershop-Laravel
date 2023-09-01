
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>COOL GUY-Barbershop</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body id="page-top">
        @include('component.navbar')
        <!-- Navigation
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container px-4 px-lg-5">
                <img src="" alt="">
                <a class="navbar-brand" href="#page-top">COOL GUY-BARBERSHOP</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#projects">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#signup">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#signup">Booking</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        -->
        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h1 class="mx-auto my-0 text-uppercase">COOL GUY</h1>
                        <h2 class="text-white-50 mx-auto mt-2 mb-5">Tampil Beda Dengan Style Terkini, Tampan,& Percaya  Diri Bersama COOL GUY-BarberShop</h2>
                        <a class="btn btn-primary" href="#about">Contact Us</a>
                    </div>
                </div>
            </div>
        </header>
        <!-- About-->
        <section class="about-section text-center" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="text-white mb-4">About Us</h2>
                        <p class="text-white-50">
                            Cool Guy Barbershop Depok is a professional barbershop newly established in Depok in 2023. We are dedicated to providing the best 
                            customer experience. We do this by providing high-quality services, a unique customer focus, all in a friendly atmosphere.
                        </p>
                    </div>
                </div>
              
            </div>
        </section>


        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="jumbotron" style="margin-bottom : 70px;">
                    <h1 class="fw-bolder mb-4 text-center">Discount Cool-Guy</h1>
                </div>
                
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($discount as $item) 
                        <div class="col">
                          <div class="card h-100">
                            <img  class="card-img-top" src="{{ url('img/display_discount/')}}/{{ $item->images }}" alt="..." />
                            <div class="card-body">
                              <h5 class="card-title">{{ $item->name }}</h5>
                              <p class="card-text">{{ $item->desc }}</p>
                            </div>
                          </div>
                        </div>
                        @endforeach
                    </div>
                    
            </div>
        </section>

        <!-- Project-->
        

        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="jumbotron" style="margin-bottom: 80px">
                    <h1 class="fw-bolder mb-4 text-center">OUR PRODUCT</h1>
                    
                  </div>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    @foreach ($produk as $produk)
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
                                    <strong>{{ $produk->price }} K</strong>
                                    <p>{{ $produk->slug }}</p>
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
        <!-- Galery-->

        <section class="py-5 bg-light">
            @include('component.galery')
        </section>
       

        <!-- Testimoni -->



        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="jumbotron" style="margin-bottom: 80px">
                    <h1 class="fw-bolder mb-4 text-center">Testimoni User</h1>
                    
                  </div>
                  <div class="row text-center mb-5">
                    @foreach($testimonie as $item) 
                      <div class="col-md-4 mb-5 mb-md-0">
                        <div class="d-flex justify-content-center mb-4">
                          <img src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?w=740&t=st=1690740322~exp=1690740922~hmac=6a92436de76b088a08ffd6d57909cdc9d2ecea3e76540adb5270e33e320846e5"
                            class="rounded-circle shadow-1-strong" width="150" height="150" />
                        </div>
                        <h5 class="mb-3">{{ $item->nama_user }}</h5>
                        <h6 class="text-primary mb-3">
                        @if ($item->penilaian == 1)
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                          @elseif($item->penilaian == 2)
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                          @elseif($item->penilaian == 3)
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                          @elseif($item->penilaian == 4)
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                          @elseif($item->penilaian == 5)
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                              <i class="bi bi-star-fill" style="color:orangered"></i>
                          @endif
                        </h6>
                        <p class="px-xl-3">
                          <i class="fas fa-quote-left pe-2"></i>{{ $item->isi }}
                        </p>
                        <ul class="list-unstyled d-flex justify-content-center mb-0">
                          <li>
                            <i class="fas fa-star fa-sm text-warning"></i>
                          </li>
                          <li>
                            <i class="fas fa-star fa-sm text-warning"></i>
                          </li>
                          <li>
                            <i class="fas fa-star fa-sm text-warning"></i>
                          </li>
                          <li>
                            <i class="fas fa-star fa-sm text-warning"></i>
                          </li>
                          <li>
                            <i class="fas fa-star-half-alt fa-sm text-warning"></i>
                          </li>
                        </ul>
                      </div>
                      @endforeach
                    </div>
            </div>
        </section>
        
        
        <section class="py-5 bg-light">
            <div class="container">
                <div class="jumbotron" style="margin-bottom: 80px">
                    <h1 class="fw-bolder mb-4 text-center">LOCATION</h1>
                </div>
                    <div class="container-fluid" style="margin-bottom: 100px">
                        <div class="map-responsive" style="overflow:hidden; padding-bottom:50%; position:relative; height:0;">
                    <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=Cool+Guy+Barbershop+Siliwangi+Depok/@-6.4006639,106.8256014,17z/data=!3m1!4b1!4m14!1m7!3m6!1s0x2e69ebb6ac82676d:0x7cf98251d0e7f15a!2sCool+Guy+Barbershop+Siliwangi+Depok!8m2!3d-6.4006639!4d106.8281763!16s%2Fg%2F11sk0t2r0_!3m5!1s0x2e69ebb6ac82676d:0x7cf98251d0e7f15a!8m2!3d-6.4006639!4d106.8281763!16s%2Fg%2F11sk0t2r0_?entry=ttu" width="600" height="450" frameborder="0" style="border:0 left:0; top:0; height:100%; width:100%; position:absolute;" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
       
        <!-- Contact-->
        <section class="contact-section bg-black">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Address</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50">Depan BPJSketenagakerjaan Depok, Jl. Sersan Anning No.3, Kota Depok, Jawa Barat 16431</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Email</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50"><a href="#!">{{ $wa->email }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="card py-4 h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-mobile-alt text-primary mb-2"></i>
                                <h4 class="text-uppercase m-0">Phone</h4>
                                <hr class="my-4 mx-auto" />
                                <div class="small text-black-50">{{ $wa->hp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="social d-flex justify-content-center">
                    <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                    <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                    <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </section>
        

        <!-- WhatsUp -->
        <a href="https://api.whatsapp.com/send?phone={{ $wa->hp }}&text=Hallo%21%20Admin%20%20Cool%20GUY." class="float" style="position:fixed; width:60px; height:60px; bottom:40px; right:40px; background-color:#25d366;
        color:#FFF; border-radius:50px; text-align:center; font-size:30px; box-shadow: 2px 2px 3px #999;z-index:100;" target="_blank">
        <i class="fa-brands fa-whatsapp" style="margin-top:16px;"></i>
        </a>
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; Your Website 2023</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{ asset('js/scripts.js') }}"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
