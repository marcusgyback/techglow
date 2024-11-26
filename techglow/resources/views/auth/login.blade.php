@extends('frontend.partner.master')
@section('content')
    <section class="menu-bg gradient-bg">

    </section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="img" style="background-image: url({{ URL::to('/img/login-gaming.jpg') }})"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Logga in</h3>
                            </div>
                        </div>
                        <form method="post" action="{{ route('login') }}" class="signin-form">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="label" for="name">Email</label>
                                <input name="email" type="text" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Lösenord</label>
                                <input name="password" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Logga in</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Kom ihåg mig
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a class="login-text" href="#">Glömt lösenord</a>
                                </div>
                            </div>
                        </form>
                        <p class="text-center">Saknar du konto? <a class="login-text" href="{{ URL::to('/') }}/register">Registrera ett här</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
