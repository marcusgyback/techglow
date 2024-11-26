<!doctype html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>Techglow</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('head-script')
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="https://matomo.techglow.se/";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '1']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>
<body>
<div class="preloader">
    <div class="loader"></div>
</div>
@php $total = 0 @endphp
@foreach((array) session('cart') as $details)
    @php $total += $details['price'] * $details['quantity'] / 100 @endphp
@endforeach
<div class="modal fade" id="searchModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 15px;">
                <h4>Sök produkt</h4>
            </div>
            <div class="modal-body" style="padding:20px 15px;">
                <form action="{{ route('searchResults') }}" method="get">
                    <input type="text" name="query" class="search" id="site-search" placeholder="Sök produkt...">
                    <hr>
                    <div id="search-results">

                    </div>
                    <div id="search-show-more">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Se fler resultat</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<div id="mySidenav" class="sidenav" style="display: none">
    <a href="#" class="closeMenuBtn">×</a>
    <a class="parentMenu" href="{{ url('/') }}">Start</a>
    <a class="parentMenu searchBtn hide-desktop hide-ipad" href="#">Sök</a>
    <a class="parentMenu hide-desktop hide-ipad" href="{{ url('/login') }}">Logga in</a>
    @foreach(\App\Models\Product\Menu::tree() as $menu)
        <a data-id="{{ $menu->slug }}" class="parentMenu @if($menu->children()->count() > 0) parentMenuOpen @endif" href="/c/{{ $menu->slug }}">
        {{ $menu->title }}
        @if($menu->children()->count() > 0)
            <span class="expandMenu fa fa-plus"></span>
        @endif
        </a>
        @foreach($menu->children()->get() as $children)
            <a href="/c/{{ $children->slug }}" class="childMenu {{ $menu->slug }}" style="display: none;">{{ $children->title }}</a>
        @endforeach
    @endforeach
</div>
<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand d-md-none" href="{{ URL::to('/') }}">
            <div class="site-logo mb-3 mt-3">
                <img data-link="{{ URL::to('/') }}" src="{{ URL::to('/') }}/img/techglow-logo-white.png" alt="">
            </div>
        </a>
        <a class="nav-link nav-item tg-cart-trigger hide-desktop hide-ipad" href="{{ Route('view.cart') }}">
            <i class="fa fa-shopping-cart"></i> {{ number_format((float)$total, 2, '.', '') }} SEK
        </a>
        <button id="mobile-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item nav-link menu">
                    <i class="fa fa-bars"></i> Meny
                </li>
                <li class="nav-item nav-link searchBtn">
                    <i class="fa fa-search"></i> Sök
                </li>
                <div class="site-logo">
                    <a href="{{ URL::to('/') }}">
                        <img data-link="{{ URL::to('/') }}" src="{{ URL::to('/') }}/img/techglow-logo-white.png" alt="">
                    </a>
                </div>
                <li class="nav-item">
                    @if((!Auth::check()))
                        <a class="nav-link" href="/login">
                            <i class="fa fa-user"></i> Logga in
                        </a>
                    @else
                        <div class="dropdown">
                            <a href="#" class="dropbtn nav-link">Mitt konto</a>
                        </div>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link tg-cart-trigger" href="{{ Route('view.cart') }}">
                        <i class="fa fa-shopping-cart"></i> {{ number_format((float)$total, 2, '.', '') }} SEK
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="dropdown-content">
    <a href="/dashboard">Inställningar</a>
    <!--a href="#">Mina köp</a-->
    <a href="{{ Route('logout') }}">Logga ut</a>
</div>
<div id="tg-shadow-layer"></div>
<div id="tg-cart">
    <h2>Din varukorg</h2>
    <ul class="tg-cart-items">
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                <li>
                    <span class="tg-qty">{{ $details['quantity'] }}&nbsp;x&nbsp;</span> {{ $details['name'] }}
                    <div class="tg-price">{{ number_format((float)$details['price'] / 100, 2, '.', '') }} SEK</div>
                    @if($details['name'] !== 'Frakt')
                        <div class="tg-remove"><a href="#0"><i class="remove-from-cart fa fa-trash" data-id="{{ $id }}"></i></a></div>
                    @endif
                </li>
            @endforeach
        @endif
    </ul> <!-- tg-cart-items -->

    <div class="tg-cart-total">
        <p>Totalt <span>{{ number_format((float)$total, 2, '.', '') }} SEK</span></p>
    </div> <!-- tg-cart-total -->

    <a href="{{ route('checkout') }}" class="checkout-btn">Till Kassan</a>
</div>
@yield('content')
@if(date('Y-m-d H:i:s') > '2023-05-05 20:00:00')
<footer>
    <div class="row primary">
        <div class="column about">
            <h3>Techglow Solutions AB</h3>
            <p>Orgnr: 559415-1106</p>
            <p>Address: Hubert Laurins väg 3, 17669 Järfälla</p>
            <p>Momsregistreringsnummer: SE559415110601</p>
        </div>
        <div class="column links">
            <h3>Information</h3>
            <ul>
                <li>
                    <a href="{{ URL::to('/terms') }}">Köpvillkor</a>
                </li>
                <li>
                    <a href="{{ URL::to('/terms') }}#angerratt-och-returer">Returpolicy</a>
                </li>
                <li>
                    <a href="{{ Route('contact') }}">Kontakta oss</a>
                </li>
            </ul>
        </div>
        <div class="column links">
            <h3>Om Techglow</h3>
            <ul>
                <li>
                    <a href="/register">Skapa konto</a>
                </li>
                <li>
                    <a href="/login">Logga in</a>
                </li>
                <li>
                    <a href="{{ Route('contact') }}">Support</a>
                </li>
            </ul>
        </div>
        <div class="column subscribe">
            <h3>Nyhetsbrev</h3>
            <div>
                <form action="https://techglow.se/store/subscriber" method="post" class="newsletter-form">
                    @csrf
                    <input name="email" type="email" placeholder="Ange din e-mail">
                    <button class="site-btn">Prenumerera <img src="https://techglow.se/img/icons/double-arrow.png" alt="#"></button>
                </form>
            </div>
        </div>
    </div>
</footer>
@endif
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.sticky-sidebar.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/main.js?230507') }}"></script>
<script src="{{ asset('js/modernizr.js') }}"></script>
<script src="{{ asset('js/lightslider.js') }}"></script>
@yield('content-script')
</body>
</html>
