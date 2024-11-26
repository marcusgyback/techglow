@extends('frontend.partner.master')
@section('content')
    <section class="menu-bg gradient-bg">

    </section>
    <div class="container mt-5 mb-5">
        @if(session('cart'))
        <div class="col-md-6">
            {!! $html_snippet !!}
        </div>
        <div class="col-md-6">
            <h3>Din beställning</h3>
            <hr>
            @foreach(session('cart') as $id => $details)
                <ul class="tg-cart-items">
                    <li>
                        <span class="tg-qty">{{ $details['quantity'] }}&nbsp;x&nbsp;</span> {{ $details['name'] }}
                        <div class="tg-price">{{ number_format((float)$details['price'] / 100, 2, '.', '') }} SEK</div>
                    </li>
                    <hr>
                </ul>
            @endforeach
        </div>
        @else
        <h3>
            Hoppsan...
        </h3>
        <p>Det ser ut som att din varukorg är tom.</p>
        @endif
    </div>
@endsection
