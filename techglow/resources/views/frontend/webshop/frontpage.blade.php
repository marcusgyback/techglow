@extends('frontend.partner.master')
@section('content')
    @if(date('Y-m-d H:i:s') < '2023-05-05 21:00:00')
        <div class="main-area">
            <div class="full-height position-static">

                <section class="left-section full-height" style="background-image: url({{ URL::to('/img/login-gaming.jpg') }}); background-size: cover; background-position: bottom;">

                    <div class="display-table center-text">
                        <div class="display-table-cell">
                            <div id="tg-countdown"></div>
                        </div>
                    </div>

                </section>

                <section class="right-section">
                    <div class="display-table" style="background-color: white;">
                        <div class="display-table-cell">
                            <div class="main-content">
                                <div class="container">
                                    <a style="display: flex; justify-content: center" href="{{ URL::to('/') }}">
                                        <img src="{{ URL::to('/') }}/img/techglow-logo.png" alt="Logo">
                                    </a>
                                    <h2 class="mb-4 text-center">Några av våra partners</h2>
                                    <div class="row">
                                        @foreach($OpeningPartners as $partner)
                                            <div class="col-md-4 mb-5 partner-team-grid">
                                                <div class="partner-info ml-3">
                                                    @if(($partner->image))
                                                        <img src="{{ $partner->getImages()->first()->getUrl('partner260x515') }}" alt="">
                                                    @else
                                                        <img src="images/partners/missing-image.png" alt="">
                                                    @endif
                                                    <div class="partner-caption">
                                                        <h4>{{ $partner->twitch_url }}</h4>
                                                        <p>&nbsp;</p>
                                                        <ul>
                                                            @if(!empty($partner->twitch_url))
                                                                @if(str_starts_with($partner->twitch_url, 'https://'))
                                                                    <li><a target="_blank" href="{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                                @elseif(str_starts_with($partner->twitch_url, 'http://'))
                                                                    <li><a target="_blank" href="{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                                @else
                                                                    <li><a target="_blank" href="https://www.twitch.tv/{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                                @endif
                                                            @endif
                                                            @if(!empty($partner->instagram_url))
                                                                <li><a target="_blank" href="{{ $partner->instagram_url }}"><i class="fab fa-instagram"></i></a></li>
                                                            @endif
                                                            @if(!empty($partner->youtube_url))
                                                                <li><a target="_blank" href="{{ $partner->youtube_url }}"><i class="fab fa-youtube"></i></a></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    @elseif(date('Y-m-d H:i:s') > '2023-05-05 21:00:00')
    <section class="hero-section">
        <div class="hero-slider owl-carousel">
            <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center"
                 data-setbg="img/start_page_banner_2023_05_05.jpg">
            </div>
        </div>
    </section>

    <section class="usps">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="usp-box">
                        <div class="usp-icon">
                            <div class="fas fa-shipping-fast"></div>
                        </div>
                        <div class="usp-text-holder">
                            <b class="usp-text-header">Ordrar skickas samma dag</b>
                            <p class="usp-text">Gäller alla ordrar som läggs innan 19:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="usp-box">
                        <div class="usp-icon">
                            <div class="fas fa-box"></div>
                        </div>
                        <div class="usp-text-holder">
                            <b class="usp-text-header">Fri frakt</b>
                            <p class="usp-text">På alla ordrar över 2500 SEK</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="usp-box">
                        <div class="usp-icon">
                            <div class="fas fa-warehouse"></div>
                        </div>
                        <div class="usp-text-holder">
                            <b class="usp-text-header">Över 30 000 produkter</b>
                            <p class="usp-text">Vi har alltid över 30 000 produkter på lager</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-section">
        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col-md-6 mt-3">
                    <a href="{{ URL::to('/') }}/c/datorchassi">
                        <img class="img-fluid" src="img/atx-banner.jpg" />
                    </a>
                </div>
                <div class="col-md-6 mt-3">
                    <a href="{{ URL::to('/') }}/c/grafikkort">
                        <img class="img-fluid" src="img/grafikkort-banner.jpg" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if(count($campaignProducts))
    <section class="product-section">
        <div class="container">
            <h3>På kampanj just nu!</h3>
            <div class="row">
                @foreach($campaignProducts as $campaignProduct)
                <div class="col-md-3">
                    <div class="wrapper">
                        <div class="container">
                            <div class="top" style="background: url({{ $campaignProduct->getImages()?->first()?->getUrl('product') }}) no-repeat center center; height: 80%;width: 100%;"></div>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>{{ $campaignProduct->name }}</h1>
                                        <p>{{ number_format((float)$campaignProduct->getSellingPrice() / 100, 2, '.', '') }} SEK</p>
                                    </div>
                                    <div class="buy"><a href="{{ route('add.to.cart', $campaignProduct->id) }}"><i class="material-icons">add_shopping_cart</i></a></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>{{ $campaignProduct->name }}</h1>
                                        <p>Är tillagd i din varukorg</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
                            <div class="contents">
                                <div class="col-md-12">
                                    <p style="margin-left: -10px">{!! strip_tags(str_replace("\n", "<br />", Str::limit($campaignProduct->description, 310))) !!}</p>
                                </div>
                                <div class="col-md-12">
                                    <a href="/product/{{$campaignProduct->slug}}" class="showProductInfo">Visa mer info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(count($startPageProducts))
        <section class="product-section">
            <div class="container">
                <h3>Utvalda produkter</h3>
                <div class="row">
                    @foreach($startPageProducts as $startPageProduct)
                        <div class="col-md-3">
                            <div class="wrapper">
                                <div class="container">
                                    <a href="/product/{{$startPageProduct->slug}}">
                                        <div class="top" style="background: url({{ $startPageProduct->getImages()?->first()?->getUrl('product') }}) no-repeat center center; height: 80%;width: 100%;"></div>
                                    </a>
                                    <div class="bottom">
                                        <div class="left">
                                            <div class="details">
                                                <h1>{{ $startPageProduct->name }}</h1>
                                                <p>{{ number_format((float)$startPageProduct->getSellingPrice() / 100, 2, '.', '') }} SEK</p>
                                            </div>
                                            <div class="buy"><a href="{{ route('add.to.cart', $startPageProduct->id) }}"><i class="material-icons">add_shopping_cart</i></a></div>
                                        </div>
                                        <div class="right">
                                            <div class="done"><i class="material-icons">done</i></div>
                                            <div class="details">
                                                <h1>{{ $startPageProduct->name }}</h1>
                                                <p>Är tillagd i din varukorg</p>
                                            </div>
                                            <div class="remove"><i class="material-icons">clear</i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="inside">
                                    <div class="icon"><i class="material-icons">info_outline</i></div>
                                    <div class="contents">
                                        <div class="col-md-12">
                                            <p style="margin-left: -10px">{!! strip_tags(str_replace("\n", "<br />", Str::limit($startPageProduct->description, 310))) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($partners))
    <section class="partners-section">
        <div class="partners">
            <div class="container">
                <h3>Några av våra partners</h3>
                <div class="partner-grids">
                    <div class="row">
                        @foreach($partners as $partner)
                            <div class="col-md-3 mb-5 partner-team-grid">
                                <div class="partner-info">
                                    @if(($partner->image))
                                        <img src="{{ $partner->getImages()->first()->getUrl('partner260x515') }}" alt="">
                                    @else
                                        <img src="images/partners/missing-image.png" alt="">
                                    @endif
                                    <div class="partner-caption">
                                        <h4>{{ $partner->twitch_url }}</h4>
                                        <p>&nbsp;</p>
                                        <ul>
                                            @if(!empty($partner->twitch_url))
                                                @if(str_starts_with($partner->twitch_url, 'https://'))
                                                    <li><a target="_blank" href="{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                @elseif(str_starts_with($partner->twitch_url, 'http://'))
                                                    <li><a target="_blank" href="{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                @else
                                                    <li><a target="_blank" href="https://www.twitch.tv/{{ $partner->twitch_url }}"><i class="fab fa-twitch"></i></a></li>
                                                @endif
                                            @endif
                                            @if(!empty($partner->instagram_url))
                                                <li><a target="_blank" href="{{ $partner->instagram_url }}"><i class="fab fa-instagram"></i></a></li>
                                            @endif
                                            @if(!empty($partner->youtube_url))
                                                <li><a target="_blank" href="{{ $partner->youtube_url }}"><i class="fab fa-youtube"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @endif
@endsection
