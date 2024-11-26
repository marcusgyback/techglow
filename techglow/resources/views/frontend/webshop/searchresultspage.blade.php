@extends('frontend.partner.master')
@section('content')
    <section class="menu-bg gradient-bg">

    </section>
    <div class="container">
        <div class="col-md-12 bg-white mt-4">
            <div class="col-md-12">
                <form action="{{ route('searchResults') }}" method="get">
                    <input name="query" class="searchBox" type="text" value="{{ $searchQuery }}">
                </form>
            </div>
            <!--div class="col-md-2">
                <button class="btn btn-primary mt-4 rounded-0"><i class="fa fa-filter"></i> Filtrera</button>
            </div-->

            <div class="col-md-12">

                <p>
                    @if($searchQuery)
                        Din sökning på <b>"{{ $searchQuery }}"</b> gav {{ $productsCount }} resultat
                   @endif
                </p>
            </div>
        </div>
        @if($products)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-3 mt-3 mb-3">
                    <div class="wrapper">
                        <div class="container">
                            <a href="/product/{{$product->slug}}">
                                <div class="top" style="background: url({{ $product->getImages()?->first()?->getUrl('product') }}) no-repeat center center; height: 80%;width: 100%;"></div>
                            </a>
                            <div class="bottom">
                                <div class="left">
                                    <div class="details">
                                        <h1>{{ $product->name }}</h1>
                                        <p>{{ number_format((float)$product->getSellingPrice() / 100, 2, '.', '') }} SEK</p>
                                    </div>
                                    <div class="buy"><a href="{{ route('add.to.cart', $product->id) }}"><i class="material-icons">add_shopping_cart</i></a></div>
                                </div>
                                <div class="right">
                                    <div class="done"><i class="material-icons">done</i></div>
                                    <div class="details">
                                        <h1>{{ $product->name }}</h1>
                                        <p>Är tillagd i din varukorg</p>
                                    </div>
                                    <div class="remove"><i class="material-icons">clear</i></div>
                                </div>
                            </div>
                        </div>
                        <div class="inside">
                            <div class="icon"><i class="material-icons">info_outline</i></div>
                            <div class="contents">
                                <div class="col-md-12 product-info-text">
                                    {!! strip_tags(str_replace("\n", "<br />", Str::limit($product->description, 310))) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                @if ($products->links()->paginator->hasPages())
                    <div class="mb-3 box has-text-centered">
                        {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection
