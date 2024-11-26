@extends('frontend.partner.master')
@section('content')
<section class="page-top-section set-bg" data-setbg="./img/page-top-bg/2.jpg">
    <div class="page-info">
        <h2>Partner-registrering</h2>
    </div>
</section>

<section class="registration-page">
    <div class="container">
        @if(session('success'))
            <div class="alert partner-alert-success">
                {{session('success')}}
            </div>
        @else
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="list-style: none">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form action="{{ route('store.partner') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h4 class="mb-4">Allmänt</h4>
            <div class="registration-form col-md-6 pl-0">
                <input name="first_name" type="text" placeholder="Förnamn">
            </div>
            <div class="registration-form col-md-6 pl-0">
                <input name="last_name" type="text" placeholder="Efternamn">
            </div>
            <div class="registration-form col-md-6 pl-0">
                <input name="email" type="email" placeholder="E-mail">
            </div>
            <div class="registration-form col-md-6 pl-0">
                <input name="email2" type="email" placeholder="Verifiera din E-mail">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="mobile" type="text" placeholder="Mobilnummer">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="ssn" type="number" placeholder="Personnummer (ÅÅÅÅMMDDXXXX)">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="address" type="text" placeholder="Address">
            </div>
            <div class="registration-form col-md-6 pl-0">
                <input name="postal_code" type="text" placeholder="Postnummer">
            </div>
            <div class="registration-form col-md-6 pl-0">
                <input name="city" type="text" placeholder="Stad">
            </div>
            <h4 class="mt-4 mb-4">Sociala medier</h4>
            <div class="registration-form col-md-12 pl-0">
                <input name="twitch_url" type="text" placeholder="Twitch">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="youtube_url" type="text" placeholder="Youtube">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="instagram_url" type="text" placeholder="Instagram">
            </div>
            <div class="registration-form col-md-12 pl-0">
                <input name="facebook_url" type="text" placeholder="Facebook">
            </div>
            <button class="site-btn mt-5">Skicka ansökan<img src="img/icons/double-arrow.png" alt="#"></button>
        </form>
        @endif
    </div>
</section>
@endsection
