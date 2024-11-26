@extends('frontend.partner.master')
@section('content')
<section class="hero-section">
    <div class="hero-slider owl-carousel">
        <div class="hero-item set-bg d-flex align-items-center justify-content-center text-center"
             data-setbg="img/slider-bg-1.jpg">
            <div class="container">
                <h2>Tjäna extra</h2>
                <p style="padding-top: 2rem;">12 streamers har chansen att ansöka och tjäna extra pengar på sin stream genom oss.<br/>
                Som partner får du även ta del av härliga fördelar som bara finns för våra partners.</p>
                <a href="{{ route('partner-registration') }}" class="site-btn">Ansök <img src="img/icons/double-arrow.png" alt="#"/></a>
            </div>
        </div>

    </div>
</section>

<!--section class="featured-section">
    <div class="featured-bg set-bg" data-setbg="img/featured-bg.jpg"></div>
    <div class="featured-box">
        <div class="text-box">
            <div class="top-meta">11.11.18 / in <a href="">Games</a></div>
            <h3>The game you’ve been waiting for is out now</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Ipsum dolor sit amet, consectetur
                adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquamet, consectetur
                adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Vestibulum posuere
                porttitor justo id pellentesque. Proin id lacus feugiat, posuere erat sit amet, commodo ipsum. Donec
                pellentesque vestibulum metus...</p>
            <a href="#" class="read-more">Read More <img src="img/icons/double-arrow.png" alt="#"/></a>
        </div>
    </div>
</section-->

<section class="partner-benefits">
    <div class="benefits" id="benefits">
        <div class="container">
            <div class="benefits-title">
                <h3>Fördelar som partner</h3>
            </div>
            <div class="benefits-grids">
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-dollar" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>Tjänar pengar</h5>
                            <p>När någon köper genom din länk hos oss får du alltid 30-50% tillbaka i cash. Detta baseras på vinsten av köpet och vilken nivå du ligger på.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-percentage" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>Exklusiva rabatter</h5>
                            <p>Våra partners får ta del av exklusiva rabatter och erbjudanden på produkter som vi säljer. Rabatterna är specielt framtagna för partners.</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-trophy" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>Tävlingar</h5>
                            <p>Som partner får du vara med i tävlingar och har chansen till att vinna grymma priser både inom hård och mjukvara!</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>Försläpppa produkter</h5>
                            <p>Som partner får du se och köpa vissa produkter innan de släpps till försäljning för kunderna på webbshoppen. Du blir alltså först med det senaste!</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>Utlottningar</h5>
                            <p>Du får vara med om utlottningar i form av spelkoder, presentkort etc. Dessa kommer köras lite då och då i samband med mindre och större event!</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="col-md-4 w3ls-benefits-grid">
                    <div class="benefits-icon-grid">
                        <div class="icon-left">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                        </div>
                        <div class="icon-right">
                            <h5>IRL events</h5>
                            <p>Vi tror på att ha kul tillsammans, därför kommer vi ha events för våra partners där vi kan ses, göra saker tillammans, ha kul och skapa ett bra team!</p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>
</section>

<section class="partners-section">
    <div class="partners">
        <div class="container">
            <h3>Några av våra partners</h3>
            <div class="partner-grids">
                <div class="row">
                    @foreach($partners as $partner)
                        <div class="col-md-3 mb-5 partner-team-grid">
                            <div class="partner-info">
                                @if(!empty($partner->partner_image))
                                    <img src="{{ $partner->partner_image }}" alt="">
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
@endsection
