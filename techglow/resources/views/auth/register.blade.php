@extends('frontend.partner.master')
@section('content')
    <section class="menu-bg gradient-bg">

    </section>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100 p-md-5">
            <div class="col">
                <div class="card card-registration my-4">
                    <div class="row g-0">
                        <div class="col-xl-6 d-none d-xl-block">
                            <img src="https://images.pexels.com/photos/9072214/pexels-photo-9072214.jpeg?auto=compress&cs=tinysrgb&w=1600"
                                 alt="Sample photo" class="img-fluid"
                                 style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                        </div>
                        <div class="col-xl-6">
                            <div class="card-body text-black">
                                <h3 class="mb-5 text-uppercase">Skapa ett konto</h3>
                                <form method="post" action="{{ route('create.profile') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Personnummer</label>
                                                <input name="ssn" type="text" class="@if($errors->has('ssn')) is-invalid @endif form-control" placeholder="Personnummer *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Förnamn</label>
                                                <input name="firstname" type="text" class="@if($errors->has('firstname')) is-invalid @endif form-control" placeholder="Förnamn *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Efternamn</label>
                                                <input name="lastname" type="text" class="@if($errors->has('lastname')) is-invalid @endif form-control" placeholder="Efternamn *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Mobilnummer</label>
                                                <input name="mobilephone" type="text" class="@if($errors->has('mobilephone')) is-invalid @endif form-control" placeholder="Mobilnummer *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Email</label>
                                                <input name="email" type="text" class="@if($errors->has('email')) is-invalid @endif form-control" placeholder="Email *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Repetera Email</label>
                                                <input name="email2" type="text" class="@if($errors->has('email2')) is-invalid @endif form-control" placeholder="Repetera Email *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Lösenord</label>
                                                <input name="pass1" type="password" class="@if($errors->has('pass1')) is-invalid @endif form-control" placeholder="Lösenord *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="label" for="name">Repetera lösenordet</label>
                                                <input name="pass2" type="password" class="@if($errors->has('pass2')) is-invalid @endif form-control" placeholder="Repetera lösenordet *" required="">
                                                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end pt-3">
                                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Registrera</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
