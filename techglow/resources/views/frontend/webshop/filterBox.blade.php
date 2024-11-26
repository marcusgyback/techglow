<div id="filterBox" class="col-md-12" style="display: none;"> <div class="ribbon ribbon-top-right"><span>BETA</span></div>
    <p>
        <input name="price_min" oninput="rangeValueMin.innerText = this.value" value="{{$filters['price']['min']}}" min="{{$filters['price']['min']}}" max="{{$filters['price']['max']}}" step="1" type="range"><br>
        <input name="price_max" oninput="rangeValueMax.innerText = this.value" value="{{$filters['price']['max']}}" min="{{$filters['price']['min']}}" max="{{$filters['price']['max']}}" step="1" type="range">
    <p id="rangeValueMin">{{$filters['price']['min']}}</p>
    <p id="rangeValueMax">{{$filters['price']['max']}}</p>
    </p>
<p>
    @if($filters['brand']->count() > 0)
        <select id="example-multiple-selected" multiple="multiple">
        @foreach($filters['brand'] as $brand)
                <option value="{{$brand->id}}">{{$brand->name}}</option>
        @endforeach
        </select>
    @endif
</p>
</div>

<div class="col-md-12">
    <button id="toggleFilterBox" class="form-control btn btn-primary rounded submit px-3">Filtrera</button>
</div>

@section('head-script')
    @parent
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}"/>
@endsection
@section('content-script')
    <script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
    @parent
    <script>
        $(function() {
            $('#toggleFilterBox').on('click', function() {
                $('#filterBox').slideToggle();
                $('#toggleFilterBox').toggle();
                $('#example-multiple-selected').multiselect();
            });
        });
    </script>
    <style>
        /* common */
        .ribbon {
            width: 150px;
            height: 150px;
            overflow: hidden;
            position: absolute;
        }
        .ribbon::before,
        .ribbon::after {
            position: absolute;
            z-index: -1;
            content: '';
            display: block;
            border: 5px solid #6610f2;
        }
        .ribbon span {
            position: absolute;
            display: block;
            width: 225px;
            padding: 15px 0;
            background-color: #6610f2;
            box-shadow: 0 5px 10px rgba(0,0,0,.1);
            color: #fff;
            font: 700 18px/1 'Lato', sans-serif;
            text-shadow: 0 1px 1px rgba(0,0,0,.2);
            text-transform: uppercase;
            text-align: center;
        }

        /* top right*/
        .ribbon-top-right {
            top: -10px;
            right: -10px;
        }
        .ribbon-top-right::before,
        .ribbon-top-right::after {
            border-top-color: transparent;
            border-right-color: transparent;
        }
        .ribbon-top-right::before {
            top: 0;
            left: 0;
        }
        .ribbon-top-right::after {
            bottom: 0;
            right: 0;
        }
        .ribbon-top-right span {
            left: -25px;
            top: 30px;
            transform: rotate(45deg);
        }
    </style>
@endsection