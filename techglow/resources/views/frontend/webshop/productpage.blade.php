@extends('frontend.partner.master')
@section('content')
    @php
            $brand = $product->brand()->first()?->name;
    @endphp
    <section class="menu-bg gradient-bg">

    </section>
    <div class="container">
        <div class="col-md-5 col-12 mt-4 pl-0">
            <div class="clearfix" style="max-width:474px;">
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                    @if($product->getImages())
                        @foreach($product->getImages() as $image)
                            <li data-thumb="{{ $image->getUrl('thumbnail90') }}">
                                <img src="{{ $image->getUrl('productpage') }}" />
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-md-7 col-12 mt-4" style="background: lightgrey; padding-top: 15px;">
            <span class="tc-product-title">
                {{ $product->name }}
            </span>
            <p>Pris {{ number_format((float)$product->getSellingPrice() / 100, 2, '.', ' ') }} SEK</p>
            <a class="buybutton" href="{{ route('add.to.cart', $product->id) }}">Köp nu</a>
        </div>
        <div class="col-md-12 col-12 mt-4 product-tabs pl-0 pr-0">
            <ul class="tabs">
                <li class="tab-switcher tab-switcher-active" data-tab-index="0" tabindex="0">
                    Beskrivning
                </li>
                @if(Auth::check() && Auth::user()->isAdministrator())
                <li class="tab-switcher" data-tab-index="10" tabindex="10">
                    Admin
                </li>
                @endif
            </ul>
            <div id="allTabsContainer">
                <div class="tab-container" data-tab-index="0">
                    <p>{!! $product->description  !!}</p>
                </div>
                <div class="tab-container" data-tab-index="1" style="display:none;">

                </div>
                <div class="tab-container" data-tab-index="2" style="display:none;">

                </div>
                @if(Auth::check() && Auth::user()->isAdministrator())
                <div class="tab-container" data-tab-index="10" style="display:none;">
                <form action="{{ route('product.update', $product->id) }}" method="post">@csrf
                    <table width="100%">
                        <tr>
                            <td  width="50%" valign="top">
                                <ul>
                                    <li><b>Märke:</b> {{$brand}}</li>
                                    <li><b>BigBuy SKU:</b><input type="text" name="bb_sku" id="bb_sku" value="{{$product->bb_sku}}"></li>
                                    <li><b>Despec SKU:</b><input type="text" name="despec_sku" id="despec_sku" value="{{$product->despec_sku}}"></li>
                                    <li><b>EAN:</b> {{$product->ean}}</li>
                                    <li><b>SKU:</b> {{$product->our_art_no}}</li>
                                    <li><b>Lager:</b> {{$product->stock}}st</li>
                                    <li><b>Publicerad:</b>
                                        <input type="radio" id="html" name="published" value="1"  @if($product->published == "1") checked @endif> Ja
                                        <input type="radio" id="html" name="published" value="0"  @if($product->published == "0") checked @endif> Nej
                                    <li><b>Marginal mål:</b><input type="number" size="4" name="margin_target" id="margin_target" value="{{$product->margin_target}}">%</li>
                                    <li><b>Kemikalieskatt:</b> {{$product->kem_tax_amount}} SEK ({{$product->kem_tax_percentage}}%)</li>
                                    <li><b>Kemikalieskatt typ:</b><select name="kem_tax">
                                            <option value="others"@if($product->kem_tax == "others") selected="selected" @endif>Övrig elektronik</option>
                                            <option value="appliances"@if($product->kem_tax == "appliances") selected="selected" @endif>Vitvara</option>
                                            <option value="none"@if($product->kem_tax == "none") selected="selected" @endif>Ej elektronik</option>
                                        </select></li>
                                    <li><b>Vikt:</b> {{$product->weight}} KG</li>
                                    @php
                                        $purchasePrice = $product->purchasePrice()->orderBy('valid_from', 'DESC')->first();
                                        $rate = App\Models\Product\ExchangeRates::where("currency_from","=",$purchasePrice->currency)->where("currency_to","=",'SEK')->orderBy("currency_date")->get()->first();
                                        if(!is_null($rate))
                                        {
                                            $rate = 0.0 + $rate->rate;
                                        }else{
                                            $rate = 12.0;
                                        }
                                        $sek = ceil(($rate * $purchasePrice->price_retail));
                                    @endphp
                                    <li><b>Inköpspris:</b> {{$purchasePrice->price_retail}} {{$purchasePrice->currency}} / {{$sek}} SEK ({{$purchasePrice->valid_from}})</li>
                                </ul>
                            </td>
                            <td  width="50%" valign="top">
                                <table>
                                    <tr><td>Försäljningspris</td><td><input type="number" name="selling_price" id="selling_price" value="{{ceil( ($product->getSellingPrice() / 100) )}}"></td></tr>
                                    <tr><td>Kemikalieskatt</td><td><span id="kem_tax_amount">{{$product->kem_tax_amount}}</span> SEK</td></tr>
                                    <tr><td>BigBuy Inköpspris&nbsp;&nbsp;&nbsp;&nbsp;</td><td><span id="purchase_price">{{$sek}}</span> SEK</td></tr>
                                    <tr><td>Moms</td><td><span id="vat"></span> SEK</td></tr>
                                    <tr><td>Vinst</td><td><span id="profit"></span> SEK</td></tr>
                                    <tr><td>Marginal (mål)</td><td><span id="margin"></span> % ({{$product->margin_target}}%)</td></tr>
                                </table>

                            </td>
                        </tr>
                    </table>
                    <button class="buybutton" style="float: right;">Spara</button>
                </form>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@if(Auth::check() && Auth::user()->isAdministrator())
    @section('content-script')
        <script>
            var kem_tax_amount = {{$product->kem_tax_amount}};
            var purchase_price = {{$sek}};
            var margin_target = {{($product->margin_target / 100) * $sek}};
            function calcProfit(selling_price)
            {
                var moms = Math.ceil(selling_price * 0.20);
                $("#vat").text(moms);
                var profit = (selling_price - moms) - kem_tax_amount - purchase_price;
                $("#profit").text(profit);
                var margin = Math.ceil( (profit / purchase_price) * 100 );
                $("#margin").text(margin);
            }
            $("#selling_price").on("input", function() {
                var selling_price = $(this).val();
                calcProfit(selling_price)
            });
            var x =$("#selling_price").val();
            calcProfit(x);
        </script>
    @endsection
@endif
