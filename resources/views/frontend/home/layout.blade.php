<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @stack('styles')
    <title>Hotel</title>

    <!-- Google Font -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet"> -->

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/flaticon.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        <div class="search-icon  search-switch">
            <i class="icon_search"></i>
        </div>
        <div class="header-configure-area">
                            <a href="{{route('rooms.index')}}" class="bk-btn">Booking Now</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                                    <li ><a href="{{route('home')}}">Home</a></li>
                                    <li><a href="{{route('rooms.index')}}">Rooms</a></li>

                                    <li><a href="{{route('blogs.index')}}">News</a></li>
                                    <li><a href="{{route('contact.show')}}">Contact</a></li>
                                </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
             <a href="{{$settings->valueOf('twitter')}}" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="{{$settings->valueOf('facebook')}}" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="{{$settings->valueOf('instagram')}}" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="{{$settings->valueOf('linkedin')}}" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
        <ul class="top-widget">
            <li> <a href="tel:{{$settings->valueOf('phone')}}">{{$settings->valueOf('phone')}}</a></li>
            <li> <a href="mailto:{{$settings->valueOf('email')}}">{{$settings->valueOf('phone')}}</a></li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                   <li> <a href="tel:{{$settings->valueOf('phone')}}">{{$settings->valueOf('phone')}}</a></li>
            <li> <a href="mailto:{{$settings->valueOf('email')}}">{{$settings->valueOf('email')}}</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="{{$settings->valueOf('facebook')}}"><i class="fa fa-facebook"></i></a>
                                <a href="{{$settings->valueOf('twitter')}}"><i class="fa fa-twitter"></i></a>
                                <a href="{{$settings->valueOf('linkedin')}}"><i class="fa fa-linkedin"></i></a>
                                <a href="{{$settings->valueOf('instagram')}}"><i class="fa fa-instagram"></i></a>
                            </div>
                            <a href="{{route('rooms.index')}}" class="bk-btn">Booking Now</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img src="{{url($settings->valueOf('company_logo'))}}" style="width: 40px;" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li ><a href="{{route('home')}}">Home</a></li>
                                    <li><a href="{{route('rooms.index')}}">Rooms</a></li>

                                    <li><a href="{{route('blogs.index')}}">News</a></li>
                                    <li><a href="{{route('contact.show')}}">Contact</a></li>
                                </ul>
                            </nav>
                            <div class="nav-right search-switch">
                                <i class="icon_search"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
@yield('content')

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img src="img/footer-logo.png" alt="">
                                </a>
                            </div>
                            <p>We inspire and reach millions of travelers<br /> across 90 local websites</p>
                            <div class="fa-social">
                                <a href="{{$settings->valueOf('facebook')}}"><i class="fa fa-facebook"></i></a>
                                <a href="{{$settings->valueOf('twitter')}}"><i class="fa fa-twitter"></i></a>
                                <a href="{{$settings->valueOf('linkedin')}}"><i class="fa fa-linkedin"></i></a>
                                <a href="{{$settings->valueOf('instagram')}}"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Contact Us</h6>
                            <ul>
                                <li>{{$settings->valueOf('phone')}}</li>
                                <li>{{$settings->valueOf('email')}}</li>
                                <li>{{$settings->valueOf('address')}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>New latest</h6>
                            <p>Get the latest updates and offers.</p>
                            <form action="#" class="fn-form">
                                <input type="text" placeholder="Email">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="{{asset('frontend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
    @stack('scripts')
</body>

</html>
