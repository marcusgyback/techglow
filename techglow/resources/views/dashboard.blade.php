@extends('frontend.partner.master')
@section('content')
<section class="menu-bg gradient-bg">

</section>
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-4 pb-5">
            @if($partnerInfo)
            <div class="customer-card pb-3">
                <div class="customer-card-cover" style="background-color: #3e0f3d;">
                    <!--a class="btn btn-style-1 btn-white btn-sm" href="#" data-toggle="tooltip" title="" data-original-title="You currently have 290 Reward points to spend"><i class="fa fa-award text-md"></i>&nbsp;290 points</a-->
                </div>
                <div class="customer-card-profile">
                    <div class="customer-card-avatar"><img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Daniel Adams">
                    </div>
                    <div class="customer-card-details">
                        <h5 class="customer-card-name text-lg">{{ $customer->firstname }} {{ $customer->lastname }}</h5><span class="customer-card-position">Partnernivå {{ $partnerInfo->partner_level }}</span>
                    </div>
                </div>
            </div>
            @endif
            <div class="wizard">
                <nav class="list-group list-group-flush">
                    <!--a class="list-group-item" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fe-icon-shopping-bag mr-1 text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">Mina beställningar</div>
                            </div><span class="badge badge-secondary">6</span>
                        </div>
                    </a-->
                    <a class="list-group-item active" href="#"><i class="fe-icon-user text-muted"></i>Inställningar</a>
                </nav>
            </div>
        </div>
        <!-- Profile Settings-->
        <div class="col-lg-8 pb-5">
            <form method="post" action="{{ route('update.profile') }}" class="row">
                @csrf
                <div class="col-md-12">
                    <h4>Allmänt</h4>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-fn">Förnamn</label>
                        <input class="form-control" type="text" id="accountfn" name="accountfn" value="{{ $customer->firstname }}" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-fn">Efternamn</label>
                        <input class="form-control" type="text" id="accountln" name="accountln" value="{{ $customer->lastname }}" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-email">E-mail</label>
                        <input class="form-control" type="email" id="accountemail" name="accountemail" value="{{ $customer->email }}" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-phone">Mobilnummer</label>
                        <input class="form-control" type="text" id="accountphone" name="accountphone" value="{{ $customer->phone }}" required="">
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Leveransaddress</h4>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="accountLevAddress">Address</label>
                        <input class="form-control" type="text" name="accountLevAddress" id="accountLevAddress" value="{{ $levaddress->address }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="accountLevAddress">Postnummer</label>
                        <input class="form-control" type="text" name="accountLevPostalCode" id="accountLevPostalCode" value="{{ $levaddress->postal_code }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="accountLevAddress">Ort / Stad</label>
                        <input class="form-control" type="text" name="accountLevCity" id="accountLevPostalCity" value="{{ $levaddress->city }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Faktureringsaddress</h4>
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="accountLevAddress">Address</label>
                        <input class="form-control" type="text" name="accountBillAddress" id="accountBillAddress" value="{{ $billaddress->address }}" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="accountLevAddress">Postnummer</label>
                        <input class="form-control" type="text" name="accountBillPostalCode" id="accountBillPostalCode" value="{{ $billaddress->postal_code }}" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="accountLevAddress">Ort / Stad</label>
                        <input class="form-control" type="text" name="accountBillCity" id="accountBillCity" value="{{ $billaddress->city }}" required="">
                    </div>
                </div>
                <div class="col-md-12">
                    <h4>Lösenord</h4>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-pass">Nytt lösenord</label>
                        <input name="pass1" class="form-control" type="password" id="account-pass">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-confirm-pass">Nytt lösenord igen</label>
                        <input name="pass2" class="form-control" type="password" id="account-confirm-pass">
                    </div>
                </div>
                <div class="col-12">
                    <hr class="mt-2 mb-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <button type="submit" class="btn btn-style-1 btn-primary" type="button" data-toast="" data-toast-position="topRight" data-toast-type="success" data-toast-icon="fe-icon-check-circle" data-toast-title="Success!" data-toast-message="Your profile updated successfuly.">Spara inställningar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
